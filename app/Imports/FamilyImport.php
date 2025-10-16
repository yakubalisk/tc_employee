<?php

namespace App\Imports;

use App\Models\Family;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class FamilyImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Handle date conversion from Excel format
        $dateOfBirth = $this->parseDate($row['date_of_birth'] ?? $row['dt of birth'] ?? null);

        // Handle boolean fields
        $ltc = $this->parseBoolean($row['ltc'] ?? '');
        $medical = $this->parseBoolean($row['medical'] ?? '');
        $gsli = $this->parseBoolean($row['gsli'] ?? '');
        $gpf = $this->parseBoolean($row['gpf'] ?? '');
        $dcrg = $this->parseBoolean($row['dcrg'] ?? '');
        $pension_nps = $this->parseBoolean($row['pension_nps'] ?? $row['pension_nps'] ?? '');

        $employee = Employee::where('empCode', $row['emp_code'])
            // ->orWhere('empCode', $row['emp_code'])
            ->first();

        return new Family([
            'employee_id' => $employee->id,
            'name_of_family_member' => $row['name_of_family_member'] ?? $row['name of family member'] ?? '',
            'relationship' => $row['relationship'] ?? '',
            'date_of_birth' => $dateOfBirth,
            'dependent_remarks' => $row['dependent_remarks'] ?? $row['dependent remarks'] ?? null,
            'reason_for_dependence' => $row['reason_for_dependence'] ?? $row['reason for dependence'] ?? null,
            'ltc' => $ltc,
            'medical' => $medical,
            'gsli' => $gsli,
            'gpf' => $gpf,
            'dcrg' => $dcrg,
            'pension_nps' => $pension_nps,
        ]);
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return now();
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
                            return Carbon::parse($date);
                        } catch (\Exception $e) {
                            return now();
                        }
                    }
                }
            }
        }
        
        return now();
    }

    private function parseBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        $value = strtolower(trim($value));
        return in_array($value, ['yes', 'true', '1', 'y']);
    }
}