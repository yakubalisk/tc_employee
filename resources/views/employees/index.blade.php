@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Employee Management</h1>
            <p class="text-muted-foreground">Manage and view all employee records</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('employees.export', request()->query()) }}" class="btn btn-outline">
                <i class="fa fa-download mr-2"></i>
                Export
            </a>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <i class="fa fa-eye mr-2"></i>
                Add Employee
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card border rounded-xl">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title">
                <i class="fa fa-filter"></i>
                Filters & Search
            </div>
        </div>
        <div class="card-content">
            <form method="GET" action="{{ route('employees.index') }}">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground fa fa-search"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ $searchTerm }}"
                                placeholder="Search by name, employee code, or designation..."
                                class="pl-10 py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            />
                        </div>
                    </div>
                    
                    <select name="gender" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $filterGender == 'all' ? 'selected' : '' }}>All Genders</option>
                        <option value="MALE" {{ $filterGender == 'MALE' ? 'selected' : '' }}>Male</option>
                        <option value="FEMALE" {{ $filterGender == 'FEMALE' ? 'selected' : '' }}>Female</option>
                        <option value="OTHER" {{ $filterGender == 'OTHER' ? 'selected' : '' }}>Other</option>
                    </select>

                    <select name="category" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $filterCategory == 'all' ? 'selected' : '' }}>All Categories</option>
                        <option value="General" {{ $filterCategory == 'General' ? 'selected' : '' }}>General</option>
                        <option value="OBC" {{ $filterCategory == 'OBC' ? 'selected' : '' }}>OBC</option>
                        <option value="SC" {{ $filterCategory == 'SC' ? 'selected' : '' }}>SC</option>
                        <option value="ST" {{ $filterCategory == 'ST' ? 'selected' : '' }}>ST</option>
                    </select>

                    <select name="status" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $filterStatus == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="EXISTING" {{ $filterStatus == 'EXISTING' ? 'selected' : '' }}>Active</option>
                        <option value="RETIRED" {{ $filterStatus == 'RETIRED' ? 'selected' : '' }}>Retired</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="card border rounded-xl">
        <div class="card-header mb-6">
            <div class="card-title">
                Employee Records ({{ $employees->count() }} of {{ $employees->total() }})
            </div>
        </div>
        <div class="card-content">
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700 shadow-sm">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Employee Code
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Name
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Designation
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Department
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Category
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Age
                </th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Status
                </th>
                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
            @foreach($employees as $employee)
            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors duration-150">
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-sm font-mono text-gray-900 dark:text-neutral-100">{{ $employee->empCode }}</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                {{ substr($employee->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-neutral-100">{{ $employee->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-neutral-400">{{ $employee->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $employee->designationAtPresent }}</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $employee->presentPosting }}</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $employee->category }}
                    </span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $employee->age }} years</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($employee->status === 'EXISTING')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Active
                        </span>
                    @elseif($employee->status === 'RETIRED')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                            Retired
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                            {{ $employee->status }}
                        </span>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('employees.show', $employee->id) }}" 
                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                           title="View Details">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('employees.edit', $employee->id) }}" 
                           class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-150"
                           title="Edit Employee">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <a href="{{ route('employees.export.single', $employee->id) }}" 
                           class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-150"
                           title="Export Record">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $employees->appends(request()->query())->links() }}
                </div>
</div>

@if($employees->isEmpty())
<div class="text-center py-12">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-neutral-100">No employees found</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">Get started by adding a new employee.</p>
</div>
@endif
                
        </div>
    </div>
</div>

@push('styles')
<style>
.search-icon, .filter-icon, .download-icon, .eye-icon, .edit-icon, .more-horizontal-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

/* You would replace these with actual icon implementations */
.search-icon { background-image: url("data:image/svg+xml,..."); }
.filter-icon { background-image: url("data:image/svg+xml,..."); }
.download-icon { background-image: url("data:image/svg+xml,..."); }
.eye-icon { background-image: url("data:image/svg+xml,..."); }
.edit-icon { background-image: url("data:image/svg+xml,..."); }
.more-horizontal-icon { background-image: url("data:image/svg+xml,..."); }
</style>
@endpush
@endsection