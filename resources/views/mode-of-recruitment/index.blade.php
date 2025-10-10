@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mode of Recruitment Management</h1>
                    <p class="text-gray-600">Manage all recruitment and promotion records</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mode-of-recruitment.create') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Record
                    </a>
                    <a href="{{ route('mode-of-recruitment.import') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('mode-of-recruitment.export', request()->query()) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card border rounded-xl">
                <div class="card-content p-4">
                    <form method="GET" action="{{ route('mode-of-recruitment.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 fas fa-search"></i>
                                    <input type="text" name="search" value="{{ $search }}" 
                                           placeholder="Search by employee ID, designation, or office order..."
                                           class="pl-10 py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <select name="method" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $method == 'all' ? 'selected' : '' }}>All Methods</option>
                                @foreach(App\Models\ModeOfRecruitment::RECRUITMENT_METHODS as $key => $value)
                                    <option value="{{ $key }}" {{ $method == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <select name="pay_fixation" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $payFixation == 'all' ? 'selected' : '' }}>All Pay Fixation</option>
                                @foreach(App\Models\ModeOfRecruitment::PAY_FIXATION_OPTIONS as $key => $value)
                                    <option value="{{ $key }}" {{ $payFixation == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Records Table -->
            <div class="card border rounded-xl">
                <div class="card-content">
                    @if($records->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designation</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seniority No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Entry</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Office Order</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Fixation</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($records as $record)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->PromotionID }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->employee->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $record->employee->empId }} | Code: {{ $record->employee->empCode }}</div>
                                </div>
                            </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $record->Designation }}</div>
                                                <div class="text-sm text-gray-500">{{ $record->Designation_ }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->Seniority_Number }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedDateOfEntry }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($record->Office_Order_No, 30) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $record->Method_of_Recruitment }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->Pay_Fixation == 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $record->Pay_Fixation }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex gap-2">
                                                <a href="{{ route('mode-of-recruitment.show', $record->PromotionID) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('mode-of-recruitment.edit', $record->PromotionID) }}" 
                                                   class="text-green-600 hover:text-green-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('mode-of-recruitment.destroy', $record->PromotionID) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="px-4 py-3 border-t border-gray-200">
                            {{ $records->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recruitment records found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new record.</p>
                            <div class="mt-6">
                                <a href="{{ route('mode-of-recruitment.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Record
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection