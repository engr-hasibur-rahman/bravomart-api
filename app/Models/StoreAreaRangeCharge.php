<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreAreaRangeCharge extends Model
{
    protected $fillable = [
        'com_store_type_id',
        'min_km',
        'max_km',
        'charge_amount',
        'status'
    ];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class, 'com_store_type_id');
    }
}
