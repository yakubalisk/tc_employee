@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Mode of Recruitment Record</h1>
                    <p class="text-gray-600">Update recruitment/promotion record details</p>
                </div>
                <a href="{{ route('mode-of-recruitment.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('mode-of-recruitment.update', $modeOfRecruitment->PromotionID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <div>
                                    <label for="empID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                                    <input type="text" name="empID" id="empID" value="{{ old('empID', $modeOfRecruitment->empID) }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('empID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Designation_" class="block text-sm font-medium text-gray-700 mb-1">Designation (Current) *</label>
                                    <input type="text" name="Designation_" id="Designation_" value="{{ old('Designation_', $modeOfRecruitment->Designation_) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., STAFF CAR DRIVER II" required>
                                    @error('Designation_') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Designation" class="block text-sm font-medium text-gray-700 mb-1">Designation (New) *</label>
                                    <input type="text" name="Designation" id="Designation" value="{{ old('Designation', $modeOfRecruitment->Designation) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., STAFF CAR DRIVER II" required>
                                    @error('Designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Recruitment Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Recruitment Details</h3>
                                
                                <div>
                                    <label for="Seniority_Number" class="block text-sm font-medium text-gray-700 mb-1">Seniority Number *</label>
                                    <input type="number" name="Seniority_Number" id="Seniority_Number" value="{{ old('Seniority_Number', $modeOfRecruitment->Seniority_Number) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('Seniority_Number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Date_of_Entry" class="block text-sm font-medium text-gray-700 mb-1">Date of Entry *</label>
                                    <input type="date" name="Date_of_Entry" id="Date_of_Entry" value="{{ old('Date_of_Entry', $modeOfRecruitment->Date_of_Entry->format('Y-m-d')) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('Date_of_Entry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Office_Order_No" class="block text-sm font-medium text-gray-700 mb-1">Office Order No *</label>
                                    <input type="text" name="Office_Order_No" id="Office_Order_No" value="{{ old('Office_Order_No', $modeOfRecruitment->Office_Order_No) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 29/74/96/AD dated 24.06.2025" required>
                                    @error('Office_Order_No') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Method & Pay Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Method & Pay Details</h3>
                                
                                <div>
                                    <label for="Method_of_Recruitment" class="block text-sm font-medium text-gray-700 mb-1">Method of Recruitment *</label>
                                    <select name="Method_of_Recruitment" id="Method_of_Recruitment" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Method</option>
                                        @foreach(App\Models\ModeOfRecruitment::RECRUITMENT_METHODS as $key => $value)
                                            <option value="{{ $key }}" {{ old('Method_of_Recruitment', $modeOfRecruitment->Method_of_Recruitment) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Method_of_Recruitment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Pay_Fixation" class="block text-sm font-medium text-gray-700 mb-1">Pay Fixation *</label>
                                    <select name="Pay_Fixation" id="Pay_Fixation" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Option</option>
                                        @foreach(App\Models\ModeOfRecruitment::PAY_FIXATION_OPTIONS as $key => $value)
                                            <option value="{{ $key }}" {{ old('Pay_Fixation', $modeOfRecruitment->Pay_Fixation) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Pay_Fixation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Promotion_Remarks" class="block text-sm font-medium text-gray-700 mb-1">Promotion Remarks</label>
                                    <textarea name="Promotion_Remarks" id="Promotion_Remarks" rows="3"
                                              class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ old('Promotion_Remarks', $modeOfRecruitment->Promotion_Remarks) }}</textarea>
                                    @error('Promotion_Remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Exit & GSLI Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Exit & GSLI Information</h3>
                                
                                <div>
                                    <label for="Date_of_Exit" class="block text-sm font-medium text-gray-700 mb-1">Date of Exit</label>
                                    <input type="date" name="Date_of_Exit" id="Date_of_Exit" value="{{ old('Date_of_Exit', $modeOfRecruitment->Date_of_Exit ? $modeOfRecruitment->Date_of_Exit->format('Y-m-d') : '') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('Date_of_Exit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Policy_No" class="block text-sm font-medium text-gray-700 mb-1">GSLI Policy No</label>
                                    <input type="text" name="GSLI_Policy_No" id="GSLI_Policy_No" value="{{ old('GSLI_Policy_No', $modeOfRecruitment->GSLI_Policy_No) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('GSLI_Policy_No') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Entry_dt" class="block text-sm font-medium text-gray-700 mb-1">GSLI Entry Date</label>
                                    <input type="date" name="GSLI_Entry_dt" id="GSLI_Entry_dt" value="{{ old('GSLI_Entry_dt', $modeOfRecruitment->GSLI_Entry_dt ? $modeOfRecruitment->GSLI_Entry_dt->format('Y-m-d') : '') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('GSLI_Entry_dt') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Exit_dt" class="block text-sm font-medium text-gray-700 mb-1">GSLI Exit Date</label>
                                    <input type="date" name="GSLI_Exit_dt" id="GSLI_Exit_dt" value="{{ old('GSLI_Exit_dt', $modeOfRecruitment->GSLI_Exit_dt ? $modeOfRecruitment->GSLI_Exit_dt->format('Y-m-d') : '') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('GSLI_Exit_dt') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('mode-of-recruitment.index') }}" 
                               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection