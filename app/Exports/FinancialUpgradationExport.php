<?php

namespace App\Exports;

use App\Models\FinancialUpgradation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinancialUpgradationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $region;
    protected $department;
    protected $designation;
    protected $type;

    public function __construct($search = null, $region = null, $department = null, $designation = null, $type = null)
    {
        $this->search = $search;
        $this->region = $region;
        $this->department = $department;
        $this->designation = $designation;
        $this->type = $type;
    }

    public function collection()
    {
        return FinancialUpgradation::query()
            ->search($this->search)
            ->filterByRegion($this->region)
            ->filterByDepartment($this->department)
            ->filterByDesignation($this->designation)
            ->filterByType($this->type)
            ->orderBy('promotion_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee Code',
            'Promotion Date',
            'Existing Designation',
            'Upgraded Designation',
            'Date in Grade',
            'Existing Scale',
            'Upgraded Scale',
            'Pay Fixed',
            'Existing Pay',
            'Existing Grade Pay',
            'Upgraded Pay',
            'Upgraded Grade Pay',
            'MACP Remarks',
            'No of Financial Upgradation',
            'Financial Upgradation Type',
            'Region',
            'Department',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->employee->empCode,
            $record->promotion_date->format('d-M-y'),
            $record->existing_designation,
            $record->upgraded_designation,
            $record->date_in_grade->format('d-M-y'),
            $record->existing_scale,
            $record->upgraded_scale,
            $record->pay_fixed,
            $record->existing_pay,
            $record->existing_grade_pay,
            $record->upgraded_pay,
            $record->upgraded_grade_pay,
            $record->macp_remarks,
            $record->no_of_financial_upgradation,
            $record->financial_upgradation_type,
            $record->region,
            $record->department,
            $record->created_at,
            $record->updated_at,
        ];
    }
}