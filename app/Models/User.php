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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // In your User model, use the $casts property directly
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'stores' => 'array',  // Ensures stores is cast to an array
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

    /**
     * Get roles for the user.
     */
    //    public function roles()
    //    {
    //        return $this->belongsToMany(CustomRole::class, 'model_has_roles', 'model_id', 'role_id')
    //            ->where(function ($query) {
    //                $query->where('model_type', self::class)->orWhereNull('model_type');
    //            });
    //    }

    /**
     * Get permissions directly assigned to the user.
     */
    public function directPermissions()
    {
        return $this->belongsToMany(CustomPermission::class, 'model_has_permissions', 'model_id', 'permission_id')
            ->where('model_type', self::class);
    }

    /**
     * Get permissions via roles.
     */
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

    /**
     * Get all permissions for the user (direct + via roles).
     */
    public function allPermissions()
    {
        $directPermissions = $this->directPermissions()->pluck('name');
        $rolePermissions = $this->rolePermissions()->pluck('name');

        return $directPermissions->merge($rolePermissions)->unique();
    }

    /* Get linked social accounts */
    public function linkedSocialAccounts()
    {
        return $this->hasOne(LinkedSocialAccount::class);
    }

    public function deliveryman()
    {
        return $this->hasOne(Deliveryman::class, 'user_id');
    }
}
