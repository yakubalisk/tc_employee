@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Promotion Report</h1>
            <p class="text-muted-foreground">Comprehensive promotion analysis and reporting</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="btn btn-outline">
                <i class="printer-icon mr-2"></i>
                Print Report
            </button>
            <a href="{{ route('export.promotions', request()->query()) }}" class="btn btn-primary">
                <i class="download-icon mr-2"></i>
                Export Report
            </a>
        </div>
    </div>

    <!-- Report Filters -->
    <div class="card">
        <div class="card-content">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="label">Year</label>
                    <select name="year" class="select" onchange="this.form.submit()">
                        @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label class="label">Type</label>
                    <select name="type" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="Regular Promotion" {{ $type == 'Regular Promotion' ? 'selected' : '' }}>Regular</option>
                        <option value="MACP" {{ $type == 'MACP' ? 'selected' : '' }}>MACP</option>
                        <option value="ACP" {{ $type == 'ACP' ? 'selected' : '' }}>ACP</option>
                        <option value="Financial Upgradation" {{ $type == 'Financial Upgradation' ? 'selected' : '' }}>Financial</option>
                    </select>
                </div>
                
                <div>
                    <label class="label">Department</label>
                    <select name="department" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $department == 'all' ? 'selected' : '' }}>All Departments</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ $department == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="label">&nbsp;</label>
                    <button type="submit" class="btn btn-outline w-full">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card">
            <div class="card-content text-center">
                <div class="text-3xl font-bold text-primary">{{ $summary['total'] }}</div>
                <div class="text-sm text-muted-foreground">Total Promotions</div>
            </div>
        </div>
        
        @foreach($summary['by_type'] as $type => $count)
        <div class="card">
            <div class="card-content text-center">
                <div class="text-2xl font-bold text-foreground">{{ $count }}</div>
                <div class="text-sm text-muted-foreground">{{ $type }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Detailed Report -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Promotion Details - {{ $year }}</div>
        </div>
        <div class="card-content">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Previous Designation</th>
                            <th>New Designation</th>
                            <th>Effective Date</th>
                            <th>Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promotion)
                        <tr>
                            <td>
                                <div>
                                    <p class="font-medium">{{ $promotion->employee->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $promotion->employee->empCode }}</p>
                                </div>
                            </td>
                            <td>{{ $promotion->employee->presentPosting }}</td>
                            <td>
                                <span class="badge badge-{{ $promotion->type == 'MACP' ? 'blue' : ($promotion->type == 'ACP' ? 'purple' : 'green') }}">
                                    {{ $promotion->type }}
                                </span>
                            </td>
                            <td>{{ $promotion->previous_designation }}</td>
                            <td class="font-medium">{{ $promotion->new_designation }}</td>
                            <td>{{ $promotion->effective_date->format('d M, Y') }}</td>
                            <td>{{ $promotion->approvedBy->name ?? 'System' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn { display: none !important; }
    .card { break-inside: avoid; }
}
</style>
@endpush
@endsection