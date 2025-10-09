<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        // Personal Information
        'profile_image',
        'empCode',
        'empId', 
        'name',
        'gender',
        'category',
        'education',
        'mobile',
        'email',
        
        // Employment Details
        'dateOfAppointment',
        'designationAtAppointment',
        'designationAtPresent',
        'presentPosting',
        'personalFileNo',
        'officeLandline',
        
        // Personal Details
        'dateOfBirth',
        'dateOfRetirement', 
        'homeTown',
        'residentialAddress',
        'status',
        
        // Additional Fields
        'office_in_charge',
        'promotee_transferee',
        'pension_file_no',
        'nps',
        'increment_month',
        'probation_period',
        'status_of_post',
        'department',
        'seniority_sequence_no',
        'sddlsection_incharge',
        'benevolent_member',
        'increment_individual_selc',
        'office_landline_number',
        'increment_withheld',
        'FR56J_2nd_batch',
        'apar_hod',
        'karmayogi_certificate_completed',
        '2021_2022',
        '2022_2023', 
        '2023_2024',
        '2024_2025',
    ];

    protected $casts = [
        'dateOfAppointment' => 'date',
        'dateOfBirth' => 'date',
        'dateOfRetirement' => 'date',
        
        // Cast boolean fields
        'office_in_charge' => 'boolean',
        'nps' => 'boolean',
        'probation_period' => 'boolean',
        'department' => 'boolean',
        'increment_individual_selc' => 'boolean',
        'increment_withheld' => 'boolean',
        'FR56J_2nd_batch' => 'boolean',
        'apar_hod' => 'boolean',
        'karmayogi_certificate_completed' => 'boolean',
        '2021_2022' => 'boolean',
        '2022_2023' => 'boolean',
        '2023_2024' => 'boolean',
        '2024_2025' => 'boolean',
        
        'increment_month' => 'integer',
    ];

    // Accessor for profile image URL
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.png');
    }

        // Relationships
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function currentPromotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'current_promotion_id');
    }

    // Scopes
    public function scopeEligibleForPromotion($query)
    {
        return $query->where('status', 'EXISTING')
                    ->whereDoesntHave('promotions', function ($q) {
                        $q->where('approval_status', 'Pending')
                          ->orWhere('effective_date', '>', now()->subYear());
                    });
    }

    public function scopeWithPromotions($query)
    {
        return $query->whereHas('promotions', function ($q) {
            $q->where('approval_status', 'Approved');
        });
    }

    // Accessors
    public function getPromotionEligibilityAttribute()
    {
        if (!$this->last_promotion_date) {
            return 'Eligible';
        }
        
        $lastPromotion = $this->last_promotion_date->diffInMonths(now());
        return $lastPromotion >= 12 ? 'Eligible' : 'Not Eligible';
    }

    // // Accessor for age calculation
    // public function getAgeAttribute()
    // {
    //     return $this->dateOfBirth ? now()->diffInYears($this->dateOfBirth) : null;
    // }

public function getAgeAttribute()
{
  
    if (!$this->dateOfBirth) {
        return 0;
    }
    
    return \Carbon\Carbon::parse($this->dateOfBirth)->age;
}

        // Scope for filtering
    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('empCode', 'like', "%{$searchTerm}%")
                  ->orWhere('designationAtPresent', 'like', "%{$searchTerm}%");
            });
        }
        return $query;
    }

    public function scopeFilterByGender($query, $gender)
    {
        if ($gender && $gender !== 'all') {
            return $query->where('gender', $gender);
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

        // Relationships
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    public function currentTransfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class, 'current_transfer_id');
    }

    // Scopes
    public function scopeByPosting($query, $posting)
    {
        return $query->where('current_posting', $posting);
    }

    public function scopeEligibleForTransfer($query)
    {
        return $query->where('status', 'EXISTING')
                    ->whereDoesntHave('transfers', function ($q) {
                        $q->where('status', 'Pending')
                          ->orWhere('transfer_date', '>', now()->subYear());
                    });
    }

public function aparGradings()
{
    return $this->hasMany(AparGrading::class);
}

// Accessor for latest APAR
public function getLatestAparAttribute()
{
    return $this->aparGradings()->latest()->first();
}

// Scope for employees with APAR records
public function scopeWithApar($query)
{
    return $query->whereHas('aparGradings');
}

public function financialUpgradations()
{
    return $this->hasMany(FinancialUpgradation::class);
}

// Accessor for latest financialUpgradations
public function getLatestfinancialUpgradationsAttribute()
{
    return $this->financialUpgradations()->latest()->first();
}

// Scope for employees with financialUpgradations records
public function scopeWithfinancialUpgradations($query)
{
    return $query->whereHas('financialUpgradations');
}
}