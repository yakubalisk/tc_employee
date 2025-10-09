<?php

namespace App\Exports;

use App\Models\AparGrading;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AparGradingExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return AparGrading::with('employee')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Emp Code',
            'Employee Name',
            'From Month',
            'From Year',
            'To Month',
            'To Year',
            'Grading Type',
            'APAR Discrepancy Remarks',
            'Reporting Officer Marks',
            'Reviewing Officer Marks',
            'Reporting ACR Grade',
            'Reviewing ACR Grade',
            'APAR Consideration',
            'APAR Remarks'
        ];
    }

    public function map($apar): array
    {
        return [
            $apar->id,
            $apar->employee->empCode,
            $apar->employee->name,
            $apar->from_month,
            $apar->from_year,
            $apar->to_month,
            $apar->to_year,
            $apar->grading_type,
            $apar->discrepancy_remarks,
            $apar->reporting_marks,
            $apar->reviewing_marks,
            $apar->reporting_grade,
            $apar->reviewing_grade,
            $apar->consideration ? 'TRUE' : 'FALSE',
            $apar->remarks
        ];
    }
}