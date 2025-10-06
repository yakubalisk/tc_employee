<?php

namespace App\Http\Controllers;

use App\Models\PayFixation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayFixationExport;
use App\Imports\PayFixationImport;
use App\Exports\PayFixationTemplateExport;

class PayFixationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $level = $request->get('level', 'all');
        $level2 = $request->get('level2', 'all');

        $records = PayFixation::query()
            ->search($search)
            ->filterByLevel($level)
            ->filterByLevel2($level2)
            ->orderBy('pay_fixation_date', 'desc')
            ->paginate(10);

        return view('pay-fixation.index', compact(
            'records', 
            'search', 
            'level', 
            'level2'
        ));
    }

    public function create()
    {
        return view('pay-fixation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empl_id' => 'required|string|max:50',
            'pay_fixation_date' => 'required|date',
            'basic_pay' => 'required|numeric|min:0',
            'grade_pay' => 'nullable|numeric|min:0',
            'cell_no' => 'required|integer|min:1',
            'revised_level' => 'required|string|max:50',
            'pay_fixation_remarks' => 'nullable|string',
            'level_2' => 'required|string|max:10',
        ]);

        PayFixation::create($validated);

        return redirect()->route('pay-fixation.index')
            ->with('success', 'Pay fixation record created successfully.');
    }

    public function show(PayFixation $payFixation)
    {
        return view('pay-fixation.show', compact('payFixation'));
    }

    public function edit(PayFixation $payFixation)
    {
        return view('pay-fixation.edit', compact('payFixation'));
    }

    public function update(Request $request, PayFixation $payFixation)
    {
        $validated = $request->validate([
            'empl_id' => 'required|string|max:50',
            'pay_fixation_date' => 'required|date',
            'basic_pay' => 'required|numeric|min:0',
            'grade_pay' => 'nullable|numeric|min:0',
            'cell_no' => 'required|integer|min:1',
            'revised_level' => 'required|string|max:50',
            'pay_fixation_remarks' => 'nullable|string',
            'level_2' => 'required|string|max:10',
        ]);

        $payFixation->update($validated);

        return redirect()->route('pay-fixation.index')
            ->with('success', 'Pay fixation record updated successfully.');
    }

    public function destroy(PayFixation $payFixation)
    {
        $payFixation->delete();

        return redirect()->route('pay-fixation.index')
            ->with('success', 'Pay fixation record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $level = $request->get('level', 'all');
        $level2 = $request->get('level2', 'all');

        $fileName = 'pay-fixation-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PayFixationExport($search, $level, $level2), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PayFixationImport, $request->file('file'));
            
            return redirect()->route('pay-fixation.index')
                ->with('success', 'Pay fixation records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('pay-fixation.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('pay-fixation.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'pay-fixation-template-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new PayFixationTemplateExport, $fileName);
    }
}