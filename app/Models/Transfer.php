<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'previous_posting',
        'new_posting',
        'transfer_date',
        'transfer_order_no',
        'remarks',
        'status',
        'approved_by',
        'approved_at',
        'date_of_joining',
        'date_of_relieving'
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
        'date_of_joining' => 'date',
        'date_of_relieving' => 'date',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('transfer_date', now()->month)
                    ->whereYear('transfer_date', now()->year);
    }

    // Accessors
    public function getDurationAttribute()
    {
        if ($this->date_of_relieving) {
            $start = Carbon::parse($this->date_of_joining);
            $end = Carbon::parse($this->date_of_relieving);
            $years = $end->diffInYears($start);
            $months = $end->diffInMonths($start) % 12;
            return "{$years} YEARS AND {$months} MONTHS";
        }

        if ($this->date_of_joining) {
            $start = Carbon::parse($this->date_of_joining);
            $years = now()->diffInYears($start);
            $months = now()->diffInMonths($start) % 12;
            return "{$years} YEARS AND {$months} MONTHS";
        }

        return 'N/A';
    }

    public function getIsCurrentPostingAttribute()
    {
        return $this->date_of_relieving === null || $this->date_of_relieving === 'TILL DATE';
    }

    // Events
    protected static function booted()
    {
        static::created(function ($transfer) {
            // Update employee's current posting when transfer is created
            if ($transfer->employee) {
                $transfer->employee->update([
                    'current_posting' => $transfer->new_posting
                ]);
            }
        });

        static::updated(function ($transfer) {
            // Update employee record when transfer is approved/completed
            if (in_array($transfer->status, ['Approved', 'Completed']) && $transfer->employee) {
                $transfer->employee->update([
                    'current_posting' => $transfer->new_posting,
                    'last_transfer_date' => $transfer->transfer_date,
                    'current_transfer_id' => $transfer->id
                ]);
            }
        });
    }
}