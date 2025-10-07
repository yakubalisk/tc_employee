<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'grade'];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'designation_id');
    }

    public static function getDropdownOptions()
    {
        return self::orderBy('name')->pluck('name', 'id');
    }
}