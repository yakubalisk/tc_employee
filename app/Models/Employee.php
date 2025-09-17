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
        'presentPosting',
        'personalFileNo',
        'officeLandline',
        'dateOfBirth',
        'dateOfRetirement',
        'homeTown',
        'residentialAddress',
        'status',
        'promoted'
    ];

    protected $casts = [
        'dateOfAppointment' => 'date',
        'dateOfBirth' => 'date',
        'dateOfRetirement' => 'date',
        'promoted' => 'boolean',
    ];

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
}