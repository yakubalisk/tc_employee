@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Transfer Management</h1>
            <p class="text-muted-foreground">Manage employee transfers and postings</p>
        </div>
        <a href="{{ route('transfers.create') }}" class="btn btn-primary">
            <i class="plus-icon mr-2"></i>
            New Transfer
        </a>
    </div>

    <!-- Transfer Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @include('transfers.partials.stats-card', [
            'title' => 'Total Transfers',
            'value' => $stats['total_transfers'],
            'icon' => 'arrow-right-left-icon',
            'color' => 'blue'
        ])
        
        @include('transfers.partials.stats-card', [
            'title' => 'Active Locations',
            'value' => $stats['active_locations'],
            'icon' => 'map-pin-icon',
            'color' => 'green'
        ])
        
        @include('transfers.partials.stats-card', [
            'title' => 'Pending Transfers',
            'value' => $stats['pending_transfers'],
            'icon' => 'calendar-icon',
            'color' => 'purple'
        ])
        
        @include('transfers.partials.stats-card', [
            'title' => 'This Month',
            'value' => $stats['this_month_transfers'],
            'icon' => 'clock-icon',
            'color' => 'orange'
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
                        <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div>
                    <label class="label">Location</label>
                    <select name="location" class="select" onchange="this.form.submit()">
                        <option value="all" {{ $location == 'all' ? 'selected' : '' }}>All Locations</option>
                        @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ $location == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="label">&nbsp;</label>
                    <button type="submit" class="btn btn-outline w-full">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transfers -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Transfers</div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @foreach($recentTransfers as $transfer)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div>
                            <p class="font-medium">{{ $transfer->employee->name }}</p>
                            <p class="text-sm text-muted-foreground">
                                {{ $transfer->previous_posting }} → {{ $transfer->new_posting }}
                            </p>
                            <p class="text-xs text-muted-foreground">
                                {{ $transfer->transfer_date->format('d M, Y') }}
                            </p>
                        </div>
                        <span class="badge badge-success">{{ $transfer->status }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Location Distribution -->
        <div class="card">
            <div class="card-header">
                <div class="flex items-center gap-2 card-title">
                    <i class="map-pin-icon"></i>
                    Current Location Distribution
                </div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @foreach($currentLocations->take(6) as $location)
                    @php
                        $count = App\Models\Employee::where('current_posting', $location)->count();
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-primary"></div>
                            <span class="font-medium">{{ $location }}</span>
                        </div>
                        <span class="badge badge-secondary">{{ $count }} employees</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer History Table -->
    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-2 card-title">
                <i class="file-text-icon"></i>
                Transfer History
            </div>
        </div>
        <div class="card-content">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Location</th>
                            <th>Joining Date</th>
                            <th>Duration</th>
                            <th>Order No.</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $transfer)
                        <tr>
                            <td>
                                <div>
                                    <p class="font-medium">{{ $transfer->employee->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $transfer->employee->empCode }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $transfer->employee->designationAtPresent }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="map-pin-icon h-4 w-4 text-muted-foreground"></i>
                                    {{ $transfer->new_posting }}
                                </div>
                            </td>
                            <td>{{ $transfer->date_of_joining ? $transfer->date_of_joining->format('d M, Y') : 'N/A' }}</td>
                            <td>
                                <div class="text-sm">
                                    {{ $transfer->duration }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-outline">{{ $transfer->transfer_order_no ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $transfer->status == 'Completed' ? 'success' : 
                                    ($transfer->status == 'Pending' ? 'warning' : 
                                    ($transfer->status == 'Approved' ? 'info' : 'danger')) 
                                }}">
                                    {{ $transfer->status }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('transfers.show', $transfer) }}" class="btn btn-ghost btn-sm">
                                        <i class="eye-icon"></i>
                                    </a>
                                    @if($transfer->status == 'Pending')
                                    <form action="{{ route('transfers.approve', $transfer) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="check-icon"></i>
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $transfer->id }})" class="btn btn-danger btn-sm">
                                        <i class="x-icon"></i>
                                    </button>
                                    @endif
                                    @if($transfer->status == 'Approved')
                                    <form action="{{ route('transfers.complete', $transfer) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="check-circle-icon"></i>
                                        </button>
                                    </form>
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
                {{ $transfers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Reject Transfer</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="label">Reason for Rejection</label>
                    <textarea name="rejection_reason" class="textarea" required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="closeRejectModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(transferId) {
        document.getElementById('rejectForm').action = `/transfers/${transferId}/reject`;
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

    // Load location distribution data
    async function loadLocationDistribution() {
        try {
            const response = await fetch('/api/location-distribution');
            const data = await response.json();
            // You can use this data for charts or additional displays
            console.log('Location distribution:', data);
        } catch (error) {
            console.error('Error loading location distribution:', error);
        }
    }

    // Load data when page is ready
    document.addEventListener('DOMContentLoaded', function() {
        loadLocationDistribution();
    });
</script>
@endpush

@push('styles')
<style>
.plus-icon, .arrow-right-left-icon, .map-pin-icon, .calendar-icon, 
.clock-icon, .file-text-icon, .eye-icon, .check-icon, .x-icon,
.check-circle-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

.plus-icon { background-image: url("data:image/svg+xml,..."); }
.arrow-right-left-icon { background-image: url("data:image/svg+xml,..."); }
.map-pin-icon { background-image: url("data:image/svg+xml,..."); }
.calendar-icon { background-image: url("data:image/svg+xml,..."); }
.clock-icon { background-image: url("data:image/svg+xml,..."); }
.file-text-icon { background-image: url("data:image/svg+xml,..."); }
.eye-icon { background-image: url("data:image/svg+xml,..."); }
.check-icon { background-image: url("data:image/svg+xml,..."); }
.x-icon { background-image: url("data:image/svg+xml,..."); }
.check-circle-icon { background-image: url("data:image/svg+xml,..."); }

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