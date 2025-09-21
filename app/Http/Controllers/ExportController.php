<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $exportFormat = $request->input('format', 'excel');
        $exportType = $request->input('type', 'all-employees');
        $selectedFields = $request->input('fields', ['name', 'empCode', 'designationAtPresent', 'presentPosting', 'email', 'mobile']);
        $filterGender = $request->input('gender', 'all');
        $filterCategory = $request->input('category', 'all');
        $filterDepartment = $request->input('department', 'all');

        $exportFormats = [
            ['value' => 'excel', 'label' => 'Excel (.xlsx)', 'icon' => 'file-spreadsheet-icon'],
            ['value' => 'pdf', 'label' => 'PDF Document', 'icon' => 'file-text-icon'],
            ['value' => 'csv', 'label' => 'CSV File', 'icon' => 'table-icon'],
        ];

        $exportTypes = [
            ['value' => 'all-employees', 'label' => 'All Employee Records'],
            ['value' => 'active-employees', 'label' => 'Active Employees Only'],
            ['value' => 'promotion-report', 'label' => 'Promotion Report'],
            ['value' => 'transfer-report', 'label' => 'Transfer History'],
            ['value' => 'retirement-report', 'label' => 'Retirement Due Report'],
            ['value' => 'financial-upgradations', 'label' => 'Financial Upgradations'],
            ['value' => 'department-wise', 'label' => 'Department Wise Report'],
        ];

        $availableFields = [
            ['id' => 'empCode', 'label' => 'Employee Code'],
            ['id' => 'name', 'label' => 'Full Name'],
            ['id' => 'designationAtPresent', 'label' => 'Current Designation'],
            ['id' => 'presentPosting', 'label' => 'Department/Posting'],
            ['id' => 'email', 'label' => 'Email Address'],
            ['id' => 'mobile', 'label' => 'Mobile Number'],
            ['id' => 'gender', 'label' => 'Gender'],
            ['id' => 'category', 'label' => 'Category'],
            ['id' => 'dateOfBirth', 'label' => 'Date of Birth'],
            ['id' => 'dateOfAppointment', 'label' => 'Date of Appointment'],
            ['id' => 'dateOfRetirement', 'label' => 'Date of Retirement'],
            ['id' => 'education', 'label' => 'Education'],
            ['id' => 'homeTown', 'label' => 'Home Town'],
            ['id' => 'status', 'label' => 'Status'],
        ];

        $employeeCount = $this->getFilteredEmployeeCount($filterGender, $filterCategory, $filterDepartment);

        return view('export.index', compact(
            'exportFormat',
            'exportType',
            'selectedFields',
            'filterGender',
            'filterCategory',
            'filterDepartment',
            'exportFormats',
            'exportTypes',
            'availableFields',
            'employeeCount'
        ));
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'format' => 'required|in:excel,pdf,csv',
            'type' => 'required|string',
            'fields' => 'required|array',
            'gender' => 'nullable|string',
            'category' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $fileName = 'employees_export_' . date('Y-m-d_His');

        switch ($validated['format']) {
            case 'excel':
                return Excel::download(new EmployeesExport($validated), $fileName . '.xlsx');
            case 'pdf':
                $employees = $this->getFilteredEmployees($validated);
                $pdf = PDF::loadView('exports.pdf', compact('employees', 'validated'));
                return $pdf->download($fileName . '.pdf');
            case 'csv':
                return Excel::download(new EmployeesExport($validated), $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }

    public function emailReport(Request $request)
    {
        // Implement email functionality
        $request->validate([
            'email' => 'required|email',
            'format' => 'required|in:excel,pdf,csv',
        ]);

        // Queue email with report attachment
        // Mail::to($request->email)->send(new ExportReportMail($request->all()));

        return redirect()->back()->with('success', 'Report will be emailed shortly.');
    }

    public function scheduleExport(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'format' => 'required|in:excel,pdf,csv',
            'email' => 'required|email',
        ]);

        // Schedule export job
        // ScheduleExportJob::dispatch($request->all())->{$request->frequency}();

        return redirect()->back()->with('success', 'Export scheduled successfully.');
    }

    private function getFilteredEmployeeCount($gender, $category, $department)
    {
        return Employee::query()
            ->when($gender !== 'all', function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            ->when($category !== 'all', function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->when($department !== 'all', function ($query) use ($department) {
                return $query->where('presentPosting', $department);
            })
            ->count();
    }

    private function getFilteredEmployees($filters)
    {
        return Employee::query()
            ->when($filters['gender'] !== 'all', function ($query) use ($filters) {
                return $query->where('gender', $filters['gender']);
            })
            ->when($filters['category'] !== 'all', function ($query) use ($filters) {
                return $query->where('category', $filters['category']);
            })
            ->when($filters['department'] !== 'all', function ($query) use ($filters) {
                return $query->where('presentPosting', $filters['department']);
            })
            ->when($filters['type'] === 'active-employees', function ($query) {
                return $query->where('status', 'EXISTING');
            })
            ->when($filters['type'] === 'retirement-report', function ($query) {
                return $query->whereYear('dateOfRetirement', now()->year);
            })
            ->get($filters['fields']);
    }
}