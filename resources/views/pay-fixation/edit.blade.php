@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Pay Fixation Record</h1>
                    <p class="text-gray-600">Update pay fixation record details</p>
                </div>
                <a href="{{ route('pay-fixation.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('pay-fixation.update', $payFixation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <!-- <div>
                                    <label for="empl_id" class="block text-sm font-medium text-gray-700 mb-1">Employee *</label>
                                    <input type="text" name="empl_id" id="empl_id" value="{{ old('empl_id', $payFixation->empl_id) }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('empl_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div> -->

                                <div>
                            <label for="employee_id" class="label text-sm font-semibold">Employee *</label>
                            <select id="employee_id" name="employee_id" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" data-emp_code="{{ $emp->empCode }}" {{ old('employee_id', $payFixation->employee_id) == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }} (ID: {{ $emp->empId }} | Code: {{ $emp->empCode }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                                <div>
                                    <label for="pay_fixation_date" class="block text-sm font-medium text-gray-700 mb-1">Pay Fixation Date *</label>
                                    <input type="date" name="pay_fixation_date" id="pay_fixation_date" value="{{ old('pay_fixation_date', $payFixation->pay_fixation_date->format('Y-m-d')) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('pay_fixation_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Pay Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Pay Details</h3>
                                
                                <div>
                                    <label for="basic_pay" class="block text-sm font-medium text-gray-700 mb-1">Basic Pay *</label>
                                    <input type="number" step="0.01" name="basic_pay" id="basic_pay" value="{{ old('basic_pay', $payFixation->basic_pay) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="0.00" required>
                                    @error('basic_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="grade_pay" class="block text-sm font-medium text-gray-700 mb-1">Grade Pay</label>
                                    <input type="number" step="0.01" name="grade_pay" id="grade_pay" value="{{ old('grade_pay', $payFixation->grade_pay) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="0.00">
                                    @error('grade_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Level Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Level Information</h3>
                                
                                <div>
                                    <label for="cell_no" class="block text-sm font-medium text-gray-700 mb-1">Cell No *</label>
                                    <input type="number" name="cell_no" id="cell_no" value="{{ old('cell_no', $payFixation->cell_no) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           min="1" required>
                                    @error('cell_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="revised_level" class="block text-sm font-medium text-gray-700 mb-1">Revised Level *</label>
                                    <select name="revised_level" id="revised_level" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Level</option>
                                        @foreach(App\Models\PayFixation::REVISED_LEVELS as $key => $value)
                                            <option value="{{ $key }}" {{ old('revised_level', $payFixation->revised_level) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('revised_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="level_2" class="block text-sm font-medium text-gray-700 mb-1">Level 2 *</label>
                                    <select name="level_2" id="level_2" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Level</option>
                                        @foreach(App\Models\PayFixation::LEVEL_2_OPTIONS as $key => $value)
                                            <option value="{{ $key }}" {{ old('level_2', $payFixation->level_2) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level_2') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Remarks -->
                        <div class="mt-6">
                            <label for="pay_fixation_remarks" class="block text-sm font-medium text-gray-700 mb-1">Pay Fixation Remarks</label>
                            <textarea name="pay_fixation_remarks" id="pay_fixation_remarks" rows="3"
                                      class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ old('pay_fixation_remarks', $payFixation->pay_fixation_remarks) }}</textarea>
                            @error('pay_fixation_remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('pay-fixation.index') }}" 
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