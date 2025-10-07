<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'region_id');
    }

    public function transferredTransfers()
    {
        return $this->hasMany(Transfer::class, 'transferred_region_id');
    }

    public static function getDropdownOptions()
    {
        return self::orderBy('name')->pluck('name', 'id');
    }
}