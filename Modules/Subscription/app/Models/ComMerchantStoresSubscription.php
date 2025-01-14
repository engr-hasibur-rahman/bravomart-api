<?php

namespace Modules\Subscription\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComMerchantStoresSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'subscription_id',
        'name',
        'validity',
        'price',
        'pos_system',
        'self_delivery',
        'mobile_app',
        'live_chat',
        'order_limit',
        'product_limit',
        'product_featured_limit',
        'payment_gateway',
        'payment_status',
        'transaction_id',
        'manual_image',
        'expire_date',
        'status',
    ];
}