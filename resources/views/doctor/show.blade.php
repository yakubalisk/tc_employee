@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Doctor Details</h1>
                    <p class="text-gray-600">View doctor record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('doctor.index') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <a href="{{ route('doctor.edit', $doctor->id) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Doctor
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
                                <p class="mt-1 text-sm text-gray-900">{{ $doctor->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee ID</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $doctor->empID }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Doctor Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $doctor->formattedDoctorName }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Registration No</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $doctor->registration_no ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Qualification Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Qualification Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Qualification</label>
                            @if($doctor->qualification)
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $doctor->qualification }}
                                    </span>
                                </p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">N/A</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Address Information</h2>
                    </div>
                    <div class="card-content p-4">
                        <label class="block text-sm font-medium text-gray-500">Address</label>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $doctor->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- AMA Remarks -->
                @if($doctor->ama_remarks)
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">AMA Remarks</h2>
                    </div>
                    <div class="card-content p-4">
                        <p class="text-sm text-gray-900">{{ $doctor->ama_remarks }}</p>
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
                            <p class="mt-1 text-gray-900">{{ $doctor->created_at->format('d M, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Updated At</label>
                            <p class="mt-1 text-gray-900">{{ $doctor->updated_at->format('d M, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection