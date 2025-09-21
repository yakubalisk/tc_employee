<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Employee::query()
            ->when($this->filters['gender'] !== 'all', function ($query) {
                return $query->where('gender', $this->filters['gender']);
            })
            ->when($this->filters['category'] !== 'all', function ($query) {
                return $query->where('category', $this->filters['category']);
            })
            ->when($this->filters['department'] !== 'all', function ($query) {
                return $query->where('presentPosting', $this->filters['department']);
            })
            ->when($this->filters['type'] === 'active-employees', function ($query) {
                return $query->where('status', 'EXISTING');
            })
            ->when($this->filters['type'] === 'retirement-report', function ($query) {
                return $query->whereYear('dateOfRetirement', now()->year);
            })
            ->get($this->filters['fields']);
    }

    public function headings(): array
    {
        $headings = [];
        $fieldLabels = [
            'empCode' => 'Employee Code',
            'name' => 'Full Name',
            'designationAtPresent' => 'Current Designation',
            'presentPosting' => 'Department/Posting',
            'email' => 'Email Address',
            'mobile' => 'Mobile Number',
            'gender' => 'Gender',
            'category' => 'Category',
            'dateOfBirth' => 'Date of Birth',
            'dateOfAppointment' => 'Date of Appointment',
            'dateOfRetirement' => 'Date of Retirement',
            'education' => 'Education',
            'homeTown' => 'Home Town',
            'status' => 'Status',
        ];

        foreach ($this->filters['fields'] as $field) {
            $headings[] = $fieldLabels[$field] ?? $field;
        }

        return $headings;
    }

    public function map($employee): array
    {
        $row = [];
        foreach ($this->filters['fields'] as $field) {
            $row[] = $employee->$field;
        }
        return $row;
    }
}