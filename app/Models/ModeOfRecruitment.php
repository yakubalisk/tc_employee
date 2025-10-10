<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeOfRecruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'emp_code',
        'Designation_',
        'Seniority_Number',
        'Designation',
        'Date_of_Entry',
        'Office_Order_No',
        'Method_of_Recruitment',
        'Promotion_Remarks',
        'Pay_Fixation',
        'Date_of_Exit',
        'GSLI_Policy_No',
        'GSLI_Entry_dt',
        'GSLI_Exit_dt',
    ];

    protected $casts = [
        'Date_of_Entry' => 'date',
        'Date_of_Exit' => 'date',
        'GSLI_Entry_dt' => 'date',
        'GSLI_Exit_dt' => 'date',
    ];

    // Constants for dropdown values
    const RECRUITMENT_METHODS = [
        'PR' => 'Promotion',
        'DIRECT' => 'Direct Recruitment',
        'DEPUTATION' => 'Deputation',
        'CONTRACT' => 'Contract',
    ];

    const PAY_FIXATION_OPTIONS = [
        'Yes' => 'Yes',
        'No' => 'No',
    ];

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('employee_id', 'like', "%{$search}%")
              ->orWhere('Designation', 'like', "%{$search}%")
              ->orWhere('Designation_', 'like', "%{$search}%")
              ->orWhere('Office_Order_No', 'like', "%{$search}%")
              ->orWhere('Promotion_Remarks', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByMethod($query, $method)
    {
        if ($method && $method !== 'all') {
            return $query->where('Method_of_Recruitment', $method);
        }
        return $query;
    }

    public function scopeFilterByPayFixation($query, $payFixation)
    {
        if ($payFixation && $payFixation !== 'all') {
            return $query->where('Pay_Fixation', $payFixation);
        }
        return $query;
    }

    // Accessor for formatted dates
    public function getFormattedDateOfEntryAttribute()
    {
        return $this->Date_of_Entry->format('d-m-Y');
    }

    public function getFormattedDateOfExitAttribute()
    {
        return $this->Date_of_Exit ? $this->Date_of_Exit->format('d-m-Y') : null;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}