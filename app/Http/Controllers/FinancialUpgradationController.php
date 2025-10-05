<?php

namespace App\Http\Controllers;

use App\Models\FinancialUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialUpgradationExport;
use App\Exports\FinancialUpgradationTemplateExport;
use App\Imports\FinancialUpgradationImport;

class FinancialUpgradationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $region = $request->get('region', 'all');
        $department = $request->get('department', 'all');
        $designation = $request->get('designation', 'all');
        $type = $request->get('type', 'all');

        $records = FinancialUpgradation::query()
            ->search($search)
            ->filterByRegion($region)
            ->filterByDepartment($department)
            ->filterByDesignation($designation)
            ->filterByType($type)
            ->orderBy('promotion_date', 'desc')
            ->paginate(10);

        return view('financial-upgradation.index', compact(
            'records', 
            'search', 
            'region', 
            'department', 
            'designation',
            'type'
        ));
    }

    public function create()
    {
        return view('financial-upgradation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sr_no' => 'required|integer',
            'empl_id' => 'required|string|max:50',
            'promotion_date' => 'required|date',
            'existing_designation' => 'required|string|max:255',
            'upgraded_designation' => 'required|string|max:255',
            'date_in_grade' => 'required|date',
            'existing_scale' => 'required|string|max:255',
            'upgraded_scale' => 'required|string|max:255',
            'pay_fixed' => 'required|in:YES,NO',
            'existing_pay' => 'required|numeric',
            'existing_grade_pay' => 'required|numeric',
            'upgraded_pay' => 'required|numeric',
            'upgraded_grade_pay' => 'required|numeric',
            'macp_remarks' => 'nullable|string',
            'no_of_financial_upgradation' => 'required|integer',
            'financial_upgradation_type' => 'required|in:MACP,PROMOTION,ACP',
            'region' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
        ]);

        FinancialUpgradation::create($validated);

        return redirect()->route('financial-upgradation.index')
            ->with('success', 'Financial upgradation record created successfully.');
    }

    public function show(FinancialUpgradation $financialUpgradation)
    {
        return view('financial-upgradation.show', compact('financialUpgradation'));
    }

    public function edit(FinancialUpgradation $financialUpgradation)
    {
        return view('financial-upgradation.edit', compact('financialUpgradation'));
    }

    public function update(Request $request, FinancialUpgradation $financialUpgradation)
    {
        $validated = $request->validate([
            'sr_no' => 'required|integer',
            'empl_id' => 'required|string|max:50',
            'promotion_date' => 'required|date',
            'existing_designation' => 'required|string|max:255',
            'upgraded_designation' => 'required|string|max:255',
            'date_in_grade' => 'required|date',
            'existing_scale' => 'required|string|max:255',
            'upgraded_scale' => 'required|string|max:255',
            'pay_fixed' => 'required|in:YES,NO',
            'existing_pay' => 'required|numeric',
            'existing_grade_pay' => 'required|numeric',
            'upgraded_pay' => 'required|numeric',
            'upgraded_grade_pay' => 'required|numeric',
            'macp_remarks' => 'nullable|string',
            'no_of_financial_upgradation' => 'required|integer',
            'financial_upgradation_type' => 'required|in:MACP,PROMOTION,ACP',
            'region' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
        ]);

        $financialUpgradation->update($validated);

        return redirect()->route('financial-upgradation.index')
            ->with('success', 'Financial upgradation record updated successfully.');
    }

    public function destroy(FinancialUpgradation $financialUpgradation)
    {
        $financialUpgradation->delete();

        return redirect()->route('financial-upgradation.index')
            ->with('success', 'Financial upgradation record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $region = $request->get('region', 'all');
        $department = $request->get('department', 'all');
        $designation = $request->get('designation', 'all');
        $type = $request->get('type', 'all');

        $fileName = 'financial-upgradation-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new FinancialUpgradationExport($search, $region, $department, $designation, $type), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new FinancialUpgradationImport, $request->file('file'));
            
            return redirect()->route('financial-upgradation.index')
                ->with('success', 'Financial upgradation records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('financial-upgradation.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('financial-upgradation.import');
    }

    public function downloadTemplate()
{
    $fileName = 'financial-upgradation-template-' . date('Y-m-d') . '.xlsx';
    
    return Excel::download(new FinancialUpgradationTemplateExport, $fileName);
}
}