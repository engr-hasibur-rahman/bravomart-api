<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuery extends Model
{
    protected $fillable = [
        "product_id",
        "customer_id",
        "question",
        "seller_id",
        "reply",
        "replied_at",
        "status",
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
