<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'store_id',
        'area_id',
        'package_id',
        'product_id',
        'product_sku',
        'product_details',
        'variant_details',
        'add_ons',
        'rate_bef_discount',
        'product_campaign_id',
        'discount_type',
        'discount_store_percent',
        'discount_admin_percent',
        'discount_store_amount',
        'discount_admin_amount',
        'rate',
        'quantity',
        'total_add_on_value',
        'tax_percent',
        'tax_amount',
        'line_total',
    ];

    public function order_package()
    {
        return $this->belongsTo(OrderPackage::class, 'package_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
