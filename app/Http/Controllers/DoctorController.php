<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DoctorExport;
use App\Imports\DoctorImport;
use App\Exports\DoctorTemplateExport;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $qualification = $request->get('qualification', 'all');
        $empID = $request->get('empID', 'all');

        $records = Doctor::query()
            ->search($search)
            ->filterByQualification($qualification)
            ->filterByEmpID($empID)
            ->orderBy('empID')
            ->orderBy('name_of_doctor')
            ->paginate(10);

        $employeeIds = Doctor::distinct()->pluck('empID', 'empID');

        return view('doctor.index', compact(
            'records', 
            'search', 
            'qualification', 
            'empID',
            'employeeIds'
        ));
    }

    public function create()
    {
        return view('doctor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'name_of_doctor' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string|max:100',
            'ama_remarks' => 'nullable|string',
        ]);

        Doctor::create($validated);

        return redirect()->route('doctor.index')
            ->with('success', 'Doctor record created successfully.');
    }

    public function show(Doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctor.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'name_of_doctor' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string|max:100',
            'ama_remarks' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctor.index')
            ->with('success', 'Doctor record updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctor.index')
            ->with('success', 'Doctor record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $qualification = $request->get('qualification', 'all');
        $empID = $request->get('empID', 'all');

        $fileName = 'doctors-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new DoctorExport($search, $qualification, $empID), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new DoctorImport, $request->file('file'));
            
            return redirect()->route('doctor.index')
                ->with('success', 'Doctor records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('doctor.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('doctor.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'doctor-template-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new DoctorTemplateExport, $fileName);
    }
}