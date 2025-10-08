<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FamilyExport;
use App\Imports\FamilyImport;
use App\Exports\FamilyTemplateExport;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $relationship = $request->get('relationship', 'all');
        $empID = $request->get('empID', 'all');

        $records = Family::query()
            ->search($search)
            ->filterByRelationship($relationship)
            ->filterByEmpID($empID)
            ->orderBy('empID')
            ->orderBy('relationship')
            ->paginate(10);

        $employeeIds = Family::distinct()->pluck('empID', 'empID');

        return view('family.index', compact(
            'records', 
            'search', 
            'relationship', 
            'empID',
            'employeeIds'
        ));
    }

    public function create()
    {
        return view('family.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'name_of_family_member' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'dependent_remarks' => 'nullable|string',
            'reason_for_dependence' => 'nullable|string|max:255',
            'ltc' => 'boolean',
            'medical' => 'boolean',
            'gsli' => 'boolean',
            'gpf' => 'boolean',
            'dcrg' => 'boolean',
            'pension_nps' => 'boolean',
        ]);

        Family::create($validated);

        return redirect()->route('family.index')
            ->with('success', 'Family member record created successfully.');
    }

    public function show(Family $family)
    {
        return view('family.show', compact('family'));
    }

    public function edit(Family $family)
    {
        return view('family.edit', compact('family'));
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'name_of_family_member' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'dependent_remarks' => 'nullable|string',
            'reason_for_dependence' => 'nullable|string|max:255',
            'ltc' => 'boolean',
            'medical' => 'boolean',
            'gsli' => 'boolean',
            'gpf' => 'boolean',
            'dcrg' => 'boolean',
            'pension_nps' => 'boolean',
        ]);

        $family->update($validated);

        return redirect()->route('family.index')
            ->with('success', 'Family member record updated successfully.');
    }

    public function destroy(Family $family)
    {
        $family->delete();

        return redirect()->route('family.index')
            ->with('success', 'Family member record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $relationship = $request->get('relationship', 'all');
        $empID = $request->get('empID', 'all');

        $fileName = 'family-members-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new FamilyExport($search, $relationship, $empID), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new FamilyImport, $request->file('file'));
            
            return redirect()->route('family.index')
                ->with('success', 'Family member records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('family.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('family.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'family-template-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new FamilyTemplateExport, $fileName);
    }
}