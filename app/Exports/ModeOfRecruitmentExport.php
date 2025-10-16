<?php

namespace App\Exports;

use App\Models\ModeOfRecruitment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ModeOfRecruitmentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $method;
    protected $payFixation;

    public function __construct($search = null, $method = null, $payFixation = null)
    {
        $this->search = $search;
        $this->method = $method;
        $this->payFixation = $payFixation;
    }

    public function collection()
    {
        return ModeOfRecruitment::query()
            ->search($this->search)
            ->filterByMethod($this->method)
            ->filterByPayFixation($this->payFixation)
            ->orderBy('Date_of_Entry', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'PromotionID',
            'Employee Code',
            'Designation_',
            'Seniority Number',
            'Designation',
            'Date of Entry',
            'Office Order No',
            'Method of Recruitment',
            'Promotion Remarks',
            'Pay Fixation',
            'Date of Exit',
            'GSLI Policy No',
            'GSLI Entry dt',
            'GSLI Exit dt',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->PromotionID,
            $record->employee->empCode,
            $record->Designation_,
            $record->Seniority_Number,
            $record->Designation,
            $record->Date_of_Entry->format('d-m-Y'),
            $record->Office_Order_No,
            $record->Method_of_Recruitment,
            $record->Promotion_Remarks,
            $record->Pay_Fixation,
            $record->Date_of_Exit ? $record->Date_of_Exit->format('d-m-Y') : '',
            $record->GSLI_Policy_No,
            $record->GSLI_Entry_dt ? $record->GSLI_Entry_dt->format('d-m-Y') : '',
            $record->GSLI_Exit_dt ? $record->GSLI_Exit_dt->format('d-m-Y') : '',
            $record->created_at,
            $record->updated_at,
        ];
    }
}