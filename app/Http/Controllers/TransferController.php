<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Employee;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = Transfer::with('employee')->paginate(15);
        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'EXISTING')->get();
        return view('transfers.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'present_region' => 'required|string',
            'date_of_joining' => 'required|date',
            'date_of_relieving' => 'nullable|date',
            'duration' => 'nullable|string',
            'transfer_order_no' => 'nullable|string',
            'transfer_remarks' => 'nullable|string',
        ]);

        Transfer::create($validated);
        return redirect()->route('transfers.index')->with('success', 'Transfer created successfully.');
    }

    public function show(Transfer $transfer)
    {
        return view('transfers.show', compact('transfer'));
    }

    public function edit(Transfer $transfer)
    {
        $employees = Employee::where('status', 'EXISTING')->get();
        return view('transfers.edit', compact('transfer', 'employees'));
    }

    public function update(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'present_region' => 'required|string',
            'date_of_joining' => 'required|date',
            'date_of_relieving' => 'nullable|date',
            'duration' => 'nullable|string',
            'transfer_order_no' => 'nullable|string',
            'transfer_remarks' => 'nullable|string',
        ]);

        $transfer->update($validated);
        return redirect()->route('transfers.index')->with('success', 'Transfer updated successfully.');
    }

    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('transfers.index')->with('success', 'Transfer deleted successfully.');
    }
}