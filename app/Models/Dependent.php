<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dependent extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'name_of_family_member', 'relationship', 'date_of_birth',
        'dependent_remarks', 'reason_for_dependence', 'age'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getCurrentAge()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }
}