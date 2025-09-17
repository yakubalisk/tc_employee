<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'present_region', 'date_of_joining', 'date_of_relieving',
        'duration', 'transfer_order_no', 'transfer_remarks'
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'date_of_relieving' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}