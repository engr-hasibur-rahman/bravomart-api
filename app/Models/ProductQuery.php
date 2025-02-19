<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuery extends Model
{
    protected $fillable = [
        "product_id",
        "customer_id",
        "question",
        "store_id",
        "reply",
        "replied_at",
        "status",
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, "store_id");
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
