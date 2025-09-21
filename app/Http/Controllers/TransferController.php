<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $location = $request->get('location', 'all');

        $query = Transfer::with(['employee', 'approvedBy'])
            ->when($status !== 'all', function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when($location !== 'all', function ($q) use ($location) {
                return $q->where('new_posting', $location);
            });

        $transfers = $query->orderBy('created_at', 'desc')->paginate(20);

        $locations = Transfer::distinct()->pluck('new_posting');
        $currentLocations = Employee::distinct()->pluck('current_posting');

        $stats = [
            'total_transfers' => Transfer::count(),
            'active_locations' => $currentLocations->count(),
            'pending_transfers' => Transfer::pending()->count(),
            'this_month_transfers' => Transfer::thisMonth()->count(),
        ];

        $eligibleEmployees = Employee::eligibleForTransfer()->get();
        $recentTransfers = Transfer::with('employee')
            ->approved()
            ->orderBy('transfer_date', 'desc')
            ->take(5)
            ->get();

        return view('transfers.index', compact(
            'transfers',
            'stats',
            'eligibleEmployees',
            'recentTransfers',
            'locations',
            'currentLocations',
            'status',
            'location'
        ));
    }

    public function create()
    {
        $employees = Employee::eligibleForTransfer()->get();
        $locations = ['MUMBAI', 'DELHI', 'KOLKATA', 'CHENNAI', 'BANGALORE', 'HYDERABAD', 'PUNE', 'AHMEDABAD'];
        
        return view('transfers.create', compact('employees', 'locations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'new_posting' => 'required|string|max:255',
            'transfer_date' => 'required|date|after_or_equal:today',
            'transfer_order_no' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $employee = Employee::findOrFail($request->employee_id);

                $transfer = Transfer::create([
                    'employee_id' => $request->employee_id,
                    'previous_posting' => $employee->current_posting,
                    'new_posting' => $request->new_posting,
                    'transfer_date' => $request->transfer_date,
                    'transfer_order_no' => $request->transfer_order_no,
                    'remarks' => $request->remarks,
                    'status' => 'Pending',
                    'date_of_joining' => $request->transfer_date,
                ]);

                // Update employee's current posting immediately
                $employee->update([
                    'current_posting' => $request->new_posting
                ]);
            });

            return redirect()->route('transfers.index')
                ->with('success', 'Transfer request created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating transfer: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function approve(Transfer $transfer)
    {
        try {
            DB::transaction(function () use ($transfer) {
                $transfer->update([
                    'status' => 'Approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Update employee record with transfer details
                $transfer->employee->update([
                    'current_posting' => $transfer->new_posting,
                    'last_transfer_date' => $transfer->transfer_date,
                    'current_transfer_id' => $transfer->id,
                ]);
            });

            return redirect()->back()->with('success', 'Transfer approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving transfer: ' . $e->getMessage());
        }
    }

    public function complete(Transfer $transfer)
    {
        $transfer->update([
            'status' => 'Completed',
            'date_of_relieving' => now(),
        ]);

        return redirect()->back()->with('success', 'Transfer marked as completed!');
    }

    public function reject(Transfer $transfer, Request $request)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $transfer->update([
            'status' => 'Rejected',
            'remarks' => $request->rejection_reason . "\n\n" . $transfer->remarks,
        ]);

        // Revert employee posting if it was updated
        if ($transfer->employee->current_posting === $transfer->new_posting) {
            $transfer->employee->update([
                'current_posting' => $transfer->previous_posting
            ]);
        }

        return redirect()->back()->with('success', 'Transfer rejected successfully!');
    }

    public function show(Transfer $transfer)
    {
        $transfer->load(['employee', 'approvedBy']);
        return view('transfers.show', compact('transfer'));
    }

    public function getLocationDistribution()
    {
        $distribution = Employee::select('current_posting', DB::raw('COUNT(*) as count'))
            ->whereNotNull('current_posting')
            ->groupBy('current_posting')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json($distribution);
    }
}