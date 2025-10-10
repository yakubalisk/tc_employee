@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add Mode of Recruitment Record</h1>
                    <p class="text-gray-600">Create a new recruitment/promotion record</p>
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
                    <form action="{{ route('mode-of-recruitment.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
<!--                                 <div>
                                    <label for="empID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                                    <input type="text" name="empID" id="empID" value="{{ old('empID') }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('empID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div> -->

                                <!-- Employee Selection -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee *</label>
                                    <select id="employee_id" name="employee_id" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" data-emp_code="{{ $emp->empCode }}" 
                                                {{ (old('employee_id') == $emp->id || (request()->has('employee_id') && request('employee_id') == $emp->id)) ? 'selected' : '' }}>
                                                {{ $emp->name }} (ID: {{ $emp->empId }} | Code: {{ $emp->empCode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            <div>
                                <label for="emp_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee Code *</label>
                                <input type="text" name="emp_code" id="emp_code" value="{{ old('emp_code') }}"
                                       class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                       required>
                                @error('emp_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                                <div>
                                    <label for="Designation_" class="block text-sm font-medium text-gray-700 mb-1">Designation (Current) *</label>
                                    <input type="text" name="Designation_" id="Designation_" value="{{ old('Designation_') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., STAFF CAR DRIVER II" required>
                                    @error('Designation_') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Designation" class="block text-sm font-medium text-gray-700 mb-1">Designation (New) *</label>
                                    <input type="text" name="Designation" id="Designation" value="{{ old('Designation') }}"
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
                                    <input type="number" name="Seniority_Number" id="Seniority_Number" value="{{ old('Seniority_Number') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('Seniority_Number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Date_of_Entry" class="block text-sm font-medium text-gray-700 mb-1">Date of Entry *</label>
                                    <input type="date" name="Date_of_Entry" id="Date_of_Entry" value="{{ old('Date_of_Entry') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('Date_of_Entry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Office_Order_No" class="block text-sm font-medium text-gray-700 mb-1">Office Order No *</label>
                                    <input type="text" name="Office_Order_No" id="Office_Order_No" value="{{ old('Office_Order_No') }}"
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
                                            <option value="{{ $key }}" {{ old('Method_of_Recruitment') == $key ? 'selected' : '' }}>
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
                                            <option value="{{ $key }}" {{ old('Pay_Fixation') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Pay_Fixation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="Promotion_Remarks" class="block text-sm font-medium text-gray-700 mb-1">Promotion Remarks</label>
                                    <textarea name="Promotion_Remarks" id="Promotion_Remarks" rows="3"
                                              class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ old('Promotion_Remarks') }}</textarea>
                                    @error('Promotion_Remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Exit & GSLI Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Exit & GSLI Information</h3>
                                
                                <div>
                                    <label for="Date_of_Exit" class="block text-sm font-medium text-gray-700 mb-1">Date of Exit</label>
                                    <input type="date" name="Date_of_Exit" id="Date_of_Exit" value="{{ old('Date_of_Exit') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('Date_of_Exit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Policy_No" class="block text-sm font-medium text-gray-700 mb-1">GSLI Policy No</label>
                                    <input type="text" name="GSLI_Policy_No" id="GSLI_Policy_No" value="{{ old('GSLI_Policy_No') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('GSLI_Policy_No') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Entry_dt" class="block text-sm font-medium text-gray-700 mb-1">GSLI Entry Date</label>
                                    <input type="date" name="GSLI_Entry_dt" id="GSLI_Entry_dt" value="{{ old('GSLI_Entry_dt') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('GSLI_Entry_dt') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="GSLI_Exit_dt" class="block text-sm font-medium text-gray-700 mb-1">GSLI Exit Date</label>
                                    <input type="date" name="GSLI_Exit_dt" id="GSLI_Exit_dt" value="{{ old('GSLI_Exit_dt') }}"
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
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    const employeeSelect = document.getElementById('employee_id');
    const emplIdInput = document.getElementById('emp_code');
    // alert(emplIdInput);
    // alert(employeeSelect);

    function updateEmpCode() {
        const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
        // alert(selectedOption.dataset);
        // console.log(selectedOption.dataset.emp_code);
        if (selectedOption && selectedOption.dataset.emp_code) {
            emplIdInput.value = selectedOption.dataset.emp_code;
        } else {
            emplIdInput.value = '';
        }
    }

    // Initial update on page load if selection exists
    updateEmpCode();

    // Update on each change
    employeeSelect.addEventListener('change', updateEmpCode);
});

</script>