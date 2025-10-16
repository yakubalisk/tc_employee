@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add Family Member</h1>
                    <p class="text-gray-600">Create a new family member record</p>
                </div>
                <a href="{{ route('family.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('family.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <!-- <div>
                                    <label for="empID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                                    <input type="text" name="empID" id="empID" value="{{ old('empID') }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('empID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div> -->

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
                                    <label for="name_of_family_member" class="block text-sm font-medium text-gray-700 mb-1">Family Member Name *</label>
                                    <input type="text" name="name_of_family_member" id="name_of_family_member" value="{{ old('name_of_family_member') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Enter full name" required>
                                    @error('name_of_family_member') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="relationship" class="block text-sm font-medium text-gray-700 mb-1">Relationship *</label>
                                    <select name="relationship" id="relationship" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Relationship</option>
                                        @foreach(App\Models\Family::RELATIONSHIPS as $key => $value)
                                            <option value="{{ $key }}" {{ old('relationship') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('relationship') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Date of Birth & Age -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Date of Birth & Age</h3>
                                
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Calculated Age</label>
                                    <div id="age_display" class="py-2 px-3 block w-full bg-gray-100 border-gray-200 rounded-lg text-sm text-gray-600">
                                        Age will be calculated automatically
                                    </div>
                                </div>
                            </div>

                            <!-- Dependence Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Dependence Information</h3>
                                
                                <div>
                                    <label for="dependent_remarks" class="block text-sm font-medium text-gray-700 mb-1">Dependent Remarks</label>
                                    <input type="text" name="dependent_remarks" id="dependent_remarks" value="{{ old('dependent_remarks') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., DEPENDENT, Dependent">
                                    @error('dependent_remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="reason_for_dependence" class="block text-sm font-medium text-gray-700 mb-1">Reason for Dependence</label>
                                    <select name="reason_for_dependence" id="reason_for_dependence" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Reason</option>
                                        @foreach(App\Models\Family::DEPENDENCE_REASONS as $key => $value)
                                            <option value="{{ $key }}" {{ old('reason_for_dependence') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reason_for_dependence') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Benefits Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Benefits Eligibility</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                                
                                <div class="flex items-center">
                                    <input type="checkbox" name="ltc" id="ltc" value="1" {{ old('ltc') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="ltc" class="ml-2 block text-sm text-gray-700">LTC</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="medical" id="medical" value="1" {{ old('medical') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="medical" class="ml-2 block text-sm text-gray-700">Medical</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="gsli" id="gsli" value="1" {{ old('gsli') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="gsli" class="ml-2 block text-sm text-gray-700">GSLI</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="gpf" id="gpf" value="1" {{ old('gpf') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="gpf" class="ml-2 block text-sm text-gray-700">GPF</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="dcrg" id="dcrg" value="1" {{ old('dcrg') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="dcrg" class="ml-2 block text-sm text-gray-700">DCRG</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="pension_nps" id="pension_nps" value="1" {{ old('pension_nps') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="pension_nps" class="ml-2 block text-sm text-gray-700">Pension/NPS</label>
                                </div>

                            </div>
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('family.index') }}" 
                               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>
                                Save Family Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate age when date of birth is changed
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.getElementById('date_of_birth');
        const ageDisplay = document.getElementById('age_display');

        function calculateAge() {
            if (dobInput.value) {
                const birthDate = new Date(dobInput.value);
                const today = new Date();
                
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                
                ageDisplay.textContent = age + ' years';
            } else {
                ageDisplay.textContent = 'Age will be calculated automatically';
            }
        }

        dobInput.addEventListener('change', calculateAge);
    });
</script>
@endsection