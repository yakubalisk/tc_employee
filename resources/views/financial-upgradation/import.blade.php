@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Import Financial Upgradation Records</h1>
            <p class="text-muted-foreground">Import financial upgradation records from Excel file</p>
        </div>
        <a href="{{ route('financial-upgradation.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
            <i class="fa fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>

    <div class="card border rounded-xl">
        <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Import Records</h2>
        </div>
        <div class="card-content p-4">
            <form action="{{ route('financial-upgradation.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excel File *</label>
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv"
                               class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                               required>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Supported formats: .xlsx, .xls, .csv. Maximum file size: 10MB
                        </p>
                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Template Download -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fa fa-info-circle text-blue-600 dark:text-blue-400 mr-3"></i>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Download Template</h3>
                                <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                    Download our Excel template to ensure your file has the correct format.
                                </p>
                                <a href="{{ route('financial-upgradation.template') }}" class="inline-flex items-center mt-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    <i class="fa fa-download mr-2"></i>
                                    Download Template.xlsx
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Required Fields Info -->
                    <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Required Fields</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <div>• Employee Code</div>
                            <div>• Promotion Date</div>
                            <div>• Existing Designation</div>
                            <div>• Upgraded Designation</div>
                            <div>• Date in Grade</div>
                            <div>• Existing Scale</div>
                            <div>• Upgraded Scale</div>
                            <div>• Pay Fixed</div>
                            <div>• Existing Pay</div>
                            <div>• Existing Grade Pay</div>
                            <div>• Upgraded Pay</div>
                            <div>• Upgraded Grade Pay</div>
                            <div>• No of Financial Upgradation</div>
                            <div>• Financial Upgradation Type</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('financial-upgradation.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                        Cancel
                    </a>
                    <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                        <i class="fa fa-upload mr-2"></i>
                        Import Records
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection