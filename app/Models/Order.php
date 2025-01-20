<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'shipping_address_id',
        'shipping_time_preferred',
        'delivery_status',
        'payment_type',
        'payment_status',
        'order_notes',
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
        'confirmed_at',
        'cancel_request_at',
        'cancelled_at',
        'delivery_completed_at',
        'refund_status',
    ];

    public function orderPackages()
    {
        return $this->hasMany(OrderPackage::class, 'order_id', 'id');
    }
}
