<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeImport implements ToModel, WithHeadingRow
{
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

        return new Employee([
            // Personal Information
            'empCode' => $empCode,
            'name' => $row['name'] ?? '',
            'gender' => strtoupper($row['gender'] ?? 'OTHER'),
            'category' => $row['category'] ?? 'General',
            'education' => $row['education'] ?? $row['qualification'] ?? null,
            'mobile' => $this->cleanMobile($row['mobile'] ?? $row['mobile_number'] ?? null),
            'email' => $row['email'] ?? null,
            
            // Employment Details
            'dateOfAppointment' => $dateOfAppointment,
            'designationAtAppointment' => $row['designation_at_appointment'] ?? $row['designation at appointment'] ?? '',
            'designationAtPresent' => $row['designation_at_present'] ?? $row['designation at present'] ?? '',
            'presentPosting' => $row['present_posting'] ?? $row['present posting'] ?? '',
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
            
            // Other fields
            'promotee_transferee' => $row['promotee_transferee'] ?? $row['promotee transferee'] ?? null,
            'pension_file_no' => $row['pension_file_no'] ?? $row['pension file no'] ?? null,
            'increment_month' => $this->parseIncrementMonth($row['increment_month'] ?? $row['increment month'] ?? null),
            'status_of_post' => $row['status_of_post'] ?? $row['status of post'] ?? null,
            'seniority_sequence_no' => $row['seniority_sequence_no'] ?? $row['seniority sequence no'] ?? null,
            'sddlsection_incharge' => $row['sddlsection_incharge'] ?? $row['sddlsection incharge'] ?? null,
            'benevolent_member' => $row['benevolent_member'] ?? $row['benevolent member'] ?? null,
            'office_landline_number' => $row['office_landline_number'] ?? $row['office landline number'] ?? null,
        ]);
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        if (is_numeric($date)) {
            // Excel date (number of days since 1900-01-01)
            return Carbon::create(1900, 1, 1)->addDays($date - 2);
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
                'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12
            ];
            
            $monthLower = strtolower(trim($month));
            if (isset($monthNames[$monthLower])) {
                return $monthNames[$monthLower];
            }
        }
        
        return null;
    }
}