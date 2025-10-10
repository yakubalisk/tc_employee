<?php

namespace App\Imports;

use App\Models\PayFixation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PayFixationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Handle date conversion from Excel format
        $payFixationDate = $this->parseDate($row['pay_fixation_date'] ?? $row['pay fixation date'] ?? null);

        return new PayFixation([
            'employee_id' => $row['employee_id'] ?? '',
            'pay_fixation_date' => $payFixationDate,
            'basic_pay' => $row['basic_pay'] ?? $row['basic pay'] ?? 0,
            'grade_pay' => $row['grade_pay'] ?? $row['grade pay'] ?? null,
            'cell_no' => $row['cell_no'] ?? $row['cell no'] ?? $row['cell_no'] ?? 1,
            'revised_level' => $row['revised_level'] ?? $row['revised level'] ?? '',
            'pay_fixation_remarks' => $row['pay_fixation_remarks'] ?? $row['pay fixation remarks'] ?? null,
            'level_2' => $row['level_2'] ?? $row['level2'] ?? $row['leve2'] ?? '',
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
}