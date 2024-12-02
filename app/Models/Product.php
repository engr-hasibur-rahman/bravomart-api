<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "shop_id",
        "category_id",
        "brand_id",
        "unit_id",
        "attribute_id",
        "type",
        "behaviour",
        "name",
        "description",
        "warranty",
        "return_in_dsays",
        "return_text",
        "allow_change_in_mind",
        "cash_on_delivery",
        "delivery_time_min",
        "delivery_time_max",
        "delivery_time_text",
        "tags",
        "thumb_image",
        "full_image",
        "slug",
        "max_cart_qty",
        "order_count",
        "attributes",
        "views",
        "status",
        "available_time_starts",
        "available_time_ends",
    ] ;
    public function variant(){
        return $this->hasMany(ProductVariant::class,"product_id");
    }
}
