<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'department_worked_id');
    }

    public static function getDropdownOptions()
    {
        return self::orderBy('name')->pluck('name', 'id');
    }
}