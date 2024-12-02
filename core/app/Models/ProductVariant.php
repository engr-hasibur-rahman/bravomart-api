<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_id",
        "variant_slug",
        "sku",
        "pack_quantity",
        "weight_major",
        "weight_gross",
        "weight_net",
        "variant_image",
        "variant_order_count",
        "status",
    ] ;
    public function product(){
        return $this->belongsTo(Product::class,"product_id");
    }
}
