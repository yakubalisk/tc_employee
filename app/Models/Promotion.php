<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'promotion_type', 'from_designation', 'to_designation',
        'promotion_date', 'year', 'score', 'reviewer_remarks', 'performance_rating'
    ];

    protected $casts = [
        'promotion_date' => 'date',
        'score' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}