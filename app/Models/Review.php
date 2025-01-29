<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        "order_id",
        "store_id",
        "reviewable_id",
        "reviewable_type",
        "customer_id",
        "review",
        "rating",
        "status",
        "like_count",
        "dislike_count",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(ComMerchantStore::class, 'store_id');
    }

}
