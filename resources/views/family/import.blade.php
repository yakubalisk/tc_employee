@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Import Family Member Records</h1>
                    <p class="text-gray-600">Import family member records from Excel file</p>
                </div>
                <a href="{{ route('family.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Import Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('family.import.post') }}" method="POST" enctype="multipart/form-data">
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
                                        <a href="{{ route('family.template') }}" 
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
                                    <div>• Employee Code</div>
                                    <div>• name_of_family_member</div>
                                    <div>• relationship</div>
                                    <div>• date_of_birth</div>
                                    <div>• dependent_remarks (Optional)</div>
                                    <div>• reason_for_dependence (Optional)</div>
                                    <div>• ltc (Optional)</div>
                                    <div>• medical (Optional)</div>
                                    <div>• gsli (Optional)</div>
                                    <div>• gpf (Optional)</div>
                                    <div>• dcrg (Optional)</div>
                                    <div>• pension_nps (Optional)</div>
                                </div>
                            </div>

                            <!-- Data Format Instructions -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-yellow-800 mb-2">Data Format Instructions</h3>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• <strong>date_of_birth:</strong> Use DD-MMM-YY format (e.g., 25-Jan-06)</li>
                                    <li>• <strong>relationship:</strong> Wife, Husband, Son, Daughter, Father, Mother, etc.</li>
                                    <li>• <strong>Boolean fields (LTC, Medical, etc.):</strong> Yes/No, True/False, or 1/0</li>
                                    <li>• <strong>Age:</strong> Will be calculated automatically from date of birth</li>
                                    <li>• <strong>dependent_remarks:</strong> DEPENDENT, Dependent, etc.</li>
                                    <li>• <strong>reason_for_dependence:</strong> HOUSE WIFE, NO INCOME, MINOR, STUDENT, etc.</li>
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
                                                <th class="px-3 py-2 text-left font-medium text-green-800">name_of_family_member</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">relationship</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">date_of_birth</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">dependent_remarks</th>
                                                <th class="px-3 py-2 text-left font-medium text-green-800">reason_for_dependence</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="px-3 py-2 border-b border-green-200">4</td>
                                                <td class="px-3 py-2 border-b border-green-200">NACHIKET</td>
                                                <td class="px-3 py-2 border-b border-green-200">Son</td>
                                                <td class="px-3 py-2 border-b border-green-200">25-Jan-06</td>
                                                <td class="px-3 py-2 border-b border-green-200">DEPENDENT</td>
                                                <td class="px-3 py-2 border-b border-green-200"></td>
                                            </tr>
                                            <tr>
                                                <td class="px-3 py-2 border-b border-green-200">4</td>
                                                <td class="px-3 py-2 border-b border-green-200">VARSHA</td>
                                                <td class="px-3 py-2 border-b border-green-200">Wife</td>
                                                <td class="px-3 py-2 border-b border-green-200">22-Oct-81</td>
                                                <td class="px-3 py-2 border-b border-green-200">DEPENDENT</td>
                                                <td class="px-3 py-2 border-b border-green-200"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('family.index') }}" 
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