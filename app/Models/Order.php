<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_master_id',
        'store_id',
        'area_id',
        'invoice_number',
        'invoice_date',
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
        'is_reviewed',
        'confirmed_by',
        'confirmed_at',
        'cancel_request_by',
        'cancel_request_at',
        'cancelled_by',
        'cancelled_at',
        'delivery_completed_at',
        'refund_status',
        'status',
    ];

    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'order_master_id', 'id');
    }


    // This function generates invoice when the order is created
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->invoice_number = 'INV-' . now()->year . '-' . time() . '-' . rand(1000, 9999);
            $order->invoice_date = now();
        });
    }


    // Order -> OrderMaster -> OrderDetails (Nested Relationship)
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class, 'order_master_id', 'order_id', 'id', 'id');
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

    public function deliveryman()
    {
        return $this->belongsTo(User::class, 'confirmed_by', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

}
