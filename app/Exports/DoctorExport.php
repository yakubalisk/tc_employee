<?php

namespace App\Exports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DoctorExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $qualification;
    protected $empID;

    public function __construct($search = null, $qualification = null, $empID = null)
    {
        $this->search = $search;
        $this->qualification = $qualification;
        $this->empID = $empID;
    }

    public function collection()
    {
        return Doctor::query()
            ->search($this->search)
            ->filterByQualification($this->qualification)
            ->filterByEmpID($this->empID)
            ->orderBy('empID')
            ->orderBy('name_of_doctor')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Name of Doctor',
            'Registration No',
            'Address',
            'Qualification',
            'AMA Remarks',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->empID,
            $record->name_of_doctor,
            $record->registration_no,
            $record->address,
            $record->qualification,
            $record->ama_remarks,
            $record->created_at,
            $record->updated_at,
        ];
    }
}