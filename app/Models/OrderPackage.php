<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    protected $fillable = [
        'order_id',
        'store_id',
        'area_id',
        'shipping_type',
        'order_amount',
        'coupon_code',
        'coupon_title',
        'coupon_disc_amt_admin',
        'coupon_disc_amt_store',
        'product_disc_amt',
        'flash_disc_amt_admin',
        'flash_disc_amt_store',
        'shipping_charge',
        'additional_charge',
        'is_reviewed',
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
