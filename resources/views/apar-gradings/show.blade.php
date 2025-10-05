@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">APAR Grading Details</h1>
                    <p class="text-gray-600">View APAR record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('apar.edit', $aparGrading->id) }}" 
                       class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit APAR
                    </a>
                    <a href="{{ route('apar.index') }}" 
                       class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to APAR List
                    </a>
                </div>
            </div>

            <!-- APAR Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">Basic Information</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Employee</label>
                            <p class="text-gray-900 font-medium">{{ $aparGrading->employee->name }}</p>
                            <p class="text-sm text-gray-600">ID: {{ $aparGrading->employee->empId }} | Code: {{ $aparGrading->employee->empCode }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">From Period</label>
                                <p class="text-gray-900">{{ $aparGrading->from_month }} {{ $aparGrading->from_year }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">To Period</label>
                                <p class="text-gray-900">{{ $aparGrading->to_month }} {{ $aparGrading->to_year }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Grading Type</label>
                            <p class="text-gray-900">{{ $aparGrading->grading_type }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">APAR Consideration</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $aparGrading->consideration ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $aparGrading->consideration ? 'TRUE' : 'FALSE' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Grading Details -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">Grading Details</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Reporting Officer Marks</label>
                                <p class="text-gray-900">{{ $aparGrading->reporting_marks ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Reviewing Officer Marks</label>
                                <p class="text-gray-900">{{ $aparGrading->reviewing_marks ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Reporting ACR Grade</label>
                                <p class="text-gray-900">{{ $aparGrading->reporting_grade ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Reviewing ACR Grade</label>
                                <p class="text-gray-900">{{ $aparGrading->reviewing_grade ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remarks Section -->
            <div class="card border rounded-xl">
                <div class="card-header mb-5">
                    <div class="card-title text-2xl">Remarks</div>
                </div>
                <div class="card-content space-y-4">
                    <div>
                        <label class="label text-sm font-semibold text-gray-500">APAR Discrepancy Remarks</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $aparGrading->discrepancy_remarks ?? 'No discrepancy remarks' }}</p>
                    </div>

                    <div>
                        <label class="label text-sm font-semibold text-gray-500">APAR Remarks</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $aparGrading->remarks ?? 'No additional remarks' }}</p>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card border rounded-xl">
                <div class="card-header mb-5">
                    <div class="card-title text-2xl">System Information</div>
                </div>
                <div class="card-content">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Created At</label>
                            <p class="text-gray-900">{{ $aparGrading->created_at->format('d M, Y h:i A') }}</p>
                        </div>
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Last Updated</label>
                            <p class="text-gray-900">{{ $aparGrading->updated_at->format('d M, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection