<?php

namespace App\Imports;

use App\Models\ModeOfRecruitment;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ModeOfRecruitmentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Handle date conversion from Excel format
        $dateOfEntry = $this->parseDate($row['date_of_entry'] ?? $row['date of entry'] ?? null);
        $dateOfExit = $this->parseDate($row['date_of_exit'] ?? $row['date of exit'] ?? null);
        $gsliEntryDt = $this->parseDate($row['gsli_entry_dt'] ?? $row['gsli entry dt'] ?? null);
        $gsliExitDt = $this->parseDate($row['gsli_exit_dt'] ?? $row['gsli exit dt'] ?? null);

                        // Find employee by empId
        $employee = Employee::where('empCode', $row['emp_code'])
                    // ->orWhere('empCode', $row['emp_code'])
                    ->first();

        return new ModeOfRecruitment([
            'employee_id' => $employee->id,
            'Designation_' => $row['designation_'] ?? '',
            'Seniority_Number' => $row['seniority_number'] ?? $row['seniority number'] ?? 0,
            'Designation' => $row['designation'] ?? '',
            'Date_of_Entry' => $dateOfEntry,
            'Office_Order_No' => $row['office_order_no'] ?? $row['office order no'] ?? '',
            'Method_of_Recruitment' => $row['method_of_recruitment'] ?? $row['method of recruitment'] ?? 'PR',
            'Promotion_Remarks' => $row['promotion_remarks'] ?? $row['promotion remarks'] ?? null,
            'Pay_Fixation' => $row['pay_fixation'] ?? $row['pay fixation'] ?? 'Yes',
            'Date_of_Exit' => $dateOfExit,
            'GSLI_Policy_No' => $row['gsli_policy_no'] ?? $row['gsli policy no'] ?? null,
            'GSLI_Entry_dt' => $gsliEntryDt,
            'GSLI_Exit_dt' => $gsliExitDt,
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
                return Carbon::createFromFormat('d-m-Y', $date);
            } catch (\Exception $e) {
                try {
                    return Carbon::createFromFormat('d/m/Y', $date);
                } catch (\Exception $e) {
                    try {
                        return Carbon::parse($date);
                    } catch (\Exception $e) {
                        return null;
                    }
                }
            }
        }
        
        return null;
    }
}