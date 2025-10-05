<?php

namespace App\Imports;

use App\Models\FinancialUpgradation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class FinancialUpgradationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Handle date conversion from Excel format
        $promotionDate = $this->parseDate($row['promotion_date'] ?? null);
        $dateInGrade = $this->parseDate($row['date_in_grade'] ?? null);

        return new FinancialUpgradation([
            'sr_no' => $row['sr_no'] ?? $row['sr_no'] ?? 0,
            'empl_id' => $row['empl_id'] ?? $row['employee_id'] ?? '',
            'promotion_date' => $promotionDate,
            'existing_designation' => $row['existing_designation'] ?? '',
            'upgraded_designation' => $row['upgraded_designation'] ?? '',
            'date_in_grade' => $dateInGrade,
            'existing_scale' => $row['existing_scale'] ?? '',
            'upgraded_scale' => $row['upgraded_scale'] ?? '',
            'pay_fixed' => $row['pay_fixed'] ?? 'NO',
            'existing_pay' => $row['existing_pay'] ?? 0,
            'existing_grade_pay' => $row['existing_grade_pay'] ?? 0,
            'upgraded_pay' => $row['upgraded_pay'] ?? 0,
            'upgraded_grade_pay' => $row['upgraded_grade_pay'] ?? 0,
            'macp_remarks' => $row['macp_remarks'] ?? null,
            'no_of_financial_upgradation' => $row['no_of_financial_upgradation'] ?? 1,
            'financial_upgradation_type' => $row['financial_upgradation_type'] ?? 'MACP',
            'region' => $row['region'] ?? null,
            'department' => $row['department'] ?? null,
        ]);
    }

    private function parseDate($date)
    {
        if (is_numeric($date)) {
            // Excel date (number of days since 1900-01-01)
            return Carbon::create(1900, 1, 1)->addDays($date - 2);
        } elseif (is_string($date)) {
            try {
                return Carbon::createFromFormat('d-M-y', $date);
            } catch (\Exception $e) {
                try {
                    return Carbon::parse($date);
                } catch (\Exception $e) {
                    return now();
                }
            }
        }
        
        return now();
    }
}