@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Doctor Management</h1>
                    <p class="text-gray-600">Manage all employee doctor records</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('doctor.create') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Doctor
                    </a>
                    <a href="{{ route('doctor.import') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('doctor.export', request()->query()) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card border rounded-xl">
                <div class="card-content p-4">
                    <form method="GET" action="{{ route('doctor.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 fas fa-search"></i>
                                    <input type="text" name="search" value="{{ $search }}" 
                                           placeholder="Search by employee ID, doctor name, qualification..."
                                           class="pl-10 py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <select name="qualification" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $qualification == 'all' ? 'selected' : '' }}>All Qualifications</option>
                                @foreach(App\Models\Doctor::QUALIFICATIONS as $key => $value)
                                    <option value="{{ $key }}" {{ $qualification == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <select name="empID" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $empID == 'all' ? 'selected' : '' }}>All Employees</option>
                                @foreach($employeeIds as $id)
                                    <option value="{{ $id }}" {{ $empID == $id ? 'selected' : '' }}>{{ $id }}</option>
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
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qualification</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($records as $record)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-900"><div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->employee->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $record->employee->empId }} | Code: {{ $record->employee->empCode }}</div>
                                </div></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $record->formattedDoctorName }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $record->registration_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($record->qualification)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $record->qualification }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $record->shortAddress }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex gap-2">
                                                <a href="{{ route('doctor.show', $record->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('doctor.edit', $record->id) }}" 
                                                   class="text-green-600 hover:text-green-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('doctor.destroy', $record->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this doctor record?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No doctor records found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new doctor record.</p>
                            <div class="mt-6">
                                <a href="{{ route('doctor.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Doctor
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