<?php

namespace App\Imports;

use App\Models\Doctor;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DoctorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $employee = Employee::where('empCode', $row['emp_code']);

        return new Doctor([
            'employee_id' => $employee->id,
            'name_of_doctor' => $row['name_of_doctor'] ?? $row['name of doctor'] ?? null,
            'registration_no' => $row['registration_no'] ?? $row['resgn no'] ?? $row['registration no'] ?? null,
            'address' => $row['address'] ?? null,
            'qualification' => $row['qualification'] ?? null,
            'ama_remarks' => $row['ama_remarks'] ?? $row['ama remarks'] ?? null,
        ]);
    }
}