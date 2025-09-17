<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empCode' => 'required|unique:employees|max:50',
            'empId' => 'required|unique:employees|max:50',
            'name' => 'required|max:255',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
            'category' => 'required|in:General,OBC,SC,ST',
            'education' => 'nullable|string',
            'mobile' => 'nullable|digits:10',
            'email' => 'nullable|email|unique:employees',
            'dateOfAppointment' => 'required|date',
            'designationAtAppointment' => 'required|string|max:255',
            'designationAtPresent' => 'required|string|max:255',
            'presentPosting' => 'required|string|max:255',
            'personalFileNo' => 'nullable|string|max:50',
            'officeLandline' => 'nullable|string|max:20',
            'dateOfBirth' => 'required|date',
            'dateOfRetirement' => 'required|date|after:dateOfBirth',
            'homeTown' => 'nullable|string|max:255',
            'residentialAddress' => 'nullable|string',
            'status' => 'required|in:EXISTING,RETIRED,TRANSFERRED'
        ]);

        try {
            Employee::create($validated);
            return redirect()->route('employees.index')
                ->with('success', 'Employee created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

        public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $filterGender = $request->input('gender', 'all');
        $filterCategory = $request->input('category', 'all');
        $filterStatus = $request->input('status', 'all');

        $employees = Employee::query()
            ->search($searchTerm)
            ->filterByGender($filterGender)
            ->filterByCategory($filterCategory)
            ->filterByStatus($filterStatus)
            ->paginate(10);

        return view('employees.index', compact('employees', 'searchTerm', 'filterGender', 'filterCategory', 'filterStatus'));
    }

    public function export(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $filterGender = $request->input('gender', 'all');
        $filterCategory = $request->input('category', 'all');
        $filterStatus = $request->input('status', 'all');

        $employees = Employee::query()
            ->search($searchTerm)
            ->filterByGender($filterGender)
            ->filterByCategory($filterCategory)
            ->filterByStatus($filterStatus)
            ->get();

        $fileName = 'employees_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($employees) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Employee Code', 
                'Name', 
                'Email', 
                'Designation', 
                'Department', 
                'Category', 
                'Age', 
                'Status'
            ]);
            
            // Add data rows
            foreach ($employees as $employee) {
                fputcsv($file, [
                    $employee->empCode,
                    $employee->name,
                    $employee->email,
                    $employee->designationAtPresent,
                    $employee->presentPosting,
                    $employee->category,
                    $employee->age,
                    $employee->status
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportSingle(Employee $employee)
    {
        $fileName = 'employee_' . $employee->empCode . '_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($employee) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Field', 'Value']);
            fputcsv($file, ['Employee Code', $employee->empCode]);
            fputcsv($file, ['Name', $employee->name]);
            fputcsv($file, ['Email', $employee->email]);
            fputcsv($file, ['Designation', $employee->designationAtPresent]);
            fputcsv($file, ['Department', $employee->presentPosting]);
            fputcsv($file, ['Category', $employee->category]);
            fputcsv($file, ['Age', $employee->age]);
            fputcsv($file, ['Status', $employee->status]);
            fputcsv($file, ['Date of Birth', $employee->dateOfBirth]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}