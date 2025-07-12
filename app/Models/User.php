<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\ChatMessage;
use Modules\Wallet\app\Models\Wallet;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $appends = ['rating', 'review_count'];
    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'phone',
        'email',
        'image',
        'activity_scope',
        'password',
        'password_changed_at',
        'email_verify_token',
        'store_owner',
        'store_seller_id',
        'stores',
        'status',
        'google_id',
        'facebook_id',
        'apple_id',
        'def_lang',
        'deactivated_at',
        'firebase_token',
        'fcm_token',
        'online_at',
        'is_available'
    ];
    protected $guard_name = 'api';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'stores' => 'array',
        'online_at' => 'datetime',
        'is_available' => 'boolean',
    ];


    public function routeNotificationForWebPush($notification)
    {
        // Assuming the user has many WebPushTokens, find the active one (you may adjust this logic)
        $subscription = $this->pushSubscriptions()->first();

        if ($subscription) {
            // Convert to PushSubscription object
            return $subscription->toPushSubscription();
        }

        return null; // No subscription found
    }

    public function updatePushSubscription($endpoint, $key = null, $token = null, $contentEncoding = null)
    {
        $this->pushSubscriptions()->updateOrCreate(
            ['endpoint' => $endpoint], // Ensure the endpoint is passed here
            ['key' => $key, 'token' => $token, 'content_encoding' => 'aes128gcm']
        );
    }


    public function pushSubscriptions()
    {
        return $this->hasMany(WebPushToken::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function scopeIsSeller($query)
    {
        return $query->where('store_owner', true);
    }

    public function isDeliveryman()
    {
        return $this->activity_scope === 'delivery_level';
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function directPermissions()
    {
        return $this->belongsToMany(CustomPermission::class, 'model_has_permissions', 'model_id', 'permission_id')
            ->where('model_type', self::class);
    }

    public function rolePermissionsQuery()
    {
        return CustomPermission::whereHas('roles', function ($query) {
            $query->whereIn('id', $this->roles()->pluck('id'));
        });
    }

    public function rolePermissions()
    {
        return $this->rolePermissionsQuery()->get();
    }

    public function allPermissions()
    {
        $directPermissions = $this->directPermissions()->pluck('name');
        $rolePermissions = $this->rolePermissions()->pluck('name');

        return $directPermissions->merge($rolePermissions)->unique();
    }

    public function linkedSocialAccounts()
    {
        return $this->hasOne(LinkedSocialAccount::class);
    }

    public function deliveryman()
    {
        return $this->hasOne(DeliveryMan::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function getRatingAttribute()
    {
        $averageRating = $this->reviews()
            ->where('reviewable_type', User::class)
            ->where('status', 'approved')
            ->avg('rating');
        return $averageRating;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()
            ->where('reviewable_type', User::class)
            ->where('status', 'approved')
            ->count();
    }

    public function getLockedAttribute()
    {
        return $this->roles->where('locked', 1)->isNotEmpty();
    }

    public function getIsOnlineAttribute(): bool
    {
        if (!$this->online_at) return false;

        return $this->online_at->gt(now()->subMinutes(5)); // 5-minute window
    }

    public function chats()
    {
        return $this->morphMany(Chat::class, 'user', 'user_type', 'user_id');
    }

    public function sentMessages()
    {
        return $this->morphMany(ChatMessage::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->morphMany(ChatMessage::class, 'receiver');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'fileable', 'user_type', 'user_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'store_seller_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'created_by', 'id');
    }

    public function authors()
    {
        return $this->hasMany(ProductAuthor::class, 'created_by', 'id');
    }

}
