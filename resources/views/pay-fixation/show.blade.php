@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pay Fixation Details</h1>
                    <p class="text-gray-600">View pay fixation record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('pay-fixation.index') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <a href="{{ route('pay-fixation.edit', $payFixation->id) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Record
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Basic Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Record ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payFixation->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee ID</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payFixation->empl_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Pay Fixation Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payFixation->formattedPayFixationDate }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pay Details -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Pay Details</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Basic Pay</label>
                                <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $payFixation->formattedBasicPay }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Grade Pay</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payFixation->formattedGradePay }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Level Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Level Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Cell No</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payFixation->cell_no }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Revised Level</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $payFixation->revised_level }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Level 2</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $payFixation->level_2 }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Remarks -->
                @if($payFixation->pay_fixation_remarks)
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Pay Fixation Remarks</h2>
                    </div>
                    <div class="card-content p-4">
                        <p class="text-sm text-gray-900">{{ $payFixation->pay_fixation_remarks }}</p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Timestamps -->
            <div class="card border rounded-xl">
                <div class="card-header p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">System Information</h2>
                </div>
                <div class="card-content p-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created At</label>
                            <p class="mt-1 text-gray-900">{{ $payFixation->created_at->format('d M, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Updated At</label>
                            <p class="mt-1 text-gray-900">{{ $payFixation->updated_at->format('d M, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection