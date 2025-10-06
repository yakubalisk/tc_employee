@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mode of Recruitment Details</h1>
                    <p class="text-gray-600">View recruitment/promotion record details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mode-of-recruitment.index') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <a href="{{ route('mode-of-recruitment.edit', $modeOfRecruitment->PromotionID) }}" 
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
                                <label class="block text-sm font-medium text-gray-500">Promotion ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->PromotionID }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Employee ID</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $modeOfRecruitment->empID }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Current Designation</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->Designation_ }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">New Designation</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->Designation }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Seniority Number</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->Seniority_Number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recruitment Details -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recruitment Details</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Entry</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->formattedDateOfEntry }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Method of Recruitment</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $modeOfRecruitment->Method_of_Recruitment }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Pay Fixation</label>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $modeOfRecruitment->Pay_Fixation == 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $modeOfRecruitment->Pay_Fixation }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Office Order No</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->Office_Order_No }}</p>
                        </div>
                    </div>
                </div>

                <!-- Remarks -->
                @if($modeOfRecruitment->Promotion_Remarks)
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Promotion Remarks</h2>
                    </div>
                    <div class="card-content p-4">
                        <p class="text-sm text-gray-900">{{ $modeOfRecruitment->Promotion_Remarks }}</p>
                    </div>
                </div>
                @endif

                <!-- Exit & GSLI Information -->
                <div class="card border rounded-xl">
                    <div class="card-header p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Exit & GSLI Information</h2>
                    </div>
                    <div class="card-content p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Exit</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->formattedDateOfExit ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">GSLI Policy No</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $modeOfRecruitment->GSLI_Policy_No ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">GSLI Entry Date</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $modeOfRecruitment->GSLI_Entry_dt ? $modeOfRecruitment->GSLI_Entry_dt->format('d-m-Y') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">GSLI Exit Date</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $modeOfRecruitment->GSLI_Exit_dt ? $modeOfRecruitment->GSLI_Exit_dt->format('d-m-Y') : 'N/A' }}
                                </p>
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
                            <p class="mt-1 text-gray-900">{{ $modeOfRecruitment->created_at->format('d M, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Updated At</label>
                            <p class="mt-1 text-gray-900">{{ $modeOfRecruitment->updated_at->format('d M, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection