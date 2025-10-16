@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Family Management</h1>
                    <p class="text-gray-600">Manage all employee family member records</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('family.create') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Add Family Member
                    </a>
                    <a href="{{ route('family.import') }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                    <a href="{{ route('family.export', request()->query()) }}" 
                       class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Excel
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="card border rounded-xl">
                <div class="card-content p-4">
                    <form method="GET" action="{{ route('family.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 fas fa-search"></i>
                                    <input type="text" name="search" value="{{ $search }}" 
                                           placeholder="Search by employee ID, family member name, or relationship..."
                                           class="pl-10 py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <select name="relationship" class="py-2 px-3 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                <option value="all" {{ $relationship == 'all' ? 'selected' : '' }}>All Relationships</option>
                                @foreach(App\Models\Family::RELATIONSHIPS as $key => $value)
                                    <option value="{{ $key }}" {{ $relationship == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Family Member</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relationship</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dependent</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Benefits</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($records as $record)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-900">
                                            <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->employee->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $record->employee->empId }} | Code: {{ $record->employee->empCode }}</div>
                                </div>
                            </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->name_of_family_member }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $record->relationship }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedDateOfBirth }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->age ?? $record->calculated_age }} years</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->dependent_remarks ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $record->dependent_remarks ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            {{ Str::limit($record->benefits_summary, 30) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex gap-2">
                                                <a href="{{ route('family.show', $record->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('family.edit', $record->id) }}" 
                                                   class="text-green-600 hover:text-green-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('family.destroy', $record->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this family member record?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No family member records found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new family member record.</p>
                            <div class="mt-6">
                                <a href="{{ route('family.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Family Member
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