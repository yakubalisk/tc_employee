<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $type = $request->get('type', 'all');
        $year = $request->get('year', now()->year);

        $query = Promotion::with(['employee', 'approvedBy'])
            ->when($status !== 'all', function ($q) use ($status) {
                return $q->where('approval_status', $status);
            })
            ->when($type !== 'all', function ($q) use ($type) {
                return $q->where('type', $type);
            })
            ->when($year, function ($q) use ($year) {
                return $q->whereYear('effective_date', $year);
            });

        $promotions = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total_promotions' => Promotion::count(),
            'approved_promotions' => Promotion::approved()->count(),
            'pending_approvals' => Promotion::pending()->count(),
            'this_year_promotions' => Promotion::thisYear()->approved()->count(),
        ];

        $eligibleEmployees = Employee::eligibleForPromotion()->get();
        $recentPromotions = Promotion::with('employee')
            ->approved()
            ->orderBy('effective_date', 'desc')
            ->take(5)
            ->get();

        return view('promotions.index', compact(
            'promotions',
            'stats',
            'eligibleEmployees',
            'recentPromotions',
            'status',
            'type',
            'year'
        ));
    }

    public function create()
    {
        $employees = Employee::eligibleForPromotion()->get();
        return view('promotions.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:Regular Promotion,MACP,ACP,Financial Upgradation',
            'new_designation' => 'required|string|max:255',
            'effective_date' => 'required|date|after_or_equal:today',
            'remarks' => 'nullable|string',
            'financial_details' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $employee = Employee::findOrFail($request->employee_id);

                $promotion = Promotion::create([
                    'employee_id' => $request->employee_id,
                    'type' => $request->type,
                    'previous_designation' => $employee->current_designation ?? $employee->designationAtAppointment,
                    'new_designation' => $request->new_designation,
                    'effective_date' => $request->effective_date,
                    'remarks' => $request->remarks,
                    'financial_details' => $request->financial_details,
                    'approval_status' => 'Pending',
                ]);

                // Update employee's current designation immediately
                $employee->update([
                    'current_designation' => $request->new_designation
                ]);
            });

            return redirect()->route('promotions.index')
                ->with('success', 'Promotion request created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating promotion: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function approve(Promotion $promotion)
    {
        try {
            DB::transaction(function () use ($promotion) {
                $promotion->update([
                    'approval_status' => 'Approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Update employee record with promotion details
                $promotion->employee->update([
                    'current_designation' => $promotion->new_designation,
                    'last_promotion_date' => $promotion->effective_date,
                    'current_promotion_id' => $promotion->id,
                ]);
            });

            return redirect()->back()->with('success', 'Promotion approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving promotion: ' . $e->getMessage());
        }
    }

    public function reject(Promotion $promotion, Request $request)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $promotion->update([
            'approval_status' => 'Rejected',
            'remarks' => $request->rejection_reason . "\n\n" . $promotion->remarks,
        ]);

        return redirect()->back()->with('success', 'Promotion rejected successfully!');
    }

    public function show(Promotion $promotion)
    {
        $promotion->load(['employee', 'approvedBy']);
        return view('promotions.show', compact('promotion'));
    }

    public function report(Request $request)
    {
        $year = $request->get('year', now()->year);
        $type = $request->get('type', 'all');
        $department = $request->get('department', 'all');

        $query = Promotion::with('employee')
            ->approved()
            ->whereYear('effective_date', $year)
            ->when($type !== 'all', function ($q) use ($type) {
                return $q->where('type', $type);
            })
            ->when($department !== 'all', function ($q) use ($department) {
                return $q->whereHas('employee', function ($q) use ($department) {
                    return $q->where('presentPosting', $department);
                });
            });

        $promotions = $query->orderBy('effective_date')->get();
        $summary = $this->generateReportSummary($promotions);

        return view('promotions.report', compact('promotions', 'summary', 'year', 'type', 'department'));
    }

    private function generateReportSummary($promotions)
    {
        return [
            'total' => $promotions->count(),
            'by_type' => $promotions->groupBy('type')->map->count(),
            'by_department' => $promotions->groupBy('employee.presentPosting')->map->count(),
            'by_month' => $promotions->groupBy(function ($item) {
                return $item->effective_date->format('F');
            })->map->count(),
        ];
    }
}