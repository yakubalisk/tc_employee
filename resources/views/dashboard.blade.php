@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Dashboard</h1>
            <p class="text-muted-foreground">Overview of your organization's workforce</p>
        </div>
        <span class="px-3 py-1 badge badge-secondary">
            {{ now()->format('d M, Y') }}
        </span>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach($quickStats as $stat)
        <div class="relative overflow-hidden card">
            <div class="flex flex-row items-center justify-between pb-2 card-header space-y-0">
                <div class="text-sm font-medium text-muted-foreground card-title">
                    {{ $stat['title'] }}
                </div>
                <div class="p-2 rounded-full {{ $stat['bgColor'] }}">
                    <i class="{{ $stat['icon'] }} {{ $stat['color'] }}"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="text-2xl font-bold text-foreground">{{ $stat['value'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Gender Distribution -->
        <div class="card">
            <div class="card-header">
                <div class="flex items-center gap-2 card-title">
                    <i class="text-primary users-icon"></i>
                    Gender Distribution
                </div>
            </div>
            <div class="card-content">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Male</span>
                        <span class="badge badge-secondary">{{ $stats['genderDistribution']['male'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Female</span>
                        <span class="badge badge-secondary">{{ $stats['genderDistribution']['female'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Other</span>
                        <span class="badge badge-secondary">{{ $stats['genderDistribution']['other'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Employees -->
        <div class="lg:col-span-2 card">
            <div class="card-header">
                <div class="flex items-center gap-2 card-title">
                    <i class="text-primary building-icon"></i>
                    Recent Employee Records
                </div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @foreach($recentEmployees as $employee)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div>
                            <p class="font-medium text-foreground">{{ $employee->name }}</p>
                            <p class="text-sm text-muted-foreground">{{ $employee->designationAtPresent }}</p>
                            <p class="text-xs text-muted-foreground">{{ $employee->presentPosting }}</p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-outline">{{ $employee->empCode }}</span>
                            <p class="mt-1 text-xs text-muted-foreground">
                                {{ $employee->category }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title">
                <i class="text-primary file-text-icon"></i>
                Quick Actions
            </div>
        </div>
        <div class="card-content">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <a href="{{ route('employees.create') }}" class="block p-4 text-center transition-colors border border-dashed rounded-lg border-muted-foreground/25 hover:bg-muted/50">
                    <i class="h-8 w-8 mx-auto mb-2 text-primary user-plus-icon"></i>
                    <p class="text-sm font-medium">Add New Employee</p>
                </a>
                <a href="{{ route('reports.generate') }}" class="block p-4 text-center transition-colors border border-dashed rounded-lg border-muted-foreground/25 hover:bg-muted/50">
                    <i class="h-8 w-8 mx-auto mb-2 text-primary file-text-icon"></i>
                    <p class="text-sm font-medium">Generate Report</p>
                </a>
                <a href="{{ route('promotions.process') }}" class="block p-4 text-center transition-colors border border-dashed rounded-lg border-muted-foreground/25 hover:bg-muted/50">
                    <i class="h-8 w-8 mx-auto mb-2 text-primary trending-up-icon"></i>
                    <p class="text-sm font-medium">Process Promotion</p>
                </a>
                <a href="{{ route('transfers.schedule') }}" class="block p-4 text-center transition-colors border border-dashed rounded-lg border-muted-foreground/25 hover:bg-muted/50">
                    <i class="h-8 w-8 mx-auto mb-2 text-primary calendar-icon"></i>
                    <p class="text-sm font-medium">Schedule Transfer</p>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.users-icon, .calendar-icon, .trending-up-icon, .award-icon, 
.file-text-icon, .building-icon, .user-plus-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

/* You would replace these with actual icon implementations */
.users-icon { background-image: url("data:image/svg+xml,..."); }
.calendar-icon { background-image: url("data:image/svg+xml,..."); }
.trending-up-icon { background-image: url("data:image/svg+xml,..."); }
.award-icon { background-image: url("data:image/svg+xml,..."); }
.file-text-icon { background-image: url("data:image/svg+xml,..."); }
.building-icon { background-image: url("data:image/svg+xml,..."); }
.user-plus-icon { background-image: url("data:image/svg+xml,..."); }
</style>
@endpush
@endsection