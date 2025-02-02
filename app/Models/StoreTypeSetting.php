<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTypeSetting extends Model
{
    protected $fillable = [
        'com_store_type_id',
        'com_area_id',
        'delivery_time_per_km',
        'min_order_delivery_fee',
        'delivery_charge_method',
        'fixed_charge_amount',
        'per_km_charge_amount'
    ];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class, 'com_store_type_id');
    }

    public function area()
    {
        return $this->belongsTo(StoreArea::class, 'com_area_id');
    }
}
