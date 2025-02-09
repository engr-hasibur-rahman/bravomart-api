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
        'order_amount_store_value',
        'order_amount_admin_commission',
        'coupon_discount_amount_admin',
        'product_discount_amount',
        'flash_discount_amount_admin',   
        'shipping_charge',
        'delivery_charge_admin',
        'delivery_charge_admin_commission',
        'additional_charge_name',
        'additional_charge',
        'additional_charge_commission',
        'is_reviewed',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_package_id');
    }

    public function orderPackage()
    {
        return $this->belongsTo(OrderPackage::class, 'package_id');
    }
}
