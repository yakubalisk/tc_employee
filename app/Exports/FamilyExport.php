<?php

namespace App\Exports;

use App\Models\Family;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FamilyExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $relationship;
    protected $empID;

    public function __construct($search = null, $relationship = null, $empID = null)
    {
        $this->search = $search;
        $this->relationship = $relationship;
        $this->empID = $empID;
    }

    public function collection()
    {
        return Family::query()
            ->search($this->search)
            ->filterByRelationship($this->relationship)
            ->filterByEmpID($this->empID)
            ->orderBy('empID')
            ->orderBy('relationship')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Name of Family Member',
            'Relationship',
            'Date of Birth',
            'Age',
            'Dependent Remarks',
            'Reason for Dependence',
            'LTC',
            'Medical',
            'GSLI',
            'GPF',
            'DCRG',
            'Pension/NPS',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->empID,
            $record->name_of_family_member,
            $record->relationship,
            $record->date_of_birth->format('d-M-y'),
            $record->age ?? $record->calculated_age,
            $record->dependent_remarks,
            $record->reason_for_dependence,
            $record->ltc ? 'Yes' : 'No',
            $record->medical ? 'Yes' : 'No',
            $record->gsli ? 'Yes' : 'No',
            $record->gpf ? 'Yes' : 'No',
            $record->dcrg ? 'Yes' : 'No',
            $record->pension_nps ? 'Yes' : 'No',
            $record->created_at,
            $record->updated_at,
        ];
    }
}