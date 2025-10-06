<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayFixation extends Model
{
    use HasFactory;

    protected $fillable = [
        'empl_id',
        'pay_fixation_date',
        'basic_pay',
        'grade_pay',
        'cell_no',
        'revised_level',
        'pay_fixation_remarks',
        'level_2',
    ];

    protected $casts = [
        'pay_fixation_date' => 'date',
        'basic_pay' => 'decimal:2',
        'grade_pay' => 'decimal:2',
    ];

    // Constants for dropdown values
    const REVISED_LEVELS = [
        'Level 1' => 'Level 1',
        'Level 2' => 'Level 2',
        'Level 3' => 'Level 3',
        'Level 4' => 'Level 4',
        'Level 5' => 'Level 5',
        'Level 6' => 'Level 6',
        'Level 7' => 'Level 7',
        'Level 8' => 'Level 8',
        'Level 9' => 'Level 9',
        'Level 10' => 'Level 10',
        'Level 11' => 'Level 11',
        'Level 12' => 'Level 12',
        'Level 13' => 'Level 13',
        'Level 14' => 'Level 14',
    ];

    const LEVEL_2_OPTIONS = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
    ];

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('empl_id', 'like', "%{$search}%")
              ->orWhere('revised_level', 'like', "%{$search}%")
              ->orWhere('pay_fixation_remarks', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByLevel($query, $level)
    {
        if ($level && $level !== 'all') {
            return $query->where('revised_level', $level);
        }
        return $query;
    }

    public function scopeFilterByLevel2($query, $level2)
    {
        if ($level2 && $level2 !== 'all') {
            return $query->where('level_2', $level2);
        }
        return $query;
    }

    // Accessor for formatted date
    public function getFormattedPayFixationDateAttribute()
    {
        return $this->pay_fixation_date->format('d-M-y');
    }

    // Accessor for formatted basic pay
    public function getFormattedBasicPayAttribute()
    {
        return '₹' . number_format($this->basic_pay, 2);
    }

    // Accessor for formatted grade pay
    public function getFormattedGradePayAttribute()
    {
        return $this->grade_pay ? '₹' . number_format($this->grade_pay, 2) : 'N/A';
    }
}