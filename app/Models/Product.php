<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['wishlist', 'rating', 'review_count','reviews'];
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
        "views",
        "meta_title",
        "meta_description",
        "meta_keywords",
        "meta_image",
        "status",
        "available_time_starts",
        "available_time_ends",
        "manufacture_date",
        "expiry_date"
    ];
    public $translationKeys = [
        'name',
        'description',
        "meta_title",
        "meta_description",
        "meta_keywords",
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

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, "product_id");
    }

    public function relatedProductsWithCategoryFallback($limit = 10)
    {
        $category = $this->category; // Current product's category
        if (!$category) {
            return $this->getFallbackProducts($limit); // Fallback if no category is assigned
        }
        while ($category) {
            // Get all child categories, including the current category
            $categoryIds = $category->childrenRecursive()->pluck('id')->toArray();
            $categoryIds[] = $category->id;
            // Fetch related products
            $relatedProducts = Product::query()
                ->where('id', '!=', $this->id) // Exclude the current product
                ->where('status', 'approved') // Filter by approved status
                ->whereIn('category_id', $categoryIds) // Filter by category and its children
                ->limit($limit)
                ->get();
            // If products are found, return them
            if ($relatedProducts->isNotEmpty()) {
                return $relatedProducts;
            }
            // Move to the parent category
            $category = $category->parent;
        }
        // No related products found, return fallback products
        return $this->getFallbackProducts($limit);
    }

    protected function getFallbackProducts($limit = 10)
    {
        return Product::query()
            ->where('id', '!=', $this->id) // Exclude the current product
            ->where('status', 'approved') // Filter by approved status
            ->latest() // Example fallback logic: most popular products
            ->limit($limit)
            ->get();
    }

    public function scopeWithTrendingScore($query)
    {
        return $query->selectRaw("
        *,
        (0.50 * order_count) + (0.30 * views) + (0.20 * (
            SELECT COUNT(*) 
            FROM wishlists 
            WHERE wishlists.product_id = products.id
        )) as trending_score
    ");
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->whereHas('variants', function ($variantQuery) use ($threshold) {
            $variantQuery->where('stock_quantity', '>', 0) // Ensure it's not out of stock
            ->where('stock_quantity', '<', $threshold); // Check low stock condition
        });
    }

    public function scopeOutOfStock($query)
    {
        return $query->whereHas('variants', function ($variantQuery) {
            $variantQuery->where('stock_quantity', '=', 0); // Check out of stock condition
        });
    }

    public function lowStockVariants($threshold = 10)
    {
        return $this->variants()->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<', $threshold)
            ->get();
    }

    // Get out of stock variants
    public function outOfStockVariants()
    {
        return $this->variants()->where('stock_quantity', '=', 0)->get();
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
        return $this->belongsTo(Store::class, "store_id");
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, "product_id");
    }

    public function isInWishlist(): bool
    {
        if (!auth('api_customer')->check()) {
            return false;
        }

        $customerId = auth('api_customer')->user()->id;
        return $this->wishlists()->where('customer_id', $customerId)->exists();
    }

    public function getWishlistAttribute(): bool
    {
        return $this->isInWishlist();
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }


    //  FlashSaleProduct
    public function flashSale()
    {
        return $this->hasOneThrough(
            FlashSale::class,
            FlashSaleProduct::class,
            'product_id',
            'id',
            'id',
            'flash_sale_id'
        );
    }

    public function flashSaleProduct()
    {
        return $this->hasOne(FlashSaleProduct::class, 'product_id');
    }

    public function getRatingAttribute()
    {
        $averageRating = $this->reviews()
            ->where('reviewable_type', Product::class)
            ->where('status', 'approved')
            ->avg('rating');
        return $averageRating;
    }

    // Get the total count of reviews for the product
    public function getReviewCountAttribute()
    {
        return $this->reviews()
            ->where('reviewable_type', Product::class)
            ->where('status', 'approved')
            ->count();
    }
    public function getReviewsAttribute()
    {
        return $this->reviews()->with(['customer','reviewReactions'])
            ->where('reviewable_type', Product::class)
            ->where('status', 'approved')
            ->get();
    }


}
