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
                <i class="download-icon mr-2"></i>
                Export
            </a>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <i class="eye-icon mr-2"></i>
                Add Employee
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title">
                <i class="filter-icon"></i>
                Filters & Search
            </div>
        </div>
        <div class="card-content">
            <form method="GET" action="{{ route('employees.index') }}">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <i class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground search-icon"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ $searchTerm }}"
                                placeholder="Search by name, employee code, or designation..."
                                class="pl-10 input"
                            />
                        </div>
                    </div>
                    
                    <select name="gender" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $filterGender == 'all' ? 'selected' : '' }}>All Genders</option>
                        <option value="MALE" {{ $filterGender == 'MALE' ? 'selected' : '' }}>Male</option>
                        <option value="FEMALE" {{ $filterGender == 'FEMALE' ? 'selected' : '' }}>Female</option>
                        <option value="OTHER" {{ $filterGender == 'OTHER' ? 'selected' : '' }}>Other</option>
                    </select>

                    <select name="category" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $filterCategory == 'all' ? 'selected' : '' }}>All Categories</option>
                        <option value="General" {{ $filterCategory == 'General' ? 'selected' : '' }}>General</option>
                        <option value="OBC" {{ $filterCategory == 'OBC' ? 'selected' : '' }}>OBC</option>
                        <option value="SC" {{ $filterCategory == 'SC' ? 'selected' : '' }}>SC</option>
                        <option value="ST" {{ $filterCategory == 'ST' ? 'selected' : '' }}>ST</option>
                    </select>

                    <select name="status" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $filterStatus == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="EXISTING" {{ $filterStatus == 'EXISTING' ? 'selected' : '' }}>Active</option>
                        <option value="RETIRED" {{ $filterStatus == 'RETIRED' ? 'selected' : '' }}>Retired</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Employee Records ({{ $employees->count() }} of {{ $employees->total() }})
            </div>
        </div>
        <div class="card-content">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td class="font-medium">{{ $employee->empCode }}</td>
                            <td>
                                <div>
                                    <p class="font-medium">{{ $employee->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $employee->email }}</p>
                                </div>
                            </td>
                            <td>{{ $employee->designationAtPresent }}</td>
                            <td>{{ $employee->presentPosting }}</td>
                            <td>
                                <span class="badge badge-outline">{{ $employee->category }}</span>
                            </td>
                            <td>{{ $employee->age }} years</td>
                            <td>
                                @if($employee->status === 'EXISTING')
                                    <span class="badge badge-success">Active</span>
                                @elseif($employee->status === 'RETIRED')
                                    <span class="badge badge-secondary">Retired</span>
                                @else
                                    <span class="badge badge-outline">{{ $employee->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-ghost btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="more-horizontal-icon"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('employees.show', $employee->id) }}" class="dropdown-item">
                                            <i class="eye-icon mr-2"></i>
                                            View Details
                                        </a>
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="dropdown-item">
                                            <i class="edit-icon mr-2"></i>
                                            Edit Employee
                                        </a>
                                        <a href="{{ route('employees.export.single', $employee->id) }}" class="dropdown-item">
                                            <i class="download-icon mr-2"></i>
                                            Export Record
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $employees->appends(request()->query())->links() }}
                </div>
            </div>
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