<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'store_id',
        'area_id',
        'order_package_id',
        'product_id',
        'behaviour',
        'product_sku',
        'variant_details',
        'base_price',
        'product_campaign_id',
        'store_discount_type',
        'store_discount_rate',
        'store_discount_amount',
        'admin_discount_type',
        'admin_discount_rate',
        'admin_discount_amount',
        'price',
        'quantity',
        'line_total_excluding_tax',
        'tax_rate',
        'tax_amount',
        'total_tax_amount',
        'line_total_price',
        'admin_commission_type',
        'admin_commission_rate',
        'admin_commission_amount',
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
