<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialUpgradation extends Model
{
    use HasFactory;


        protected $fillable = [
        'employee_id',
        'promotion_date',
        'existing_designation',
        'upgraded_designation',
        'date_in_grade',
        'existing_scale',
        'upgraded_scale',
        'pay_fixed',
        'existing_pay',
        'existing_grade_pay',
        'upgraded_pay',
        'upgraded_grade_pay',
        'macp_remarks',
        'no_of_financial_upgradation',
        'financial_upgradation_type',
        'region',
        'department',
    ];

    protected $casts = [
        'promotion_date' => 'date',
        'date_in_grade' => 'date',
        'existing_pay' => 'decimal:2',
        'existing_grade_pay' => 'decimal:2',
        'upgraded_pay' => 'decimal:2',
        'upgraded_grade_pay' => 'decimal:2',
    ];

    // Constants for dropdown values
    const REGIONS = [
        'north' => 'North Region',
        'south' => 'South Region', 
        'east' => 'East Region',
        'west' => 'West Region',
    ];

    const DEPARTMENTS = [
        'finance' => 'Finance',
        'hr' => 'Human Resources',
        'it' => 'IT',
        'operations' => 'Operations',
        'lab' => 'Laboratory',
    ];

    const DESIGNATIONS = [
        'jqao_lab' => 'JQAO (LAB)',
        'qao_lab' => 'QAO (LAB)',
        'assistant_manager' => 'Assistant Manager',
        'manager' => 'Manager',
        'senior_manager' => 'Senior Manager',
        'executive' => 'Executive',
        'senior_executive' => 'Senior Executive',
    ];

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('employee_id', 'like', "%{$search}%")
              ->orWhere('existing_designation', 'like', "%{$search}%")
              ->orWhere('upgraded_designation', 'like', "%{$search}%")
              ->orWhere('macp_remarks', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByRegion($query, $region)
    {
        if ($region && $region !== 'all') {
            return $query->where('region', $region);
        }
        return $query;
    }

    public function scopeFilterByDepartment($query, $department)
    {
        if ($department && $department !== 'all') {
            return $query->where('department', $department);
        }
        return $query;
    }

    public function scopeFilterByDesignation($query, $designation)
    {
        if ($designation && $designation !== 'all') {
            return $query->where('upgraded_designation', $designation);
        }
        return $query;
    }

    public function scopeFilterByType($query, $type)
    {
        if ($type && $type !== 'all') {
            return $query->where('financial_upgradation_type', $type);
        }
        return $query;
    }

    // protected $fillable = [
    //     'employee_id', 'financial_upgradation_type', 'dt_of_promotion_acp_macp',
    //     'dt_of_in_this_grade', 'no_of_financial_upgradation', 'existing_scale',
    //     'upgraded_level'
    // ];

    // protected $casts = [
    //     'dt_of_promotion_acp_macp' => 'date',
    //     'dt_of_in_this_grade' => 'date',
    // ];
    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}