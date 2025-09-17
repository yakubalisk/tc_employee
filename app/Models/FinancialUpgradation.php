<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialUpgradation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'financial_upgradation_type', 'dt_of_promotion_acp_macp',
        'dt_of_in_this_grade', 'no_of_financial_upgradation', 'existing_scale',
        'upgraded_level'
    ];

    protected $casts = [
        'dt_of_promotion_acp_macp' => 'date',
        'dt_of_in_this_grade' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}