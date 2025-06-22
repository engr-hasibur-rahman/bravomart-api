<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use Modules\Subscription\app\Models\StoreSubscription;
use Modules\Subscription\app\Models\SubscriptionHistory;

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
        'online_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'online_at' => 'datetime',
    ];

    public $translationKeys = [
        'name',
        'slug',
        'address',
        'meta_title',
        'meta_description',
    ];


// Only fetch those stores which have subscription_type commission and if subscription then within the order limit for frontend
    public function scopeValidForCustomerView($query)
    {
        return $query->where(function ($q) {
            $q->where('subscription_type', 'commission')
                ->orWhere(function ($q2) {
                    $q2->where('subscription_type', 'subscription')
                        ->whereHas('subscriptions', function ($subQuery) {
                            $subQuery->where('status', 1)
                                ->whereDate('expire_date', '>=', now())
                                ->where('order_limit', '>', 0);
                        });
                });
        });
    }


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


    public function subscriptionHistories()
    {
        return $this->hasMany(SubscriptionHistory::class, 'store_id', 'id');
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

        if (is_null($average)) {
            return 0; // No reviews
        }

        // Clamp between 1 and 5 only if there's an actual rating
        return max(1, min(5, round($average, 2)));
    }

    public function getValidSubscriptionByFeatureLimits(array $requiredLimits): ?array
    {
        $subscriptions = $this->subscriptions()
            ->whereDate('expire_date', '>=', now())  // Only non-expired subscriptions
            ->where('status', 1)                     // Only active ones
            ->orderBy('expire_date')                 // Soonest to expire first
            ->get();

        foreach ($subscriptions as $subscription) {
            $isValid = true;

            foreach ($requiredLimits as $key => $requiredValue) {
                $subscriptionValue = $subscription->$key;

                // If it's a boolean feature (like pos_system, self_delivery, etc.)
                if (in_array($key, ['pos_system', 'self_delivery', 'mobile_app', 'live_chat'])) {
                    if (!$subscriptionValue) {
                        $isValid = false;
                        break;
                    }
                }

                // If it's a numeric limit (like order_limit, product_limit, etc.)
                if (in_array($key, ['order_limit', 'product_limit', 'product_featured_limit'])) {
                    if ($requiredValue > $subscriptionValue) {
                        $isValid = false;
                        break;
                    }
                }
            }

            if ($isValid) {
                return [
                    'subscription_id' => $subscription->id,
                    'matched_features' => $subscription->only(array_keys($requiredLimits)),
                ];
            }
        }

        return null; // No matching subscription found
    }

}
