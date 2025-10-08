<?php

namespace App\Imports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DoctorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Doctor([
            'empID' => $row['empid'] ?? $row['employee_id'] ?? '',
            'name_of_doctor' => $row['name_of_doctor'] ?? $row['name of doctor'] ?? null,
            'registration_no' => $row['registration_no'] ?? $row['resgn no'] ?? $row['registration no'] ?? null,
            'address' => $row['address'] ?? null,
            'qualification' => $row['qualification'] ?? null,
            'ama_remarks' => $row['ama_remarks'] ?? $row['ama remarks'] ?? null,
        ]);
    }
}