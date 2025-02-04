<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTypeSetting extends Model
{
    protected $fillable = [
        'store_type_id',
        'store_area_id',
        'delivery_time_per_km',
        'min_order_delivery_fee',
        'delivery_charge_method',
        'out_of_area_delivery_charge',
        'fixed_charge_amount',
        'per_km_charge_amount'
    ];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class, 'store_type_id');
    }

    public function storeArea()
    {
        return $this->belongsTo(StoreArea::class, 'store_area_id');
    }
}
