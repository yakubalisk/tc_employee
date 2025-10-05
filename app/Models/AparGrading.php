<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AparGrading extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'from_month',
        'from_year', 
        'to_month',
        'to_year',
        'grading_type',
        'discrepancy_remarks',
        'reporting_marks',
        'reviewing_marks',
        'reporting_grade',
        'reviewing_grade',
        'consideration',
        'remarks'
    ];

    protected $casts = [
        'reporting_marks' => 'decimal:1',
        'reviewing_marks' => 'decimal:1',
        'consideration' => 'boolean',
        'from_year' => 'integer',
        'to_year' => 'integer',
    ];

    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor for period display
    public function getPeriodAttribute()
    {
        return "{$this->from_month} {$this->from_year} - {$this->to_month} {$this->to_year}";
    }

    // Scope for recent APARs
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Scope for specific employee
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }
}