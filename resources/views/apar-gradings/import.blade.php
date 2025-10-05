@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Import APAR Records</h1>
                    <p class="text-gray-600">Import APAR grading data from Excel file</p>
                </div>
                <a href="{{ route('apar.index') }}" 
                   class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to APAR List
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

<!-- Detailed Error Messages -->
@if (session('error'))
<div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-semibold text-red-800">
                {{ session('error') }}
            </h3>
            
            @if (session('errorDetails'))
            <div class="mt-3">
                <h4 class="text-sm font-medium text-red-700 mb-2">Detailed Errors:</h4>
                <div class="bg-red-40 border border-red-300 rounded p-3">
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach (session('errorDetails') as $detail)
                            <li class="font-mono">{{ $detail }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            @if (session('importErrors'))
            <div class="mt-3">
                <h4 class="text-sm font-medium text-red-700 mb-2">Import Errors:</h4>
                <div class="bg-red-40 border border-red-300 rounded p-3">
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach (session('importErrors') as $error)
                            <li class="font-mono">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
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

            <!-- Instructions -->
            <div class="card border rounded-xl bg-blue-50 border-blue-200">
                <div class="card-content p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">Import Instructions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-blue-700 mb-2">Required Columns:</h4>
                            <ul class="list-disc list-inside text-blue-600 space-y-1 text-sm">
                                <li><strong>empl_id</strong> - Employee ID (must exist in system)</li>
                                <li><strong>from_month</strong> - From Month (e.g., January)</li>
                                <li><strong>from_year</strong> - From Year (e.g., 2023)</li>
                                <li><strong>to_month</strong> - To Month (e.g., December)</li>
                                <li><strong>to_year</strong> - To Year (e.g., 2023)</li>
                                <li><strong>grading_type</strong> - APAR, Performance Review, etc.</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-blue-700 mb-2">Optional Columns:</h4>
                            <ul class="list-disc list-inside text-blue-600 space-y-1 text-sm">
                                <li>discrepancy_remarks</li>
                                <li>reporting_marks (0-10)</li>
                                <li>reviewing_marks (0-10)</li>
                                <li>reporting_grade (A+, A, B+, etc.)</li>
                                <li>reviewing_grade (A+, A, B+, etc.)</li>
                                <li>consideration (TRUE/FALSE)</li>
                                <li>remarks</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('apar.export-template') }}"  
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                        <a href="{{ route('apar.export') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">
                            <i class="fas fa-file-export mr-2"></i>
                            Export Current Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Import Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('apar.process-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-4">
                            <div>
                                <label for="file" class="label text-sm font-semibold">Select Excel File *</label>
                                <input type="file" id="file" name="file" 
                                       class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 border"
                                       accept=".xlsx,.xls,.csv" required>
                                @error('file')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">Supported formats: .xlsx, .xls, .csv (Max: 10MB)</p>
                            </div>

                            <div class="flex gap-3 pt-4">
                                <button type="submit" 
                                        class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700">
                                    <i class="fas fa-upload mr-2"></i>
                                    Import File
                                </button>
                                <a href="{{ route('apar.index') }}" 
                                   class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection