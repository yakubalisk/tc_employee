@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Edit Financial Upgradation Record</h1>
            <p class="text-muted-foreground">Update financial upgradation record details</p>
        </div>
        <a href="{{ route('financial-upgradation.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
            <i class="fa fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>

    <div class="card border rounded-xl">
        <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Record Details</h2>
        </div>
        <div class="card-content p-4">
            <form action="{{ route('financial-upgradation.update', $financialUpgradation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                        
                        <div>
                            <label for="sr_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sr No *</label>
                            <input type="number" name="sr_no" id="sr_no" value="{{ old('sr_no', $financialUpgradation->sr_no) }}" 
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('sr_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="empl_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee ID *</label>
                            <input type="text" name="empl_id" id="empl_id" value="{{ old('empl_id', $financialUpgradation->empl_id) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('empl_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Region</label>
                            <select name="region" id="region" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option value="">Select Region</option>
                                @foreach(App\Models\FinancialUpgradation::REGIONS as $key => $value)
                                    <option value="{{ $key }}" {{ old('region', $financialUpgradation->region) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('region') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                            <select name="department" id="department" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option value="">Select Department</option>
                                @foreach(App\Models\FinancialUpgradation::DEPARTMENTS as $key => $value)
                                    <option value="{{ $key }}" {{ old('department', $financialUpgradation->department) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Designation Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Designation Details</h3>
                        
                        <div>
                            <label for="existing_designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Existing Designation *</label>
                            <select name="existing_designation" id="existing_designation" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                                <option value="">Select Designation</option>
                                @foreach(App\Models\FinancialUpgradation::DESIGNATIONS as $key => $value)
                                    <option value="{{ $value }}" {{ old('existing_designation', $financialUpgradation->existing_designation) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('existing_designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="upgraded_designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upgraded Designation *</label>
                            <select name="upgraded_designation" id="upgraded_designation" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                                <option value="">Select Designation</option>
                                @foreach(App\Models\FinancialUpgradation::DESIGNATIONS as $key => $value)
                                    <option value="{{ $value }}" {{ old('upgraded_designation', $financialUpgradation->upgraded_designation) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('upgraded_designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="financial_upgradation_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Financial Upgradation Type *</label>
                            <select name="financial_upgradation_type" id="financial_upgradation_type" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                                <option value="">Select Type</option>
                                <option value="MACP" {{ old('financial_upgradation_type', $financialUpgradation->financial_upgradation_type) == 'MACP' ? 'selected' : '' }}>MACP</option>
                                <option value="PROMOTION" {{ old('financial_upgradation_type', $financialUpgradation->financial_upgradation_type) == 'PROMOTION' ? 'selected' : '' }}>Promotion</option>
                                <option value="ACP" {{ old('financial_upgradation_type', $financialUpgradation->financial_upgradation_type) == 'ACP' ? 'selected' : '' }}>ACP</option>
                            </select>
                            @error('financial_upgradation_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="no_of_financial_upgradation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No of Financial Upgradation *</label>
                            <input type="number" name="no_of_financial_upgradation" id="no_of_financial_upgradation" value="{{ old('no_of_financial_upgradation', $financialUpgradation->no_of_financial_upgradation) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('no_of_financial_upgradation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Date Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Date Information</h3>
                        
                        <div>
                            <label for="promotion_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Promotion Date *</label>
                            <input type="date" name="promotion_date" id="promotion_date" value="{{ old('promotion_date', $financialUpgradation->promotion_date->format('Y-m-d')) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('promotion_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="date_in_grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date in Grade *</label>
                            <input type="date" name="date_in_grade" id="date_in_grade" value="{{ old('date_in_grade', $financialUpgradation->date_in_grade->format('Y-m-d')) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('date_in_grade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Scale Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Scale Details</h3>
                        
                        <div>
                            <label for="existing_scale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Existing Scale *</label>
                            <input type="text" name="existing_scale" id="existing_scale" value="{{ old('existing_scale', $financialUpgradation->existing_scale) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   placeholder="e.g., 5200-20200 GP 2800" required>
                            @error('existing_scale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="upgraded_scale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upgraded Scale *</label>
                            <input type="text" name="upgraded_scale" id="upgraded_scale" value="{{ old('upgraded_scale', $financialUpgradation->upgraded_scale) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   placeholder="e.g., 9300-34800 GP 4200" required>
                            @error('upgraded_scale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Pay Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pay Details</h3>
                        
                        <div>
                            <label for="pay_fixed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pay Fixed *</label>
                            <select name="pay_fixed" id="pay_fixed" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                                <option value="">Select</option>
                                <option value="YES" {{ old('pay_fixed', $financialUpgradation->pay_fixed) == 'YES' ? 'selected' : '' }}>YES</option>
                                <option value="NO" {{ old('pay_fixed', $financialUpgradation->pay_fixed) == 'NO' ? 'selected' : '' }}>NO</option>
                            </select>
                            @error('pay_fixed') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="existing_pay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Existing Pay *</label>
                            <input type="number" step="0.01" name="existing_pay" id="existing_pay" value="{{ old('existing_pay', $financialUpgradation->existing_pay) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('existing_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="existing_grade_pay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Existing Grade Pay *</label>
                            <input type="number" step="0.01" name="existing_grade_pay" id="existing_grade_pay" value="{{ old('existing_grade_pay', $financialUpgradation->existing_grade_pay) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('existing_grade_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Upgraded Pay Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upgraded Pay Details</h3>
                        
                        <div>
                            <label for="upgraded_pay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upgraded Pay *</label>
                            <input type="number" step="0.01" name="upgraded_pay" id="upgraded_pay" value="{{ old('upgraded_pay', $financialUpgradation->upgraded_pay) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('upgraded_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="upgraded_grade_pay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upgraded Grade Pay *</label>
                            <input type="number" step="0.01" name="upgraded_grade_pay" id="upgraded_grade_pay" value="{{ old('upgraded_grade_pay', $financialUpgradation->upgraded_grade_pay) }}"
                                   class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                   required>
                            @error('upgraded_grade_pay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="macp_remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">MACP Remarks</label>
                            <textarea name="macp_remarks" id="macp_remarks" rows="3"
                                      class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">{{ old('macp_remarks', $financialUpgradation->macp_remarks) }}</textarea>
                            @error('macp_remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('financial-upgradation.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                        Cancel
                    </a>
                    <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                        <i class="fa fa-save mr-2"></i>
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection