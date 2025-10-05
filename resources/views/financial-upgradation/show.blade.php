@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Financial Upgradation Details</h1>
            <p class="text-muted-foreground">View financial upgradation record details</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('financial-upgradation.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                <i class="fa fa-arrow-left mr-2"></i>
                Back to List
            </a>
            <a href="{{ route('financial-upgradation.edit', $financialUpgradation->id) }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                <i class="fa fa-edit mr-2"></i>
                Edit Record
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
            </div>
            <div class="card-content p-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sr No</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->sr_no }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $financialUpgradation->empl_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Region</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $financialUpgradation->region ? App\Models\FinancialUpgradation::REGIONS[$financialUpgradation->region] ?? $financialUpgradation->region : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Department</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $financialUpgradation->department ? App\Models\FinancialUpgradation::DEPARTMENTS[$financialUpgradation->department] ?? $financialUpgradation->department : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Information -->
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Date Information</h2>
            </div>
            <div class="card-content p-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Promotion Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->promotion_date->format('d-M-Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Date in Grade</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->date_in_grade->format('d-M-Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Designation Information -->
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Designation Details</h2>
            </div>
            <div class="card-content p-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Existing Designation</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->existing_designation }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Upgraded Designation</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->upgraded_designation }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Financial Upgradation Type</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $financialUpgradation->financial_upgradation_type }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">No of Financial Upgradation</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->no_of_financial_upgradation }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scale Information -->
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Scale Details</h2>
            </div>
            <div class="card-content p-4 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Existing Scale</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->existing_scale }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Upgraded Scale</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->upgraded_scale }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pay Information -->
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Pay Details</h2>
            </div>
            <div class="card-content p-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Pay Fixed</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $financialUpgradation->pay_fixed == 'YES' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $financialUpgradation->pay_fixed }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Existing Pay</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">₹{{ number_format($financialUpgradation->existing_pay, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Existing Grade Pay</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">₹{{ number_format($financialUpgradation->existing_grade_pay, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Upgraded Pay</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">₹{{ number_format($financialUpgradation->upgraded_pay, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Upgraded Grade Pay</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">₹{{ number_format($financialUpgradation->upgraded_grade_pay, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remarks -->
        @if($financialUpgradation->macp_remarks)
        <div class="card border rounded-xl">
            <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">MACP Remarks</h2>
            </div>
            <div class="card-content p-4">
                <p class="text-sm text-gray-900 dark:text-white">{{ $financialUpgradation->macp_remarks }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Timestamps -->
    <div class="card border rounded-xl">
        <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">System Information</h2>
        </div>
        <div class="card-content p-4">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                    <p class="mt-1 text-gray-900 dark:text-white">{{ $financialUpgradation->created_at->format('d-M-Y H:i:s') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</label>
                    <p class="mt-1 text-gray-900 dark:text-white">{{ $financialUpgradation->updated_at->format('d-M-Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection