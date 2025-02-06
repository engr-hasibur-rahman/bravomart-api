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
}
