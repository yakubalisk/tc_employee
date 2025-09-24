<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'empCode',
        'empId',
        'name',
        'gender',
        'category',
        'education',
        'mobile',
        'email',
        'dateOfAppointment',
        'designationAtAppointment',
        'designationAtPresent',
        'current_designation',
        'presentPosting',
        'personalFileNo',
        'officeLandline',
        'dateOfBirth',
        'dateOfRetirement',
        'homeTown',
        'residentialAddress',
        'status',
        'promoted',
        'last_promotion_date',
        'current_promotion_id',
        'current_posting',
        'last_transfer_date',
        'current_transfer_id'
    ];

    protected $casts = [
        'dateOfAppointment' => 'date',
        'dateOfBirth' => 'date',
        'dateOfRetirement' => 'date',
        'promoted' => 'boolean',
        'last_promotion_date' => 'date',
        'last_transfer_date' => 'date',
    ];

        // Validation rules
    public static $rules = [
        'empCode' => 'required|unique:employees|max:50',
        'empId' => 'required|unique:employees|max:50',
        'name' => 'required|max:255',
        'gender' => 'required|in:MALE,FEMALE,OTHER',
        'category' => 'required|in:General,OBC,SC,ST',
        'education' => 'nullable|string',
        'mobile' => 'nullable|digits:10',
        'email' => 'nullable|email|unique:employees',
        'dateOfAppointment' => 'required|date',
        'designationAtAppointment' => 'required|string|max:255',
        'designationAtPresent' => 'required|string|max:255',
        'presentPosting' => 'required|string|max:255',
        'personalFileNo' => 'nullable|string|max:50',
        'officeLandline' => 'nullable|string|max:20',
        'dateOfBirth' => 'required|date',
        'dateOfRetirement' => 'required|date|after:dateOfBirth',
        'homeTown' => 'nullable|string|max:255',
        'residentialAddress' => 'nullable|string',
        'status' => 'required|in:EXISTING,RETIRED,TRANSFERRED'
    ];

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

    // Accessor for age calculation
    public function getAgeAttribute()
    {
        return $this->dateOfBirth ? now()->diffInYears($this->dateOfBirth) : null;
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
}