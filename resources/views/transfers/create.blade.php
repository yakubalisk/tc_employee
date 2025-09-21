@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Process New Transfer</h1>
            <p class="text-muted-foreground">Transfer employee to a new location</p>
        </div>
        <a href="{{ route('transfers.index') }}" class="btn btn-outline">
            Back to Transfers
        </a>
    </div>

    <div class="card">
        <div class="card-content">
            <form action="{{ route('transfers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="employee_id" class="label">Select Employee</label>
                        <select name="employee_id" id="employee_id" class="select" required>
                            <option value="">Choose employee for transfer</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->name }} - {{ $employee->current_posting }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="new_posting" class="label">New Posting Location</label>
                        <select name="new_posting" id="new_posting" class="select" required>
                            <option value="">Select new location</option>
                            @foreach($locations as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="transfer_date" class="label">Transfer Date</label>
                        <input type="date" name="transfer_date" id="transfer_date" class="input" required>
                    </div>

                    <div>
                        <label for="transfer_order_no" class="label">Transfer Order Number</label>
                        <input type="text" name="transfer_order_no" id="transfer_order_no" class="input" 
                            placeholder="Enter transfer order number">
                    </div>

                    <div class="md:col-span-2">
                        <label for="remarks" class="label">Transfer Remarks</label>
                        <textarea name="remarks" id="remarks" class="textarea" 
                            placeholder="Add transfer remarks..."></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full btn btn-primary">
                            <i class="arrow-right-left-icon mr-2"></i>
                            Process Transfer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('transfer_date').min = today;
    });
</script>
@endpush
@endsection