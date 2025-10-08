<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'empID',
        'name_of_doctor',
        'registration_no',
        'address',
        'qualification',
        'ama_remarks',
    ];

    // Constants for qualification types
    const QUALIFICATIONS = [
        'MBBS' => 'MBBS',
        'BAMS' => 'BAMS',
        'BHMS' => 'BHMS',
        'BDS' => 'BDS',
        'MD' => 'MD',
        'MS' => 'MS',
        'DNB' => 'DNB',
        'DM' => 'DM',
        'MCh' => 'MCh',
        'PhD' => 'PhD',
        'OTHER' => 'Other',
    ];

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('empID', 'like', "%{$search}%")
              ->orWhere('name_of_doctor', 'like', "%{$search}%")
              ->orWhere('registration_no', 'like', "%{$search}%")
              ->orWhere('qualification', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%")
              ->orWhere('ama_remarks', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByQualification($query, $qualification)
    {
        if ($qualification && $qualification !== 'all') {
            return $query->where('qualification', $qualification);
        }
        return $query;
    }

    public function scopeFilterByEmpID($query, $empID)
    {
        if ($empID && $empID !== 'all') {
            return $query->where('empID', $empID);
        }
        return $query;
    }

    // Accessor for formatted doctor name
    public function getFormattedDoctorNameAttribute()
    {
        if (!$this->name_of_doctor) {
            return 'Not Specified';
        }

        // Add "Dr." prefix if not already present
        if (!str_starts_with(strtoupper($this->name_of_doctor), 'DR')) {
            return 'Dr. ' . $this->name_of_doctor;
        }

        return $this->name_of_doctor;
    }

    // Accessor for short address
    public function getShortAddressAttribute()
    {
        if (!$this->address) {
            return 'N/A';
        }

        return strlen($this->address) > 50 
            ? substr($this->address, 0, 50) . '...' 
            : $this->address;
    }
}