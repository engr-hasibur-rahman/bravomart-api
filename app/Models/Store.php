<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use Modules\Subscription\app\Models\StoreSubscription;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'stores';
    protected $guarded = [];
    protected $fillable = [
        'area_id',
        'store_seller_id',
        'store_type',
        'name',
        'slug',
        'phone',
        'email',
        'logo',
        'banner',
        'address',
        'latitude',
        'longitude',
        'is_featured',
        'opening_time',
        'closing_time',
        'tax',
        'tax_number',
        'subscription_type',
        'admin_commission_type',
        'admin_commission_amount',
        'delivery_charge',
        'delivery_time',
        'delivery_self_system',
        'delivery_take_away',
        'order_minimum',
        'veg_status',
        'off_day',
        'enable_saling',
        'meta_title',
        'meta_description',
        'meta_image',
        'status',
        'created_by',
        'updated_by',
    ];
    public $translationKeys = [
        'name',
        'slug',
        'address',
        'meta_title',
        'meta_description',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function area()
    {
        return $this->belongsTo(StoreArea::class, 'area_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'store_seller_id');
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(StoreSubscription::class, 'store_id', 'id');
    }

    public function activeSubscription()
    {
        return $this->hasOne(StoreSubscription::class, 'store_id', 'id')
            ->where('status', 1)
            ->latest(); // Ensure the latest subscription is retrieved
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }


    public function scopePendingStores($query)
    {
        return $query->where('status', 0);
    }

    public function getRatingAttribute(): float
    {
        $average = Review::where('store_id', $this->id)
            ->where('reviewable_type', Product::class)
            ->where('status', 'approved')
            ->avg('rating');

        // Clamp between 1 and 5
        $clamped = max(1, min(5, round($average ?? 0, 2)));

        return $clamped;
    }
}
