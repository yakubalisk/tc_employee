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
                <button type="submit" name="type" value="excel" class="btn btn-outline">
                    <i class="download-icon mr-2"></i>
                    Export Excel
                </button>
                <button type="submit" name="type" value="pdf" class="btn btn-outline">
                    <i class="download-icon mr-2"></i>
                    Export PDF
                </button>
            </form>
            <button class="btn btn-primary" onclick="generateReport()">
                <i class="file-text-icon mr-2"></i>
                Generate Report
            </button>
        </div>
    </div>

    <!-- Report Configuration -->
    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title">
                <i class="filter-icon"></i>
                Report Configuration
            </div>
        </div>
        <div class="card-content">
            <form method="GET" action="{{ route('reports.index') }}" id="reportForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="report" class="label">Report Type</label>
                        <select name="report" id="report" class="select" onchange="this.form.submit()">
                            @foreach($reportTypes as $report)
                            <option value="{{ $report['id'] }}" {{ $selectedReport == $report['id'] ? 'selected' : '' }}>
                                {{ $report['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="department" class="label">Department</label>
                        <select name="department" id="department" class="select" onchange="this.form.submit()">
                            <option value="all" {{ $filterDepartment == 'all' ? 'selected' : '' }}>All Departments</option>
                            <option value="MUMBAI" {{ $filterDepartment == 'MUMBAI' ? 'selected' : '' }}>Mumbai</option>
                            <option value="DELHI" {{ $filterDepartment == 'DELHI' ? 'selected' : '' }}>Delhi</option>
                            <option value="KOLKATA" {{ $filterDepartment == 'KOLKATA' ? 'selected' : '' }}>Kolkata</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_range" class="label">Date Range</label>
                        <select name="date_range" id="date_range" class="select" onchange="this.form.submit()">
                            <option value="current-year" {{ $filterDateRange == 'current-year' ? 'selected' : '' }}>Current Year</option>
                            <option value="last-year" {{ $filterDateRange == 'last-year' ? 'selected' : '' }}>Last Year</option>
                            <option value="last-5-years" {{ $filterDateRange == 'last-5-years' ? 'selected' : '' }}>Last 5 Years</option>
                            <option value="all-time" {{ $filterDateRange == 'all-time' ? 'selected' : '' }}>All Time</option>
                        </select>
                    </div>

                    <div>
                        <label for="custom_filter" class="label">Custom Filter</label>
                        <input type="text" name="custom_filter" id="custom_filter" value="{{ $customFilter }}" 
                            class="input" placeholder="Search..." onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Content -->
    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center gap-2 card-title">
                    <i class="eye-icon"></i>
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
                            <h3 class="text-lg font-medium mb-2">Report Preview</h3>
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