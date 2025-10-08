@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Family Member Details</h1>
                    <p class="text-gray-600">View family member record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('family.index') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <a href="{{ route('family.edit', $family->id) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Family Member
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
                                <p class="mt-1 text-sm text-gray-900">{{ $family->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee ID</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $family->empID }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Family Member Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $family->name_of_family_member }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Relationship</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $family->relationship }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date of Birth & Age -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Date of Birth & Age</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $family->formattedDateOfBirth }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Age</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $family->age ?? $family->calculated_age }} years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dependence Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Dependence Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dependent Remarks</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $family->dependent_remarks ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Reason for Dependence</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $family->reason_for_dependence ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Benefits Eligibility -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Benefits Eligibility</h2>
                    </div>
                    <div class="card-content p-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->ltc ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">LTC</span>
                            </div>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->medical ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Medical</span>
                            </div>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->gsli ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">GSLI</span>
                            </div>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->gpf ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">GPF</span>
                            </div>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->dcrg ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">DCRG</span>
                            </div>
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full {{ $family->pension_nps ? 'bg-green-500' : 'bg-gray-300' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Pension/NPS</span>
                            </div>
                        </div>
                    </div>
                </div>

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
                            <p class="mt-1 text-gray-900">{{ $family->created_at->format('d M, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Updated At</label>
                            <p class="mt-1 text-gray-900">{{ $family->updated_at->format('d M, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection