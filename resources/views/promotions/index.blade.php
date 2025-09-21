@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header and Stats -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Promotion Management</h1>
            <p class="text-muted-foreground">Track and manage employee promotions</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('promotions.report') }}" class="btn btn-outline">
                <i class="file-text-icon mr-2"></i>
                Generate Report
            </a>
            <a href="{{ route('promotions.create') }}" class="btn btn-primary">
                <i class="plus-icon mr-2"></i>
                New Promotion
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @include('promotions.partials.stats-card', [
            'title' => 'Total Promotions',
            'value' => $stats['total_promotions'],
            'icon' => 'trending-up-icon',
            'color' => 'blue'
        ])
        
        @include('promotions.partials.stats-card', [
            'title' => 'Approved',
            'value' => $stats['approved_promotions'],
            'icon' => 'check-circle-icon',
            'color' => 'green'
        ])
        
        @include('promotions.partials.stats-card', [
            'title' => 'Pending Approval',
            'value' => $stats['pending_approvals'],
            'icon' => 'clock-icon',
            'color' => 'orange'
        ])
        
        @include('promotions.partials.stats-card', [
            'title' => 'This Year',
            'value' => $stats['this_year_promotions'],
            'icon' => 'calendar-icon',
            'color' => 'purple'
        ])
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-content">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="label">Status</label>
                    <select name="status" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
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
                    <label class="label">Year</label>
                    <select name="year" class="select" onchange="this.form.submit()">
                        @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label class="label">&nbsp;</label>
                    <button type="submit" class="btn btn-outline w-full">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Promotions Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Promotion Records</div>
        </div>
        <div class="card-content">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Previous Designation</th>
                            <th>New Designation</th>
                            <th>Effective Date</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                            <td>
                                <span class="badge badge-{{ $promotion->type == 'MACP' ? 'blue' : ($promotion->type == 'ACP' ? 'purple' : 'green') }}">
                                    {{ $promotion->type }}
                                </span>
                            </td>
                            <td>{{ $promotion->previous_designation }}</td>
                            <td class="font-medium">{{ $promotion->new_designation }}</td>
                            <td>{{ $promotion->effective_date->format('d M, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $promotion->approval_status == 'Approved' ? 'success' : ($promotion->approval_status == 'Pending' ? 'warning' : 'danger') }}">
                                    {{ $promotion->approval_status }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('promotions.show', $promotion) }}" class="btn btn-ghost btn-sm">
                                        <i class="eye-icon"></i>
                                    </a>
                                    @if($promotion->approval_status == 'Pending')
                                    <form action="{{ route('promotions.approve', $promotion) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="check-icon"></i>
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $promotion->id }})" class="btn btn-danger btn-sm">
                                        <i class="x-icon"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $promotions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- Recent Promotions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Promotions</div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @foreach($recentPromotions as $promotion)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div>
                            <p class="font-medium">{{ $promotion->employee->name }}</p>
                            <p class="text-sm text-muted-foreground">{{ $promotion->new_designation }}</p>
                            <p class="text-xs text-muted-foreground">{{ $promotion->effective_date->format('d M, Y') }}</p>
                        </div>
                        <span class="badge badge-success">{{ $promotion->type }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Promotion Eligibility</div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @foreach($eligibleEmployees->take(5) as $employee)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div>
                            <p class="font-medium">{{ $employee->name }}</p>
                            <p class="text-sm text-muted-foreground">{{ $employee->current_designation }}</p>
                            <p class="text-xs text-muted-foreground">{{ $employee->presentPosting }}</p>
                        </div>
                        <span class="badge badge-success">Eligible</span>
                    </div>
                    @endforeach
                    @if($eligibleEmployees->count() > 5)
                    <div class="text-center">
                        <a href="{{ route('employees.index') }}?promotion_eligible=1" class="text-primary hover:underline">
                            View all {{ $eligibleEmployees->count() }} eligible employees
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Reject Promotion</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="label">Reason for Rejection</label>
                    <textarea name="rejection_reason" class="textarea" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="closeRejectModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Promotion</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(promotionId) {
        document.getElementById('rejectForm').action = `/promotions/${promotionId}/reject`;
        document.getElementById('rejectModal').style.display = 'block';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target === modal) {
            closeRejectModal();
        }
    }
</script>
@endpush

@push('styles')
<style>
/* Icon styles */
.plus-icon, .file-text-icon, .trending-up-icon, .check-circle-icon, 
.clock-icon, .calendar-icon, .eye-icon, .check-icon, .x-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

.plus-icon { background-image: url("data:image/svg+xml,..."); }
.file-text-icon { background-image: url("data:image/svg+xml,..."); }
.trending-up-icon { background-image: url("data:image/svg+xml,..."); }
.check-circle-icon { background-image: url("data:image/svg+xml,..."); }
.clock-icon { background-image: url("data:image/svg+xml,..."); }
.calendar-icon { background-image: url("data:image/svg+xml,..."); }
.eye-icon { background-image: url("data:image/svg+xml,..."); }
.check-icon { background-image: url("data:image/svg+xml,..."); }
.x-icon { background-image: url("data:image/svg+xml,..."); }

/* Modal styles */
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    max-width: 500px;
}
</style>
@endpush
@endsection