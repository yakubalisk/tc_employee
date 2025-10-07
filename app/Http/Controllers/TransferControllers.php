<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Region;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransferExport;
use App\Imports\TransferImport;
use App\Exports\TransferTemplateExport;

class TransferControllers extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $region = $request->get('region', 'all');
        $transferredRegion = $request->get('transferred_region', 'all');
        $designation = $request->get('designation', 'all');

        $records = Transfer::with(['designation', 'region', 'transferredRegion', 'departmentWorked'])
            ->search($search)
            ->filterByRegion($region)
            ->filterByTransferredRegion($transferredRegion)
            ->filterByDesignation($designation)
            ->orderBy('date_of_joining', 'desc')
            ->paginate(10);

        $regions = Region::getDropdownOptions();
        $designations = Designation::getDropdownOptions();

        return view('transfer.index', compact(
            'records', 
            'search', 
            'region', 
            'transferredRegion',
            'designation',
            'regions',
            'designations'
        ));
    }

    public function create()
    {
        $regions = Region::getDropdownOptions();
        $departments = Department::getDropdownOptions();
        $designations = Designation::getDropdownOptions();

        return view('transfer.create', compact('regions', 'departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
            'date_of_releiving' => 'required|date|after:date_of_joining',
            'transfer_order_no' => 'required|string|max:255',
            'transfer_remarks' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
            'date_of_exit' => 'nullable|date|after:date_of_joining',
            'duration' => 'nullable|string|max:50',
            'department_worked_id' => 'required|exists:departments,id',
            'transferred_region_id' => 'required|exists:regions,id',
        ]);

        Transfer::create($validated);

        return redirect()->route('transfer.index')
            ->with('success', 'Transfer record created successfully.');
    }

    public function show(Transfer $transfer)
    {
        $transfer->load(['designation', 'region', 'transferredRegion', 'departmentWorked']);
        return view('transfer.show', compact('transfer'));
    }

    public function edit(Transfer $transfer)
    {
        $regions = Region::getDropdownOptions();
        $departments = Department::getDropdownOptions();
        $designations = Designation::getDropdownOptions();

        return view('transfer.edit', compact('transfer', 'regions', 'departments', 'designations'));
    }

    public function update(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'designation_id' => 'required|exists:designations,id',
            'date_of_joining' => 'required|date',
            'date_of_releiving' => 'required|date|after:date_of_joining',
            'transfer_order_no' => 'required|string|max:255',
            'transfer_remarks' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
            'date_of_exit' => 'nullable|date|after:date_of_joining',
            'duration' => 'nullable|string|max:50',
            'department_worked_id' => 'required|exists:departments,id',
            'transferred_region_id' => 'required|exists:regions,id',
        ]);

        $transfer->update($validated);

        return redirect()->route('transfer.index')
            ->with('success', 'Transfer record updated successfully.');
    }

    public function destroy(Transfer $transfer)
    {
        $transfer->delete();

        return redirect()->route('transfer.index')
            ->with('success', 'Transfer record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $region = $request->get('region', 'all');
        $transferredRegion = $request->get('transferred_region', 'all');
        $designation = $request->get('designation', 'all');

        $fileName = 'transfers-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new TransferExport($search, $region, $transferredRegion, $designation), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new TransferImport, $request->file('file'));
            
            return redirect()->route('transfer.index')
                ->with('success', 'Transfer records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('transfer.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('transfer.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'transfer-template-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new TransferTemplateExport, $fileName);
    }
}