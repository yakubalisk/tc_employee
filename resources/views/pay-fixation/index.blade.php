@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pay Fixation Management</h1>
                    <p class="text-gray-600">Manage all pay fixation records</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('pay-fixation.create') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Record
                    </a>
                    <a href="{{ route('pay-fixation.import') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('pay-fixation.export', request()->query()) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card border rounded-xl">
                <div class="card-content p-4">
                    <form method="GET" action="{{ route('pay-fixation.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 fas fa-search"></i>
                                    <input type="text" name="search" value="{{ $search }}" 
                                           placeholder="Search by employee ID, level, or remarks..."
                                           class="pl-10 py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <select name="level" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $level == 'all' ? 'selected' : '' }}>All Levels</option>
                                @foreach(App\Models\PayFixation::REVISED_LEVELS as $key => $value)
                                    <option value="{{ $key }}" {{ $level == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <select name="level2" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $level2 == 'all' ? 'selected' : '' }}>All Level 2</option>
                                @foreach(App\Models\PayFixation::LEVEL_2_OPTIONS as $key => $value)
                                    <option value="{{ $key }}" {{ $level2 == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fixation Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Basic Pay</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Pay</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cell No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revised Level</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level 2</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($records as $record)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-900">                                                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->employee->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $record->employee->empId }} | Code: {{ $record->employee->empCode }}</div>
                                </div>
                            </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedPayFixationDate }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedBasicPay }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedGradePay }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->cell_no }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $record->revised_level }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $record->level_2 }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex gap-2">
                                                <a href="{{ route('pay-fixation.show', $record->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pay-fixation.edit', $record->id) }}" 
                                                   class="text-green-600 hover:text-green-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('pay-fixation.destroy', $record->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this pay fixation record?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pay fixation records found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new record.</p>
                            <div class="mt-6">
                                <a href="{{ route('pay-fixation.create') }}" 
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