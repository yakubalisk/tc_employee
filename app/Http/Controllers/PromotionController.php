<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Employee;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('employee')->paginate(15);
        return view('promotions.index', compact('promotions'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'EXISTING')->get();
        return view('promotions.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'promotion_type' => 'required|string',
            'from_designation' => 'required|string',
            'to_designation' => 'required|string',
            'promotion_date' => 'required|date',
            'year' => 'required|string',
            'score' => 'nullable|numeric',
            'reviewer_remarks' => 'nullable|string',
            'performance_rating' => 'nullable|in:Excellent,Very Good,Good,Average,Poor',
        ]);

        Promotion::create($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function show(Promotion $promotion)
    {
        return view('promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $employees = Employee::where('status', 'EXISTING')->get();
        return view('promotions.edit', compact('promotion', 'employees'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'promotion_type' => 'required|string',
            'from_designation' => 'required|string',
            'to_designation' => 'required|string',
            'promotion_date' => 'required|date',
            'year' => 'required|string',
            'score' => 'nullable|numeric',
            'reviewer_remarks' => 'nullable|string',
            'performance_rating' => 'nullable|in:Excellent,Very Good,Good,Average,Poor',
        ]);

        $promotion->update($validated);
        return redirect()->route('promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}