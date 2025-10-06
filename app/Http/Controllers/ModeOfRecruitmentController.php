<?php

namespace App\Http\Controllers;

use App\Models\ModeOfRecruitment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModeOfRecruitmentExport;
use App\Imports\ModeOfRecruitmentImport;
use App\Exports\ModeOfRecruitmentTemplateExport;

class ModeOfRecruitmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $method = $request->get('method', 'all');
        $payFixation = $request->get('pay_fixation', 'all');

        $records = ModeOfRecruitment::query()
            ->search($search)
            ->filterByMethod($method)
            ->filterByPayFixation($payFixation)
            ->orderBy('Date_of_Entry', 'desc')
            ->paginate(10);

        return view('mode-of-recruitment.index', compact(
            'records', 
            'search', 
            'method', 
            'payFixation'
        ));
    }

    public function create()
    {
        return view('mode-of-recruitment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'Designation_' => 'required|string|max:255',
            'Seniority_Number' => 'required|integer',
            'Designation' => 'required|string|max:255',
            'Date_of_Entry' => 'required|date',
            'Office_Order_No' => 'required|string|max:255',
            'Method_of_Recruitment' => 'required|in:PR,DIRECT,DEPUTATION,CONTRACT',
            'Promotion_Remarks' => 'nullable|string',
            'Pay_Fixation' => 'required|in:Yes,No',
            'Date_of_Exit' => 'nullable|date',
            'GSLI_Policy_No' => 'nullable|string|max:100',
            'GSLI_Entry_dt' => 'nullable|date',
            'GSLI_Exit_dt' => 'nullable|date',
        ]);

        ModeOfRecruitment::create($validated);

        return redirect()->route('mode-of-recruitment.index')
            ->with('success', 'Mode of Recruitment record created successfully.');
    }

    public function show(ModeOfRecruitment $modeOfRecruitment)
    {
        return view('mode-of-recruitment.show', compact('modeOfRecruitment'));
    }

    public function edit(ModeOfRecruitment $modeOfRecruitment)
    {
        return view('mode-of-recruitment.edit', compact('modeOfRecruitment'));
    }

    public function update(Request $request, ModeOfRecruitment $modeOfRecruitment)
    {
        $validated = $request->validate([
            'empID' => 'required|string|max:50',
            'Designation_' => 'required|string|max:255',
            'Seniority_Number' => 'required|integer',
            'Designation' => 'required|string|max:255',
            'Date_of_Entry' => 'required|date',
            'Office_Order_No' => 'required|string|max:255',
            'Method_of_Recruitment' => 'required|in:PR,DIRECT,DEPUTATION,CONTRACT',
            'Promotion_Remarks' => 'nullable|string',
            'Pay_Fixation' => 'required|in:Yes,No',
            'Date_of_Exit' => 'nullable|date',
            'GSLI_Policy_No' => 'nullable|string|max:100',
            'GSLI_Entry_dt' => 'nullable|date',
            'GSLI_Exit_dt' => 'nullable|date',
        ]);

        $modeOfRecruitment->update($validated);

        return redirect()->route('mode-of-recruitment.index')
            ->with('success', 'Mode of Recruitment record updated successfully.');
    }

    public function destroy(ModeOfRecruitment $modeOfRecruitment)
    {
        $modeOfRecruitment->delete();

        return redirect()->route('mode-of-recruitment.index')
            ->with('success', 'Mode of Recruitment record deleted successfully.');
    }

    public function export(Request $request)
    {
        $search = $request->get('search');
        $method = $request->get('method', 'all');
        $payFixation = $request->get('pay_fixation', 'all');

        $fileName = 'mode-of-recruitment-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new ModeOfRecruitmentExport($search, $method, $payFixation), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ModeOfRecruitmentImport, $request->file('file'));
            
            return redirect()->route('mode-of-recruitment.index')
                ->with('success', 'Mode of Recruitment records imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('mode-of-recruitment.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('mode-of-recruitment.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'mode-of-recruitment-template-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new ModeOfRecruitmentTemplateExport, $fileName);
    }
}