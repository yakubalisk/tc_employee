<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'type', 'previous_designation', 'new_designation',
        'effective_date', 'remarks', 'approval_status', 'approved_by',
        'approved_at', 'financial_details'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'approved_at' => 'datetime',
        'financial_details' => 'array',
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
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'Approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'Pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'Rejected');
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('effective_date', now()->year);
    }

    // Events
    protected static function booted()
    {
        static::created(function ($promotion) {
            // Update employee's current designation when promotion is created
            if ($promotion->employee) {
                $promotion->employee->update([
                    'current_designation' => $promotion->new_designation
                ]);
            }
        });

        static::updated(function ($promotion) {
            // Update employee record when promotion is approved
            if ($promotion->approval_status === 'Approved' && $promotion->employee) {
                $promotion->employee->update([
                    'current_designation' => $promotion->new_designation,
                    'last_promotion_date' => $promotion->effective_date,
                    'current_promotion_id' => $promotion->id
                ]);
            }
        });
    }
}