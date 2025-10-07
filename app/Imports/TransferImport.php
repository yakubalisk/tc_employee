<?php

namespace App\Imports;

use App\Models\Transfer;
use App\Models\Designation;
use App\Models\Region;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TransferImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Handle date conversion from Excel format
        $dateOfJoining = $this->parseDate($row['date_of_joining'] ?? $row['date of joining'] ?? null);
        $dateOfReleiving = $this->parseDate($row['date_of_releiving'] ?? $row['date of releiving'] ?? null);
        $dateOfExit = $this->parseDate($row['date_of_exit'] ?? $row['date of exit'] ?? null);

        // Find or create related records
        $designation = $this->findOrCreateDesignation($row['designation'] ?? $row['designation_'] ?? '');
        $region = $this->findOrCreateRegion($row['region'] ?? '');
        $transferredRegion = $this->findOrCreateRegion($row['transferred_region'] ?? $row['transferred_region'] ?? '');
        $department = $this->findOrCreateDepartment($row['department_worked'] ?? $row['department worked'] ?? '');

        return new Transfer([
            'empID' => $row['empid'] ?? $row['employee_id'] ?? '',
            'designation_id' => $designation->id,
            'date_of_joining' => $dateOfJoining,
            'date_of_releiving' => $dateOfReleiving,
            'transfer_order_no' => $row['transfer_order_no'] ?? $row['transfer order no'] ?? '',
            'transfer_remarks' => $row['transfer_remarks'] ?? $row['transfer remarks'] ?? null,
            'region_id' => $region->id,
            'date_of_exit' => $dateOfExit,
            'duration' => $row['duration'] ?? null,
            'department_worked_id' => $department->id,
            'transferred_region_id' => $transferredRegion->id,
        ]);
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        if (is_numeric($date)) {
            // Excel date (number of days since 1900-01-01)
            return Carbon::create(1900, 1, 1)->addDays($date - 2);
        } elseif (is_string($date)) {
            try {
                return Carbon::createFromFormat('d-M-y', $date);
            } catch (\Exception $e) {
                try {
                    return Carbon::createFromFormat('d-M-Y', $date);
                } catch (\Exception $e) {
                    try {
                        return Carbon::createFromFormat('d/m/Y', $date);
                    } catch (\Exception $e) {
                        try {
                            return Carbon::parse($date);
                        } catch (\Exception $e) {
                            return now();
                        }
                    }
                }
            }
        }
        
        return now();
    }

    private function findOrCreateDesignation($name)
    {
        if (empty($name)) {
            $name = 'Unknown';
        }

        return Designation::firstOrCreate(
            ['name' => $name],
            ['code' => strtoupper(substr($name, 0, 3)), 'description' => $name]
        );
    }

    private function findOrCreateRegion($name)
    {
        if (empty($name)) {
            $name = 'Unknown';
        }

        return Region::firstOrCreate(
            ['name' => $name],
            ['code' => strtoupper(substr($name, 0, 3)), 'description' => $name]
        );
    }

    private function findOrCreateDepartment($name)
    {
        if (empty($name)) {
            $name = 'Unknown';
        }

        return Department::firstOrCreate(
            ['name' => $name],
            ['code' => strtoupper(substr($name, 0, 3)), 'description' => $name]
        );
    }
}