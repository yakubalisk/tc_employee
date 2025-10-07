@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Import Transfer Records</h1>
                    <p class="text-gray-600">Import transfer records from Excel file</p>
                </div>
                <a href="{{ route('transfer.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Import Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('transfer.import.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- File Upload -->
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Excel File *</label>
                                <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv"
                                       class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                <p class="mt-1 text-sm text-gray-500">
                                    Supported formats: .xlsx, .xls, .csv. Maximum file size: 10MB
                                </p>
                                @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Template Download -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-800">Download Template</h3>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Download our Excel template to ensure your file has the correct format.
                                        </p>
                                        <a href="{{ route('transfer.template') }}" 
                                           class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-download mr-2"></i>
                                            Download Template.xlsx
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Required Fields Info -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Required Fields</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-600">
                                    <div>• empID</div>
                                    <div>• designation</div>
                                    <div>• date_of_joining</div>
                                    <div>• date_of_releiving</div>
                                    <div>• transfer_order_no</div>
                                    <div>• region</div>
                                    <div>• transferred_region</div>
                                    <div>• department_worked</div>
                                    <div>• transfer_remarks (Optional)</div>
                                    <div>• date_of_exit (Optional)</div>
                                    <div>• duration (Optional)</div>
                                </div>
                            </div>

                            <!-- Data Format Instructions -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-yellow-800 mb-2">Data Format Instructions</h3>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• <strong>Dates:</strong> Use DD-MMM-YY format (e.g., 01-Nov-01)</li>
                                    <li>• <strong>designation:</strong> JQAO (LAB), QAO (EP&QA), etc.</li>
                                    <li>• <strong>region & transferred_region:</strong> MUMBAI, BANGALORE, AHMEDABAD, etc.</li>
                                    <li>• <strong>department_worked:</strong> LAB, EP&QA, etc.</li>
                                    <li>• <strong>duration:</strong> Will be calculated automatically if left blank</li>
                                    <li>• New designations, regions, and departments will be created automatically</li>
                                </ul>
                            </div>

                            <!-- Sample Data Preview -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-green-800 mb-2">Sample Data Format</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm">
                                        <thead>
                                            <tr class="bg-green-100">
                                                <th class="px-3 py-2 text-left font-medium text-green-800">empID</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">designation</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">date_of_joining</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">date_of_releiving</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">transfer_order_no</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">region</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">transferred_region</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">department_worked</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="px-3 py-2 border-b border-green-200">4</td>
                                                <td class="px-3 py-2 border-b border-green-200">JQAO (LAB)</td>
                                                <td class="px-3 py-2 border-b border-green-200">01-Nov-01</td>
                                                <td class="px-3 py-2 border-b border-green-200">28-Jan-02</td>
                                                <td class="px-3 py-2 border-b border-green-200">28/4/2001/AD DATED 11.01.2002</td>
                                                <td class="px-3 py-2 border-b border-green-200">MUMBAI</td>
                                                <td class="px-3 py-2 border-b border-green-200">BANGALORE</td>
                                                <td class="px-3 py-2 border-b border-green-200">LAB</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('transfer.index') }}" 
                               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-upload mr-2"></i>
                                Import Records
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection