@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Reports & Analytics</h1>
            <p class="text-muted-foreground">Generate comprehensive employee reports and analytics</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('reports.export') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="report_type" value="{{ $selectedReport }}">
                <input type="hidden" name="department" value="{{ $filterDepartment }}">
                <input type="hidden" name="date_range" value="{{ $filterDateRange }}">
                <input type="hidden" name="custom_filter" value="{{ $customFilter }}">
                <button type="submit" name="type" value="excel" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                    <i class="fa fa-download mr-2"></i>
                    Export Excel
                </button>
                <button type="submit" name="type" value="pdf" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                    <i class="fa fa-download mr-2"></i>
                    Export PDF
                </button>
            </form>
            <button class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" onclick="generateReport()">
                <i class="fa fa-file-text mr-2"></i>
                Generate Report
            </button>
        </div>
    </div>

    <!-- Report Configuration -->
    <div class="card border rounded-lg">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title mb-6">
                <i class="fa fa-filter"></i>
                Report Configuration
            </div>
        </div>
        <div class="card-content">
            <form method="GET" action="{{ route('reports.index') }}" id="reportForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="report" class="label bold">Report Type</label>
                        <select name="report" id="report" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                            @foreach($reportTypes as $report)
                            <option value="{{ $report['id'] }}" {{ $selectedReport == $report['id'] ? 'selected' : '' }}>
                                {{ $report['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="department" class="label">Department</label>
                        <select name="department" id="department" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                            <option value="all" {{ $filterDepartment == 'all' ? 'selected' : '' }}>All Departments</option>
                            <option value="MUMBAI" {{ $filterDepartment == 'MUMBAI' ? 'selected' : '' }}>Mumbai</option>
                            <option value="DELHI" {{ $filterDepartment == 'DELHI' ? 'selected' : '' }}>Delhi</option>
                            <option value="KOLKATA" {{ $filterDepartment == 'KOLKATA' ? 'selected' : '' }}>Kolkata</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_range" class="label">Date Range</label>
                        <select name="date_range" id="date_range" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" onchange="this.form.submit()">
                            <option value="current-year" {{ $filterDateRange == 'current-year' ? 'selected' : '' }}>Current Year</option>
                            <option value="last-year" {{ $filterDateRange == 'last-year' ? 'selected' : '' }}>Last Year</option>
                            <option value="last-5-years" {{ $filterDateRange == 'last-5-years' ? 'selected' : '' }}>Last 5 Years</option>
                            <option value="all-time" {{ $filterDateRange == 'all-time' ? 'selected' : '' }}>All Time</option>
                        </select>
                    </div>

                    <div>
                        <label for="custom_filter" class="label">Custom Filter</label>
                        <input type="text" name="custom_filter" id="custom_filter" value="{{ $customFilter }}" 
                            class="pl-10 py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search..." onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Content -->
    <div class="space-y-6">
        <div class="card border rounded-lg">
            <div class="card-header">
                <div class="flex items-center gap-2 card-title mb-6">
                    <i class="fa fa-eye"></i>
                    Report Preview - {{ collect($reportTypes)->firstWhere('id', $selectedReport)['name'] }}
                </div>
            </div>
            <div class="card-content">
                @switch($selectedReport)
                    @case('employee-summary')
                        @include('reports.partials.employee-summary')
                    @break

                    @case('promotion-report')
                        @include('reports.partials.promotion-report')
                    @break

                    @case('retirement-due')
                        @include('reports.partials.retirement-due')
                    @break

                    @case('department-wise')
                        @include('reports.partials.department-wise')
                    @break

                    @case('age-analysis')
                        @include('reports.partials.age-analysis')
                    @break

                    @default
                        <div class="p-8 text-center">
                            <i class="file-text-icon h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                            <h3 class="text-lg font-medium">Report Preview</h3>
                            <p class="text-muted-foreground">
                                Select a report type and configure filters to generate detailed reports.
                            </p>
                        </div>
                @endswitch
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function generateReport() {
        document.getElementById('reportForm').submit();
    }
</script>
@endpush

@push('styles')
<style>
.file-text-icon, .download-icon, .users-icon, .trending-up-icon, 
.calendar-icon, .building-icon, .award-icon, .filter-icon, .eye-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

.file-text-icon { background-image: url("data:image/svg+xml,..."); }
.download-icon { background-image: url("data:image/svg+xml,..."); }
.users-icon { background-image: url("data:image/svg+xml,..."); }
.trending-up-icon { background-image: url("data:image/svg+xml,..."); }
.calendar-icon { background-image: url("data:image/svg+xml,..."); }
.building-icon { background-image: url("data:image/svg+xml,..."); }
.award-icon { background-image: url("data:image/svg+xml,..."); }
.filter-icon { background-image: url("data:image/svg+xml,..."); }
.eye-icon { background-image: url("data:image/svg+xml,..."); }
</style>
@endpush
@endsection