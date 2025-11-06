<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Designation;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $designations;
    private $locations;

    public function __construct()
    {
        // Cache designations and locations for faster lookup
        $this->designations = Designation::pluck('id', 'name')->toArray();
        $this->locations = Location::pluck('id', 'name')->toArray();
    }

    public function model(array $row)
    {
        // Handle date conversions from Excel format
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
        $existingEmployee = Employee::where('empCode', $empCode)->first();
        if ($existingEmployee) {
            return null; // Skip duplicate entries
        }

        // Convert designation names to IDs
        $designationAtAppointmentId = $this->getDesignationId($row['designation_at_appointment'] ?? $row['designation at appointment'] ?? '');
        $designationAtPresentId = $this->getDesignationId($row['designation_at_present'] ?? $row['designation at present'] ?? '');

        // Convert location name to ID
        $presentPostingId = $this->getLocationId($row['present_posting'] ?? $row['present posting'] ?? '');

        return new Employee([
            // Personal Information
            'empCode' => $empCode,
            'name' => $row['name'] ?? '',
            'gender' => strtoupper($row['gender'] ?? 'OTHER'),
            'category' => $row['category'] ?? 'General',
            'education' => $row['education'] ?? $row['qualification'] ?? null,
            'mobile' => $this->cleanMobile($row['mobile'] ?? $row['mobile_number'] ?? null),
            'email' => $row['email'] ?? null,
            
            // Employment Details - Store IDs instead of names
            'dateOfAppointment' => $dateOfAppointment,
            'designationAtAppointment' => $designationAtAppointmentId,
            'designationAtPresent' => $designationAtPresentId,
            'presentPosting' => $presentPostingId,
            'personalFileNo' => $row['personal_file_no'] ?? $row['personal file no'] ?? null,
            'officeLandline' => $row['office_landline'] ?? $row['office landline'] ?? null,
            
            // Personal Details
            'dateOfBirth' => $dateOfBirth,
            'dateOfRetirement' => $dateOfRetirement,
            'homeTown' => $row['home_town'] ?? $row['home town'] ?? null,
            'residentialAddress' => $row['residential_address'] ?? $row['residential address'] ?? null,
            'status' => $row['status'] ?? 'EXISTING',
            
            // Boolean fields
            'office_in_charge' => $checkboxFields['office_in_charge'],
            'nps' => $checkboxFields['nps'],
            'probation_period' => $checkboxFields['probation_period'],
            'department' => $checkboxFields['department'],
            'karmayogi_certificate_completed' => $checkboxFields['karmayogi_certificate_completed'],
            'benevolent_member' => $checkboxFields['benevolent_member'],
            
            // Other fields
            'promotee_transferee' => $row['promotee_transferee'] ?? $row['promotee transferee'] ?? null,
            'pension_file_no' => $row['pension_file_no'] ?? $row['pension file no'] ?? null,
            'increment_month' => $this->parseIncrementMonth($row['increment_month'] ?? $row['increment month'] ?? null),
            'status_of_post' => $row['status_of_post'] ?? $row['status of post'] ?? null,
            'seniority_sequence_no' => $row['seniority_sequence_no'] ?? $row['seniority sequence no'] ?? null,
            'sddlsection_incharge' => $row['sddlsection_incharge'] ?? $row['sddlsection incharge'] ?? null,
            'office_landline_number' => $row['office_landline_number'] ?? $row['office landline number'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'emp_code' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
            'category' => 'required|in:General,OBC,SC,ST',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|digits:10',
            'designation_at_appointment' => 'required|string',
            'designation_at_present' => 'required|string',
            'present_posting' => 'required|string',
            'status' => 'required|in:EXISTING,RETIRED,TRANSFERRED',
            'office_in_charge' => 'nullable|in:Yes,No',
            'nps' => 'nullable|in:Yes,No',
            'date_of_appointment' => 'required|date',
            'date_of_birth' => 'required|date',
        ];
    }

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
        if (empty($designationName)) {
            return null;
        }

        // Clean the designation name for matching
        $cleanName = trim($designationName);
        
        // Exact match
        if (isset($this->designations[$cleanName])) {
            return $this->designations[$cleanName];
        }

        // Case-insensitive match
        foreach ($this->designations as $name => $id) {
            if (strcasecmp(trim($name), $cleanName) === 0) {
                return $id;
            }
        }

        // If not found, you can create a new designation or return null
        // For now, return null and handle the validation in rules
        return null;
    }

    private function getLocationId($locationName)
    {
        if (empty($locationName)) {
            return null;
        }

        $cleanName = trim($locationName);
        
        // Exact match
        if (isset($this->locations[$cleanName])) {
            return $this->locations[$cleanName];
        }

        // Case-insensitive match
        foreach ($this->locations as $name => $id) {
            if (strcasecmp(trim($name), $cleanName) === 0) {
                return $id;
            }
        }

        return null;
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        if (is_numeric($date)) {
            // Excel date (number of days since 1900-01-01)
            // Note: Excel has a bug where it considers 1900 as a leap year
            $excelBaseDate = Carbon::create(1899, 12, 30);
            return $excelBaseDate->addDays($date);
        } elseif (is_string($date)) {
            try {
                return Carbon::createFromFormat('d-M-y', $date);
            } catch (\Exception $e) {
                try {
                    return Carbon::createFromFormat('d-M-Y', $date);
                } catch (\Exception $e) {
                    try {
                        return Carbon::createFromFormat('d/m/Y', $date);
                    } catch (\Exception $e) {
                        try {
                            return Carbon::createFromFormat('m/d/Y', $date);
                        } catch (\Exception $e) {
                            try {
                                return Carbon::createFromFormat('Y-m-d', $date);
                            } catch (\Exception $e) {
                                try {
                                    return Carbon::parse($date);
                                } catch (\Exception $e) {
                                    return null;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return null;
    }

    private function parseBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        $value = strtolower(trim($value));
        return in_array($value, ['yes', 'true', '1', 'y', 'on']);
    }

    private function cleanMobile($mobile)
    {
        if (empty($mobile)) {
            return null;
        }

        // Remove any non-digit characters
        $cleanMobile = preg_replace('/\D/', '', $mobile);
        
        // Check if it's exactly 10 digits
        if (strlen($cleanMobile) === 10) {
            return $cleanMobile;
        }
        
        return null;
    }

    private function parseIncrementMonth($month)
    {
        if (empty($month)) {
            return null;
        }

        if (is_numeric($month)) {
            $monthInt = (int)$month;
            if ($monthInt >= 1 && $monthInt <= 12) {
                return $monthInt;
            }
        } elseif (is_string($month)) {
            $monthNames = [
                'january' => 1, 'february' => 2, 'march' => 3, 'april' => 4,
                'may' => 5, 'june' => 6, 'july' => 7, 'august' => 8,
                'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12,
                'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
                'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9,
                'oct' => 10, 'nov' => 11, 'dec' => 12
            ];
            
            $monthLower = strtolower(trim($month));
            if (isset($monthNames[$monthLower])) {
                return $monthNames[$monthLower];
            }
        }
        
        return null;
    }
}