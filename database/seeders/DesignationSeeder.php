<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run()
    {
        $designations = [
            ['name' => 'JQAO (LAB)', 'code' => 'JQAO', 'description' => 'Junior Quality Assurance Officer (Lab)', 'grade' => 'Junior'],
            ['name' => 'QAO (EP&QA)', 'code' => 'QAO', 'description' => 'Quality Assurance Officer (EP&QA)', 'grade' => 'Officer'],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}