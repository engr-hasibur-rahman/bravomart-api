<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    protected $fillable = [
        'name',
        'type',
        'image',
        'description',
        'total_stores',
        'status'
    ];

    public function settings()
    {
        return $this->hasMany(StoreTypeSetting::class, 'com_store_type_id');
    }

    public function rangeCharges()
    {
        return $this->hasMany(StoreTypeRangeCharge::class, 'com_store_type_id');
    }
}
