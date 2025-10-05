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
    // Convert checkbox values BEFORE validation
    $checkboxFields = [
        'office_in_charge', 'nps', 'probation_period', 'department',
        'increment_individual_selc', 'increment_withheld', 'FR56J_2nd_batch',
        'apar_hod', 'karmayogi_certificate_completed', '2021_2022', 
        '2022_2023', '2023_2024', '2024_2025'
    ];

    // Convert checkboxes from "on" to boolean true/false
    foreach ($checkboxFields as $field) {
        $request[$field] = $request->has($field) && $request->$field === 'on';
    }

    // Now validate with boolean rules
    $validated = $request->validate([
        // Personal Information
        // 'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'empCode' => 'required|unique:employees|max:50',
        'empId' => 'required|unique:employees|max:50',
        'name' => 'required|max:255',
        'gender' => 'required|in:MALE,FEMALE,OTHER',
        'category' => 'required|in:General,OBC,SC,ST',
        'education' => 'nullable|string',
        'mobile' => 'nullable|digits:10',
        'email' => 'nullable|email|unique:employees',
        
        // Employment Details
        'dateOfAppointment' => 'required|date',
        'designationAtAppointment' => 'required|string|max:255',
        'designationAtPresent' => 'required|string|max:255',
        'presentPosting' => 'required|string|max:255',
        'personalFileNo' => 'nullable|string|max:50',
        'officeLandline' => 'nullable|string|max:20',
        
        // Personal Details
        'dateOfBirth' => 'required|date',
        'dateOfRetirement' => 'required|date|after:dateOfBirth',
        'homeTown' => 'nullable|string|max:255',
        'residentialAddress' => 'nullable|string',
        'status' => 'required|in:EXISTING,RETIRED,TRANSFERRED',
        
        // Checkbox fields - NOW AS BOOLEAN
        'office_in_charge' => 'boolean',
        'nps' => 'boolean',
        'probation_period' => 'boolean',
        'department' => 'boolean',
        'increment_individual_selc' => 'boolean',
        'increment_withheld' => 'boolean',
        'FR56J_2nd_batch' => 'boolean',
        'apar_hod' => 'boolean',
        'karmayogi_certificate_completed' => 'boolean',
        '2021_2022' => 'boolean',
        '2022_2023' => 'boolean',
        '2023_2024' => 'boolean',
        '2024_2025' => 'boolean',
        
        // Other fields
        'promotee_transferee' => 'nullable|string|max:255',
        'pension_file_no' => 'nullable|string|max:50',
        'increment_month' => 'nullable|integer|min:1|max:12',
        'status_of_post' => 'nullable|string|max:255',
        'seniority_sequence_no' => 'nullable|string|max:50',
        'sddlsection_incharge' => 'nullable|string|max:255',
        'benevolent_member' => 'nullable|string|max:255',
        'office_landline_number' => 'nullable|string|max:255',
    ]);

    // return $request;

    // return $request->hasFile('profile_image');

    try {
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $validated['profile_image'] = $imagePath;
        }


        // return $request;
        // die();

        Employee::create($validated);
        // print_r('done');die();
        
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully!');
            
    } catch (\Exception $e) {
        // print($e->getMessage());die();
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

    // Show method
public function show(Employee $employee)
{
    // return $employee;
    return view('employees.show', compact('employee'));
}

// Edit method
public function edit(Employee $employee)
{
    return view('employees.edit', compact('employee'));
}

// Update method
public function update(Request $request, Employee $employee)
{
    // Similar validation as store but with unique rules ignoring current employee
    $validated = $request->validate([
        'empCode' => 'required|max:50|unique:employees,empCode,' . $employee->id,
        'empId' => 'required|max:50|unique:employees,empId,' . $employee->id,
        'email' => 'nullable|email|unique:employees,email,' . $employee->id,
        // ... other validation rules (same as store)
    ]);

    try {
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $validated['profile_image'] = $imagePath;
        }

        // Convert checkbox values
        $checkboxFields = [
            'office_in_charge', 'nps', 'probation_period', 'department',
            'increment_individual_selc', 'increment_withheld', 'FR56J_2nd_batch',
            'apar_hod', 'karmayogi_certificate_completed', '2021_2022', 
            '2022_2023', '2023_2024', '2024_2025'
        ];

        foreach ($checkboxFields as $field) {
            $validated[$field] = $request->has($field) && $request->$field === 'on';
        }

        $employee->update($validated);
        
        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Employee updated successfully!');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Error updating employee: ' . $e->getMessage());
    }
}
}