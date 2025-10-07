<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $primaryKey = 'transferId';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'empID',
        'designation_id',
        'date_of_joining',
        'date_of_releiving',
        'transfer_order_no',
        'transfer_remarks',
        'region_id',
        'date_of_exit',
        'duration',
        'department_worked_id',
        'transferred_region_id',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'date_of_releiving' => 'date',
        'date_of_exit' => 'date',
    ];

    // Relationships
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function transferredRegion()
    {
        return $this->belongsTo(Region::class, 'transferred_region_id', 'id');
    }

    public function departmentWorked()
    {
        return $this->belongsTo(Department::class, 'department_worked_id', 'id');
    }

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('empID', 'like', "%{$search}%")
              ->orWhere('transfer_order_no', 'like', "%{$search}%")
              ->orWhere('transfer_remarks', 'like', "%{$search}%")
              ->orWhereHas('designation', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('region', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('transferredRegion', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeFilterByRegion($query, $region)
    {
        if ($region && $region !== 'all') {
            return $query->where('region_id', $region);
        }
        return $query;
    }

    public function scopeFilterByTransferredRegion($query, $transferredRegion)
    {
        if ($transferredRegion && $transferredRegion !== 'all') {
            return $query->where('transferred_region_id', $transferredRegion);
        }
        return $query;
    }

    public function scopeFilterByDesignation($query, $designation)
    {
        if ($designation && $designation !== 'all') {
            return $query->where('designation_id', $designation);
        }
        return $query;
    }

    // Accessors for formatted dates
    public function getFormattedDateOfJoiningAttribute()
    {
        return $this->date_of_joining->format('d-M-y');
    }

    public function getFormattedDateOfReleivingAttribute()
    {
        return $this->date_of_releiving->format('d-M-y');
    }

    public function getFormattedDateOfExitAttribute()
    {
        return $this->date_of_exit ? $this->date_of_exit->format('d-M-y') : null;
    }

    // Calculate duration automatically
    public function getCalculatedDurationAttribute()
    {
        $start = $this->date_of_joining;
        $end = $this->date_of_releiving;
        
        $years = $end->diffInYears($start);
        $months = $end->diffInMonths($start) % 12;
        
        if ($years > 0 && $months > 0) {
            return "{$years} years {$months} months";
        } elseif ($years > 0) {
            return "{$years} years";
        } else {
            return "{$months} months";
        }
    }
}