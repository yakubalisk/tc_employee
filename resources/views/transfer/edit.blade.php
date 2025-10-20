@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Transfer Record</h1>
                    <p class="text-gray-600">Update employee transfer record details</p>
                </div>
                <a href="{{ route('transfer.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('transfer.update', $transfer->transferId) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Employee Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Employee Information</h3>
                                
                                <!-- <div>
                                    <label for="empID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                                    <input type="text" name="empID" id="empID" value="{{ old('empID', $transfer->empID) }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('empID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div> -->

                                 <div>
                                    <label for="employee_id" class="label text-sm font-semibold">Employee *</label>
                                    <select id="employee_id" name="employee_id" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" data-emp_code="{{ $emp->empCode }}" {{ old('employee_id', $transfer->employee_id) == $emp->id ? 'selected' : '' }}>
                                                {{ $emp->name }} (ID: {{ $emp->empId }} | Code: {{ $emp->empCode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="designation_id" class="block text-sm font-medium text-gray-700 mb-1">Designation *</label>
                                    <select name="designation_id" id="designation_id" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $id => $name)
                                            <option value="{{ $id }}" {{ old('designation_id', $transfer->designation_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('designation_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Transfer Dates -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Transfer Dates</h3>
                                
                                <div>
                                    <label for="date_of_joining" class="block text-sm font-medium text-gray-700 mb-1">Date of Joining *</label>
                                    <input type="date" name="date_of_joining" id="date_of_joining" value="{{ old('date_of_joining', $transfer->date_of_joining->format('Y-m-d')) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('date_of_joining') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="date_of_releiving" class="block text-sm font-medium text-gray-700 mb-1">Date of Releiving *</label>
                                    <input type="date" name="date_of_releiving" id="date_of_releiving" value="{{ old('date_of_releiving', $transfer->date_of_releiving->format('Y-m-d')) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                    @error('date_of_releiving') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="date_of_exit" class="block text-sm font-medium text-gray-700 mb-1">Date of Exit</label>
                                    <input type="date" name="date_of_exit" id="date_of_exit" value="{{ old('date_of_exit', $transfer->date_of_exit ? $transfer->date_of_exit->format('Y-m-d') : '') }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                    @error('date_of_exit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Transfer Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Transfer Details</h3>
                                
                                <div>
                                    <label for="transfer_order_no" class="block text-sm font-medium text-gray-700 mb-1">Transfer Order No *</label>
                                    <input type="text" name="transfer_order_no" id="transfer_order_no" value="{{ old('transfer_order_no', $transfer->transfer_order_no) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 28/4/2001/AD DATED 11.01.2002" required>
                                    @error('transfer_order_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                    <input type="text" name="duration" id="duration" value="{{ old('duration', $transfer->duration) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 2 years 3 months">
                                    @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Region Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Region Information</h3>
                                
                                <div>
                                    <label for="region_id" class="block text-sm font-medium text-gray-700 mb-1">Current Region *</label>
                                    <select name="region_id" id="region_id" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Region</option>
                                        @foreach($regions as $id => $name)
                                            <option value="{{ $id }}" {{ old('region_id', $transfer->region_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('region_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="transferred_region_id" class="block text-sm font-medium text-gray-700 mb-1">Transferred Region *</label>
                                    <select name="transferred_region_id" id="transferred_region_id" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Region</option>
                                        @foreach($regions as $id => $name)
                                            <option value="{{ $id }}" {{ old('transferred_region_id', $transfer->transferred_region_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('transferred_region_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Department Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Department Information</h3>
                                
                                <div>
                                    <label for="department_worked_id" class="block text-sm font-medium text-gray-700 mb-1">Department Worked *</label>
                                    <select name="department_worked_id" id="department_worked_id" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $id => $name)
                                            <option value="{{ $id }}" {{ old('department_worked_id', $transfer->department_worked_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_worked_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Remarks -->
                        <div class="mt-6">
                            <label for="transfer_remarks" class="block text-sm font-medium text-gray-700 mb-1">Transfer Remarks</label>
                            <textarea name="transfer_remarks" id="transfer_remarks" rows="3"
                                      class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Any additional remarks about the transfer">{{ old('transfer_remarks', $transfer->transfer_remarks) }}</textarea>
                            @error('transfer_remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('transfer.index') }}" 
                               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>
                                Update Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate duration when dates are changed
    document.addEventListener('DOMContentLoaded', function() {
        const joiningDate = document.getElementById('date_of_joining');
        const releivingDate = document.getElementById('date_of_releiving');
        const durationField = document.getElementById('duration');

        function calculateDuration() {
            if (joiningDate.value && releivingDate.value) {
                const start = new Date(joiningDate.value);
                const end = new Date(releivingDate.value);
                
                if (start < end) {
                    const years = end.getFullYear() - start.getFullYear();
                    const months = end.getMonth() - start.getMonth();
                    
                    let totalMonths = years * 12 + months;
                    if (end.getDate() < start.getDate()) {
                        totalMonths--;
                    }
                    
                    const calcYears = Math.floor(totalMonths / 12);
                    const calcMonths = totalMonths % 12;
                    
                    let duration = '';
                    if (calcYears > 0) {
                        duration += calcYears + ' year' + (calcYears > 1 ? 's' : '');
                    }
                    if (calcMonths > 0) {
                        if (duration) duration += ' ';
                        duration += calcMonths + ' month' + (calcMonths > 1 ? 's' : '');
                    }
                    
                    durationField.value = duration || '0 months';
                }
            }
        }

        joiningDate.addEventListener('change', calculateDuration);
        releivingDate.addEventListener('change', calculateDuration);
    });
</script>
@endsection