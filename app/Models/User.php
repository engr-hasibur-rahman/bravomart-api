<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Contracts\Role as RoleContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $appends = ['rating'];
    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'phone',
        'email',
        'image',
        'activity_scope',
        'password',
        'store_owner',
        'store_seller_id',
        'stores',
        'status',
        'google_id',
        'facebook_id',
        'apple_id',
        'def_lang'
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
    ];

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
        return $this->morphMany(Review::class,'reviewable');
    }
    public function getRatingAttribute()
    {
        $averageRating = $this->reviews()
            ->where('reviewable_type', User::class)
            ->where('status', 'approved')
            ->avg('rating');
        return $averageRating;
    }

}
