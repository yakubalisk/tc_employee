<?php

namespace App\Http\Controllers;

use App\Models\AparGrading;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AparGradingImport;
use App\Exports\AparGradingExport;
use App\Exports\AparTemplateExport;

class AparGradingController extends Controller
{
    // Main APAR Index (All APAR records)
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $aparGradings = AparGrading::with('employee')
            ->when($search, function($query) use ($search) {
                $query->whereHas('employee', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('empCode', 'like', "%{$search}%")
                      ->orWhere('empId', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        return view('apar-gradings.index', compact('aparGradings', 'search'));
    }

    public function create(Request $request)
    {
        $employees = Employee::orderBy('name')->get();
        
        // Pre-select employee if coming from employee page
        $selectedEmployee = null;
        if ($request->has('employee_id')) {
            $selectedEmployee = Employee::find($request->employee_id);
        }

        return view('apar-gradings.create', compact('employees', 'selectedEmployee'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'from_month' => 'required|string',
            'from_year' => 'required|integer|min:2000|max:2030',
            'to_month' => 'required|string',
            'to_year' => 'required|integer|min:2000|max:2030',
            'grading_type' => 'required|string',
            'discrepancy_remarks' => 'nullable|string',
            'reporting_marks' => 'nullable|numeric|min:0|max:10',
            'reviewing_marks' => 'nullable|numeric|min:0|max:10',
            'reporting_grade' => 'nullable|string',
            'reviewing_grade' => 'nullable|string',
            'consideration' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        AparGrading::create($validated);

        return redirect()->route('apar.index')
            ->with('success', 'APAR grading record created successfully!');
    }

    public function show(AparGrading $aparGrading)
    {
        return view('apar-gradings.show', compact('aparGrading'));
    }

    public function edit(AparGrading $aparGrading)
    {
        $employees = Employee::orderBy('name')->get();
        return view('apar-gradings.edit', compact('aparGrading', 'employees'));
    }

    public function update(Request $request, AparGrading $aparGrading)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'from_month' => 'required|string',
            'from_year' => 'required|integer|min:2000|max:2030',
            'to_month' => 'required|string',
            'to_year' => 'required|integer|min:2000|max:2030',
            'grading_type' => 'required|string',
            'discrepancy_remarks' => 'nullable|string',
            'reporting_marks' => 'nullable|numeric|min:0|max:10',
            'reviewing_marks' => 'nullable|numeric|min:0|max:10',
            'reporting_grade' => 'nullable|string',
            'reviewing_grade' => 'nullable|string',
            'consideration' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $aparGrading->update($validated);

        return redirect()->route('apar.index')
            ->with('success', 'APAR grading record updated successfully!');
    }

    public function destroy(AparGrading $aparGrading)
    {
        $aparGrading->delete();

        return redirect()->route('apar.index')
            ->with('success', 'APAR grading record deleted successfully!');
    }

    // Import functionality
    public function import()
    {
        return view('apar-gradings.import');
    }

public function processImport(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
    ]);

    try {
        \DB::beginTransaction();
        
        $import = new AparGradingImport;
        Excel::import($import, $request->file('file'));
        
        \DB::commit();
        
        return redirect()->route('apar.index')
            ->with('success', 'APAR records imported successfully!');
            
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        \DB::rollBack();
        
        $failures = $e->failures();
        $errorMessages = [];
        
        foreach ($failures as $failure) {
            $row = $failure->row();
            $attribute = $failure->attribute();
            $errors = implode(', ', $failure->errors());
            $values = $failure->values()[$attribute] ?? 'N/A';
            
            $errorMessages[] = "Row {$row} ({$attribute}: '{$values}'): {$errors}";
        }
        
        \Log::error('APAR Import Validation Errors:', $errorMessages);
        
        return redirect()->back()
            ->with('error', 'Validation errors occurred during import:')
            ->with('errorDetails', $errorMessages);
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        \DB::rollBack();
        
        $errorMessages = [];
        foreach ($e->errors() as $field => $errors) {
            foreach ($errors as $error) {
                $errorMessages[] = "{$field}: {$error}";
            }
        }
        
        return redirect()->back()
            ->with('error', 'Validation errors occurred:')
            ->with('errorDetails', $errorMessages);
            
    } catch (\Exception $e) {
        \DB::rollBack();
        
        \Log::error('APAR Import Error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        $errorMessage = $e->getMessage();
        
        // Add more specific error messages for common issues
        if (str_contains($errorMessage, 'Employee not found')) {
            $errorMessage .= ". Please make sure the Employee ID exists in the system.";
        }
        
        if (str_contains($errorMessage, 'Undefined index')) {
            $errorMessage .= ". Check if your Excel file has the correct column headers.";
        }
        
        return redirect()->back()
            ->with('error', 'Import failed: ' . $errorMessage)
            ->withInput();
    }
}

    // Export functionality
    public function export()
    {
        // return '88899';
        return Excel::download(new AparGradingExport, 'apar-gradings-' . date('Y-m-d') . '.xlsx');
    }

// Template download - Excel version
public function exportTemplate()
{
    return Excel::download(new AparTemplateExport, 'apar-import-template-' . date('Y-m-d') . '.xlsx');
}
}