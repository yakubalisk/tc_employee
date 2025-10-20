@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Transfer Details</h1>
                    <p class="text-gray-600">View employee transfer record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('transfer.index') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <a href="{{ route('transfer.edit', $transfer->transferId) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Transfer
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Employee Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Employee Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transfer ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->transferId }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee Code</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->employee->empCode }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $transfer->employee->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Designation</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->designation->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transfer Dates -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Transfer Dates</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Joining</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->formattedDateOfJoining }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Releiving</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->formattedDateOfReleiving }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Exit</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->formattedDateOfExit ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Duration</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $transfer->duration ?? $transfer->calculatedDuration }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transfer Details -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Transfer Details</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Transfer Order No</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $transfer->transfer_order_no }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">From Region</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $transfer->region->name ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">To Region</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $transfer->transferredRegion->name ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Department Worked</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $transfer->departmentWorked->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Remarks -->
                @if($transfer->transfer_remarks)
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Transfer Remarks</h2>
                    </div>
                    <div class="card-content p-4">
                        <p class="text-sm text-gray-900">{{ $transfer->transfer_remarks }}</p>
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
                            <p class="mt-1 text-gray-900">{{ $transfer->created_at->format('d M, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Updated At</label>
                            <p class="mt-1 text-gray-900">{{ $transfer->updated_at->format('d M, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection