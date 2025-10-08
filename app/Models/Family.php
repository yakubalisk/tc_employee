<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'empID',
        'name_of_family_member',
        'relationship',
        'date_of_birth',
        'dependent_remarks',
        'reason_for_dependence',
        'age',
        'ltc',
        'medical',
        'gsli',
        'gpf',
        'dcrg',
        'pension_nps',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'ltc' => 'boolean',
        'medical' => 'boolean',
        'gsli' => 'boolean',
        'gpf' => 'boolean',
        'dcrg' => 'boolean',
        'pension_nps' => 'boolean',
    ];

    // Constants for dropdown values
    const RELATIONSHIPS = [
        'Wife' => 'Wife',
        'Husband' => 'Husband',
        'Son' => 'Son',
        'Daughter' => 'Daughter',
        'Father' => 'Father',
        'Mother' => 'Mother',
        'Brother' => 'Brother',
        'Sister' => 'Sister',
        'Grandfather' => 'Grandfather',
        'Grandmother' => 'Grandmother',
        'Father-in-law' => 'Father-in-law',
        'Mother-in-law' => 'Mother-in-law',
    ];

    const DEPENDENCE_REASONS = [
        'HOUSE WIFE' => 'House Wife',
        'NO INCOME' => 'No Income',
        'MINOR' => 'Minor',
        'STUDENT' => 'Student',
        'DISABLED' => 'Disabled',
        'RETIRED' => 'Retired',
        'OTHER' => 'Other',
    ];

    // Scopes for filtering
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('empID', 'like', "%{$search}%")
              ->orWhere('name_of_family_member', 'like', "%{$search}%")
              ->orWhere('relationship', 'like', "%{$search}%")
              ->orWhere('dependent_remarks', 'like', "%{$search}%")
              ->orWhere('reason_for_dependence', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByRelationship($query, $relationship)
    {
        if ($relationship && $relationship !== 'all') {
            return $query->where('relationship', $relationship);
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

    // Accessor for formatted date of birth
    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth->format('d-M-y');
    }

    // Accessor for calculated age
    public function getCalculatedAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    // Automatically calculate age before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->date_of_birth) {
                $model->age = $model->date_of_birth->age;
            }
        });
    }

    // Accessor for benefits summary
    public function getBenefitsSummaryAttribute()
    {
        $benefits = [];
        if ($this->ltc) $benefits[] = 'LTC';
        if ($this->medical) $benefits[] = 'Medical';
        if ($this->gsli) $benefits[] = 'GSLI';
        if ($this->gpf) $benefits[] = 'GPF';
        if ($this->dcrg) $benefits[] = 'DCRG';
        if ($this->pension_nps) $benefits[] = 'Pension/NPS';

        return implode(', ', $benefits) ?: 'None';
    }
}