@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Financial Upgradation</h1>
            <p class="text-muted-foreground">Manage and view all financial upgradation records</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('financial-upgradation.export', request()->query()) }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                <i class="fa fa-download mr-2"></i>
                Export
            </a>
            <a href="{{ route('financial-upgradation.import.form') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                <i class="fa fa-upload mr-2"></i>
                Import
            </a>
            <a href="{{ route('financial-upgradation.create') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                <i class="fa fa-plus mr-2"></i>
                Add Record
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card border rounded-xl">
        <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
            <div class="flex items-center gap-2">
                <i class="fa fa-filter text-gray-600 dark:text-gray-400"></i>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filters & Search</h2>
            </div>
        </div>
        <div class="card-content p-4">
            <form method="GET" action="{{ route('financial-upgradation.index') }}">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 fa fa-search"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search by employee ID, designation, or remarks..."
                                class="pl-10 py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            />
                        </div>
                    </div>
                    
                    <select name="region" class="py-2 px-3 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $region == 'all' ? 'selected' : '' }}>All Regions</option>
                        @foreach(App\Models\FinancialUpgradation::REGIONS as $key => $value)
                            <option value="{{ $key }}" {{ $region == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>

                    <select name="department" class="py-2 px-3 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $department == 'all' ? 'selected' : '' }}>All Departments</option>
                        @foreach(App\Models\FinancialUpgradation::DEPARTMENTS as $key => $value)
                            <option value="{{ $key }}" {{ $department == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>

                    <select name="type" class="py-2 px-3 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="MACP" {{ $type == 'MACP' ? 'selected' : '' }}>MACP</option>
                        <option value="PROMOTION" {{ $type == 'PROMOTION' ? 'selected' : '' }}>Promotion</option>
                        <option value="ACP" {{ $type == 'ACP' ? 'selected' : '' }}>ACP</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Financial Upgradation Table -->
    <div class="card border rounded-xl">
        <div class="card-header p-4 border-b border-gray-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Financial Upgradation Records ({{ $records->count() }} of {{ $records->total() }})
                </h2>
            </div>
        </div>
        <div class="card-content p-4">
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-neutral-700 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Sr No
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Employee ID
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Promotion Date
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Existing Designation
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Upgraded Designation
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Existing Scale
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Upgraded Scale
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Pay Fixed
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Financial Upgradation
                            </th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-neutral-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                        @foreach($records as $record)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-neutral-100">{{ $record->sr_no }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-900 dark:text-neutral-100">{{ $record->empl_id }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $record->promotion_date->format('d-M-y') }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $record->existing_designation }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $record->upgraded_designation }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $record->existing_scale }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 dark:text-neutral-100">{{ $record->upgraded_scale }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->pay_fixed == 'YES' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $record->pay_fixed }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $record->financial_upgradation_type }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('financial-upgradation.show', $record->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                                       title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('financial-upgradation.edit', $record->id) }}" 
                                       class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-150"
                                       title="Edit Record">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('financial-upgradation.destroy', $record->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150"
                                                title="Delete Record"
                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fa fa-trash"></i>
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
            <div class="mt-4">
                {{ $records->appends(request()->query())->links() }}
            </div>

            @if($records->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-neutral-100">No financial upgradation records found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">Get started by adding a new record.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection