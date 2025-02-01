<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    protected $fillable = [
        'order_id',
        'store_id',
        'area_id',
        'order_type',
        'delivery_type',
        'shipping_type',
        'order_amount',
        'coupon_discount_amount_admin',
        'product_discount_amount',
        'flash_discount_amount_admin',   
        'shipping_charge',
        'additional_charge_name',
        'additional_charge',
        'is_reviewed',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'package_id');
    }
}
