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
        "store_id",
        "category_id",
        "brand_id",
        "unit_id",
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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, "product_id");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, "unit_id");
    }

    public function store()
    {
        return $this->belongsTo(ComMerchantStore::class, "store_id");
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
