<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'shipping_address_id',
        'payment_gateway',
        'payment_status',
        'order_notes',
        'order_amount',
        'coupon_code',
        'coupon_title',
        'coupon_discount_amount_admin',
        'product_discount_amount',
        'flash_discount_amount_admin',
        'shipping_charge',
        'additional_charge_title',
        'additional_charge_amount',
        'confirmed_by',
        'confirmed_at',
        'invoice_number',
        'invoice_date',
        'cancel_request_by',
        'cancel_request_at',
        'cancelled_by',
        'cancelled_at',
        'delivery_completed_at',
        'refund_status',
        'status',
    ];

    // This function generates invoice when the order is created
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->invoice_number = 'INV-' . now()->year . '-' . time();
            $order->invoice_date = now();
        });
    }

    public function orderPackages()
    {
        return $this->hasMany(OrderPackage::class, 'order_id', 'id');
    }

    // Order -> OrderPackage -> OrderDetails (Nested Relationship)
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, OrderPackage::class, 'order_id', 'order_package_id', 'id', 'id');
    }


    // Order -> OrderPayment (One-to-One relationship)
    public function orderPayment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id', 'id');
    }

    public function orderDeliveryHistory()
    {
        return $this->hasMany(OrderDeliveryHistory::class, 'order_id', 'id');
    }
}
