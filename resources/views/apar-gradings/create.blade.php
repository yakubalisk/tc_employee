@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('apar.store') }}" method="POST">
            @csrf
            
            <!-- Add hidden employee_id field if coming from employee page -->
            @if(request()->has('employee_id'))
                <input type="hidden" name="employee_id" value="{{ request('employee_id') }}">
            @endif
            
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Add APAR Grading Record</h1>
                        <p class="text-gray-600">
                            @if(request()->has('employee_id') && $selectedEmployee)
                                Add new APAR record for {{ $selectedEmployee->name }}
                            @else
                                Add new APAR record
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>
                            Save APAR Record
                        </button>
                        <a href="{{ route('apar.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    There were {{ $errors->count() }} errors with your submission
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- APAR Form -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">APAR Details</div>
                    </div>
                    <div class="card-content space-y-4">
                        <!-- Employee Selection -->
                        <div>
                            <label for="employee_id" class="label text-sm font-semibold">Employee *</label>
                            <select id="employee_id" name="employee_id" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" 
                                        {{ (old('employee_id') == $emp->id || (request()->has('employee_id') && request('employee_id') == $emp->id)) ? 'selected' : '' }}>
                                        {{ $emp->name }} (ID: {{ $emp->empId }} | Code: {{ $emp->empCode }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="from_month" class="label text-sm font-semibold">From Month *</label>
                                <select id="from_month" name="from_month" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                    <option value="">Select Month</option>
                                    @php
                                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    @endphp
                                    @foreach($months as $month)
                                        <option value="{{ $month }}" {{ old('from_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="from_year" class="label text-sm font-semibold">From Year *</label>
                                <input type="number" id="from_year" name="from_year" 
                                       value="{{ old('from_year') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                       placeholder="2023" min="2000" max="2030" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="to_month" class="label text-sm font-semibold">To Month *</label>
                                <select id="to_month" name="to_month" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                    <option value="">Select Month</option>
                                    @foreach($months as $month)
                                        <option value="{{ $month }}" {{ old('to_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="to_year" class="label text-sm font-semibold">To Year *</label>
                                <input type="number" id="to_year" name="to_year" 
                                       value="{{ old('to_year') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                       placeholder="2024" min="2000" max="2030" required>
                            </div>
                        </div>

                        <div>
                            <label for="grading_type" class="label text-sm font-semibold">Grading Type *</label>
                            <select id="grading_type" name="grading_type" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border" required>
                                <option value="">Select Type</option>
                                <option value="APAR" {{ old('grading_type') == 'APAR' ? 'selected' : '' }}>APAR</option>
                                <option value="Performance Review" {{ old('grading_type') == 'Performance Review' ? 'selected' : '' }}>Performance Review</option>
                                <option value="Annual Assessment" {{ old('grading_type') == 'Annual Assessment' ? 'selected' : '' }}>Annual Assessment</option>
                            </select>
                        </div>

                        <div>
                            <label for="discrepancy_remarks" class="label text-sm font-semibold">APAR Discrepancy Remarks</label>
                            <textarea id="discrepancy_remarks" name="discrepancy_remarks" 
                                      class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                      rows="3" placeholder="Enter discrepancy remarks">{{ old('discrepancy_remarks') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="reporting_marks" class="label text-sm font-semibold">Reporting Officer Marks</label>
                                <input type="number" step="0.1" min="0" max="10" id="reporting_marks" name="reporting_marks" 
                                       value="{{ old('reporting_marks') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                       placeholder="8.5">
                            </div>
                            <div>
                                <label for="reviewing_marks" class="label text-sm font-semibold">Reviewing Officer Marks</label>
                                <input type="number" step="0.1" min="0" max="10" id="reviewing_marks" name="reviewing_marks" 
                                       value="{{ old('reviewing_marks') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                       placeholder="8.5">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="reporting_grade" class="label text-sm font-semibold">Reporting ACR Grade</label>
                                <select id="reporting_grade" name="reporting_grade" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border">
                                    <option value="">Select Grade</option>
                                    @php
                                        $grades = ['A+', 'A', 'B+', 'B', 'C', 'D'];
                                    @endphp
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade }}" {{ old('reporting_grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="reviewing_grade" class="label text-sm font-semibold">Reviewing ACR Grade</label>
                                <select id="reviewing_grade" name="reviewing_grade" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border">
                                    <option value="">Select Grade</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade }}" {{ old('reviewing_grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="consideration" class="label text-sm font-semibold">APAR Consideration</label>
                                <select id="consideration" name="consideration" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border">
                                    <option value="0" {{ old('consideration', 0) == 0 ? 'selected' : '' }}>FALSE</option>
                                    <option value="1" {{ old('consideration') == 1 ? 'selected' : '' }}>TRUE</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="remarks" class="label text-sm font-semibold">APAR Remarks</label>
                            <textarea id="remarks" name="remarks" 
                                      class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 border" 
                                      rows="3" placeholder="Enter additional remarks">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const fromMonth = document.getElementById('from_month');
    const fromYear = document.getElementById('from_year');
    const toMonth = document.getElementById('to_month');
    const toYear = document.getElementById('to_year');

    function validateDates() {
        if (fromMonth.value && fromYear.value && toMonth.value && toYear.value) {
            const fromDate = new Date(`${fromMonth.value} 1, ${fromYear.value}`);
            const toDate = new Date(`${toMonth.value} 1, ${toYear.value}`);
            
            if (toDate < fromDate) {
                alert('To date cannot be before From date');
                toMonth.value = '';
                toYear.value = '';
            }
        }
    }

    toMonth.addEventListener('change', validateDates);
    toYear.addEventListener('change', validateDates);
});
</script>
@endsection