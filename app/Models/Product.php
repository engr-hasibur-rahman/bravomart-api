<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "products";
    protected $fillable = [
        "shop_id",
        "category_id",
        "brand_id",
        "unit_id",
        "attribute_id",
        "tag_id",
        "type",
        "behaviour",
        "name",
        "slug",
        "description",
        "image",
        "gallery_images",
        "warranty",
        "return_in_days",
        "return_text",
        "allow_change_in_mind",
        "cash_on_delivery",
        "delivery_time_min",
        "delivery_time_max",
        "delivery_time_text",
        "max_cart_qty",
        "order_count",
        "attributes",
        "views",
        "status",
        "available_time_starts",
        "available_time_ends",
    ];
    public $translationKeys = [
        'name',
        'description'
    ];
    public function category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, "product_id");
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class, "tag_id");
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, "unit_id");
    }
    public function shop()
    {
        return $this->belongsTo(ComStore::class, "shop_id");
    }
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, "attribute_id");
    }
}
