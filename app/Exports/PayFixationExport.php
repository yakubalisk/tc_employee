<?php

namespace App\Exports;

use App\Models\PayFixation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayFixationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $level;
    protected $level2;

    public function __construct($search = null, $level = null, $level2 = null)
    {
        $this->search = $search;
        $this->level = $level;
        $this->level2 = $level2;
    }

    public function collection()
    {
        return PayFixation::query()
            ->search($this->search)
            ->filterByLevel($this->level)
            ->filterByLevel2($this->level2)
            ->orderBy('pay_fixation_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee Code',
            'Pay Fixation Date',
            'Basic Pay',
            'Grade Pay',
            'Cell No',
            'Revised Level',
            'Pay Fixation Remarks',
            'Level 2',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->empl_id,
            $record->pay_fixation_date->format('d-M-y'),
            $record->basic_pay,
            $record->grade_pay,
            $record->cell_no,
            $record->revised_level,
            $record->pay_fixation_remarks,
            $record->level_2,
            $record->created_at,
            $record->updated_at,
        ];
    }
}