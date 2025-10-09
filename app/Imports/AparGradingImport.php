<?php

namespace App\Imports;

use App\Models\AparGrading;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;

class AparGradingImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    private $rows = 0;

    public function model(array $row)
    {
        $this->rows++;
        
        // Log each row for debugging
        \Log::info("Processing row {$this->rows}:", $row);

        // Clean the column names (remove any special characters/spaces)
        $row = array_change_key_case($row, CASE_LOWER);
        
        // Check if required columns exist
        if (!isset($row['emp_code']) || !isset($row['from_month']) || !isset($row['from_year'])) {
            \Log::error("Missing required columns in row {$this->rows}", $row);
            throw new \Exception("Missing required columns in row {$this->rows}. Check if your file has the correct headers.");
        }

        // Find employee by empId
        $employee = Employee::where('empCode', $row['emp_code'])
                    // ->orWhere('empCode', $row['emp_code'])
                    ->first();

        if (!$employee) {
            \Log::error("Employee not found for Code: {$row['emp_code']} in row {$this->rows}");
            throw new \Exception("Employee not found for Code: '{$row['emp_code']}' in row {$this->rows}. Please check if the employee exists in the system.");
        }

        // Process consideration field
        $consideration = false;
        if (isset($row['consideration'])) {
            $considerationValue = strtoupper(trim($row['consideration']));
            $consideration = in_array($considerationValue, ['TRUE', '1', 'YES']);
        }

        return new AparGrading([
            'employee_id' => $employee->id,
            'from_month' => trim($row['from_month']),
            'from_year' => (int) $row['from_year'],
            'to_month' => trim($row['to_month']),
            'to_year' => (int) $row['to_year'],
            'grading_type' => trim($row['grading_type']),
            'discrepancy_remarks' => $row['discrepancy_remarks'] ?? null,
            'reporting_marks' => isset($row['reporting_marks']) && $row['reporting_marks'] !== '' ? (float) $row['reporting_marks'] : null,
            'reviewing_marks' => isset($row['reviewing_marks']) && $row['reviewing_marks'] !== '' ? (float) $row['reviewing_marks'] : null,
            'reporting_grade' => $row['reporting_grade'] ?? null,
            'reviewing_grade' => $row['reviewing_grade'] ?? null,
            'consideration' => $consideration,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'emp_code' => 'required',
            'from_month' => 'required|string',
            'from_year' => 'required|integer|min:2000|max:2030',
            'to_month' => 'required|string', 
            'to_year' => 'required|integer|min:2000|max:2030',
            'grading_type' => 'required|in:APAR,Performance Review,Annual Assessment',
            'reporting_marks' => 'nullable|numeric|min:0|max:10',
            'reviewing_marks' => 'nullable|numeric|min:0|max:10',
            'reporting_grade' => 'nullable|in:A+,A,B+,B,C,D',
            'reviewing_grade' => 'nullable|in:A+,A,B+,B,C,D',
            'consideration' => 'nullable|in:TRUE,FALSE,true,false,1,0,YES,NO',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'emp_code.required' => 'Employee Code is required',
            'from_month.required' => 'From Month is required',
            'from_year.required' => 'From Year is required',
            'to_month.required' => 'To Month is required',
            'to_year.required' => 'To Year is required',
            'grading_type.required' => 'Grading Type is required',
            'grading_type.in' => 'Grading Type must be one of: APAR, Performance Review, Annual Assessment',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}