<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use SkipsFailures;

    private $designations;
    private $locations;
    private $importedCount = 0;

    public function __construct()
    {
        $this->designations = Designation::pluck('id', 'name')->toArray();
        $this->locations = Region::pluck('id', 'name')->toArray();
    }

    public function model(array $row)
    {
        // Skip empty rows - check if essential fields are empty
        if ($this->isEmptyRow($row)) {
            return null;
        }
        
        // Handle date conversions
        $dateOfAppointment = $this->parseDate($row['date_of_appointment'] ?? $row['date of appointment'] ?? null);
        $dateOfBirth = $this->parseDate($row['date_of_birth'] ?? $row['date of birth'] ?? null);
        $dateOfRetirement = $this->parseDate($row['date_of_retirement'] ?? $row['date of retirement'] ?? null);


        // Handle checkbox/boolean fields
        $checkboxFields = [
            'office_in_charge' => $this->parseBoolean($row['office_in_charge'] ?? $row['office in charge'] ?? ''),
            'nps' => $this->parseBoolean($row['nps'] ?? ''),
            'probation_period' => $this->parseBoolean($row['probation_period'] ?? $row['probation period'] ?? ''),
            'department' => $this->parseBoolean($row['department'] ?? ''),
            'karmayogi_certificate_completed' => $this->parseBoolean($row['karmayogi_certificate_completed'] ?? $row['karmayogi certificate completed'] ?? ''),
            'benevolent_member' => $this->parseBoolean($row['benevolent_member'] ?? $row['benevolent member'] ?? ''),
        ];

        // Generate unique empCode if not provided
        $empCode = $row['emp_code'] ?? $row['empcode'] ?? $row['employee_code'] ?? null;
        if (!$empCode) {
            $empCode = 'EMP' . Str::random(8);
        }

        // Check if employee already exists
        if (Employee::where('empCode', $empCode)->exists()) {
            return null;
        }

    // Convert designation names to IDs - WITH DEBUGGING
    $designationAppointmentName = $row['designation_at_appointment'] ?? $row['designation at appointment'] ?? '';
    $designationPresentName = $row['designation_at_present'] ?? $row['designation at present'] ?? '';
    $locationName = $row['present_posting'] ?? $row['present posting'] ?? '';
    
    \Log::info("Designation Appointment Name: '{$designationAppointmentName}'");
    \Log::info("Designation Present Name: '{$designationPresentName}'");
    \Log::info("Location Name: '{$locationName}'");
    
    $designationAtAppointmentId = $this->getDesignationId($designationAppointmentName);
    $designationAtPresentId = $this->getDesignationId($designationPresentName);
    $presentPostingId = $this->getLocationId($locationName);
    
    \Log::info("Designation Appointment ID: " . ($designationAtAppointmentId ?? 'NULL'));
    \Log::info("Designation Present ID: " . ($designationAtPresentId ?? 'NULL'));
    \Log::info("Location ID: " . ($presentPostingId ?? 'NULL'));

        // Increment counter
        $this->importedCount++;

        return new Employee([
            'empCode' => $empCode,
            'name' => $row['name'] ?? '',
            'gender' => strtoupper($row['gender'] ?? 'OTHER'),
            'category' => $row['category'] ?? 'General',
            'education' => $row['education'] ?? $row['qualification'] ?? null,
            'mobile' => $this->cleanMobile($row['mobile'] ?? $row['mobile_number'] ?? null),
            'email' => $row['email'] ?? null,
            'dateOfAppointment' => $dateOfAppointment,
            'designationAtAppointment' => $designationAtAppointmentId,
            'designationAtPresent' => $designationAtPresentId,
            'presentPosting' => $presentPostingId,
            'personalFileNo' => $row['personal_file_no'] ?? $row['personal file no'] ?? null,
            'officeLandline' => $row['office_landline'] ?? $row['office landline'] ?? null,
            'dateOfBirth' => $dateOfBirth,
            'dateOfRetirement' => $dateOfRetirement,
            'homeTown' => $row['home_town'] ?? $row['home town'] ?? null,
            'residentialAddress' => $row['residential_address'] ?? $row['residential address'] ?? null,
            'status' => $row['status'] ?? 'EXISTING',
            'office_in_charge' => $checkboxFields['office_in_charge'],
            'nps' => $checkboxFields['nps'],
            'probation_period' => $checkboxFields['probation_period'],
            'department' => $checkboxFields['department'],
            'karmayogi_certificate_completed' => $checkboxFields['karmayogi_certificate_completed'],
            'benevolent_member' => $checkboxFields['benevolent_member'],
            'promotee_transferee' => $row['promotee_transferee'] ?? $row['promotee transferee'] ?? null,
            'pension_file_no' => $row['pension_file_no'] ?? $row['pension file no'] ?? null,
            'increment_month' => $this->parseIncrementMonth($row['increment_month'] ?? $row['increment month'] ?? null),
            'status_of_post' => $row['status_of_post'] ?? $row['status of post'] ?? null,
            'seniority_sequence_no' => $row['seniority_sequence_no'] ?? $row['seniority sequence no'] ?? null,
            'sddlsection_incharge' => $row['sddlsection_incharge'] ?? $row['sddlsection incharge'] ?? null,
            'office_landline_number' => $row['office_landline_number'] ?? $row['office landline number'] ?? null,
        ]);
    }

    /**
     * Check if a row is empty
     */
    private function isEmptyRow($row)
    {
        // Check if essential fields are empty
        $essentialFields = [
            'emp_code', 'name', 'date_of_appointment', 'date_of_birth'
        ];

        foreach ($essentialFields as $field) {
            $value = $row[$field] ?? $row[str_replace('_', ' ', $field)] ?? null;
            if (!empty($value) && trim($value) !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Skip validation for empty rows
     */
    public function rules(): array
    {
        return [
            'emp_code' => function($attribute, $value, $onFailure) {
                // Skip validation for empty rows
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) {
                    return;
                }
                
                // Apply validation only for non-empty rows
                if (empty($value) || trim($value) === '') {
                    $onFailure('Employee code is required');
                } elseif (!preg_match('/^\d{6}$/', $value)) {
                    $onFailure('Employee code must be exactly 6 digits');
                }
            },
            'name' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Employee name is required');
                }
            },
            'gender' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                $validGenders = ['MALE', 'FEMALE', 'OTHER'];
                if (!in_array(strtoupper($value), $validGenders)) {
                    $onFailure('Gender must be MALE, FEMALE or OTHER');
                }
            },
            'category' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                $validCategories = ['General', 'OBC', 'SC', 'ST'];
                if (!in_array($value, $validCategories)) {
                    $onFailure('Category must be General, OBC, SC or ST');
                }
            },
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|digits:10',
            'designation_at_appointment' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Designation at appointment is required');
                }
            },
            'designation_at_present' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Designation at present is required');
                }
            },
            'present_posting' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Present posting is required');
                }
            },
            'status' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                $validStatuses = ['EXISTING', 'RETIRED', 'TRANSFERRED'];
                if (!in_array($value, $validStatuses)) {
                    $onFailure('Status must be EXISTING, RETIRED or TRANSFERRED');
                }
            },
            'office_in_charge' => 'nullable|in:Yes,No',
            'nps' => 'nullable|in:Yes,No',
            'date_of_appointment' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Date of appointment is required');
                }
            },
            'date_of_birth' => function($attribute, $value, $onFailure) {
                $row = $this->getCurrentRow();
                if ($this->isEmptyRow($row)) return;
                
                if (empty($value) || trim($value) === '') {
                    $onFailure('Date of birth is required');
                }
            },
        ];
    }

    /**
     * Track current row for validation
     */
    private $currentRow;

    public function prepareForValidation($data, $index)
    {
        $this->currentRow = $data;
        return $data;
    }

    private function getCurrentRow()
    {
        return $this->currentRow ?? [];
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }

    // ... rest of your methods (getDesignationId, getLocationId, parseDate, etc.)


    public function customValidationMessages()
    {
        return [
            'name.required' => 'Employee name is required',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be MALE, FEMALE or OTHER',
            'designation_at_appointment.required' => 'Designation at appointment is required',
            'designation_at_present.required' => 'Designation at present is required',
            'present_posting.required' => 'Present posting is required',
            'date_of_appointment.required' => 'Date of appointment is required',
            'date_of_birth.required' => 'Date of birth is required',
        ];
    }

    private function getDesignationId($designationName)
    {
        if (empty($designationName)) return null;

        $cleanName = trim($designationName);
        
        if (isset($this->designations[$cleanName])) {
            return $this->designations[$cleanName];
        }

        foreach ($this->designations as $name => $id) {
            if (strcasecmp(trim($name), $cleanName) === 0) {
                return $id;
            }
        }

        return null;
    }

    private function getLocationId($locationName)
    {
        if (empty($locationName)) return null;

        $cleanName = trim($locationName);
        
        if (isset($this->locations[$cleanName])) {
            return $this->locations[$cleanName];
        }

        foreach ($this->locations as $name => $id) {
            if (strcasecmp(trim($name), $cleanName) === 0) {
                return $id;
            }
        }

        return null;
    }

    private function parseDate($date)
    {
        if (empty($date)) return null;

        if (is_numeric($date)) {
            $excelBaseDate = Carbon::create(1899, 12, 30);
            return $excelBaseDate->addDays($date);
        }

        if (is_string($date)) {
            $formats = ['d-M-y', 'd-M-Y', 'd/m/Y', 'm/d/Y', 'Y-m-d'];
            
            foreach ($formats as $format) {
                try {
                    return Carbon::createFromFormat($format, $date);
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            try {
                return Carbon::parse($date);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    private function parseBoolean($value)
    {
        if (is_bool($value)) return $value;
        
        $value = strtolower(trim($value));
        return in_array($value, ['yes', 'true', '1', 'y', 'on']);
    }

    private function cleanMobile($mobile)
    {
        if (empty($mobile)) return null;

        $cleanMobile = preg_replace('/\D/', '', $mobile);
        return strlen($cleanMobile) === 10 ? $cleanMobile : null;
    }

    private function parseIncrementMonth($month)
    {
        if (empty($month)) return null;

        if (is_numeric($month)) {
            $monthInt = (int)$month;
            return ($monthInt >= 1 && $monthInt <= 12) ? $monthInt : null;
        }

        if (is_string($month)) {
            $monthNames = [
                'january' => 1, 'february' => 2, 'march' => 3, 'april' => 4,
                'may' => 5, 'june' => 6, 'july' => 7, 'august' => 8,
                'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12,
                'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
                'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9,
                'oct' => 10, 'nov' => 11, 'dec' => 12
            ];
            
            $monthLower = strtolower(trim($month));
            return $monthNames[$monthLower] ?? null;
        }

        return null;
    }
}