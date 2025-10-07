<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'LAB', 'code' => 'LAB', 'description' => 'Laboratory Department'],
            ['name' => 'EP&QA', 'code' => 'EPQA', 'description' => 'Engineering Production & Quality Assurance'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}