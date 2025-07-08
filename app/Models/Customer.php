<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Chat\app\Models\Chat;
use Modules\Chat\app\Models\ChatMessage;

//class Customer extends Model
class Customer extends Authenticatable // Extend Authenticatable instead of Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'image',
        'birth_day',
        'gender',
        'verified',
        'verify_method',
        'marketing_email',
        'marketing_sms',
        'firebase_token',
        'fcm_token',
        'google_id',
        'facebook_id',
        'apple_id',
        'status',
        'online_at',
        'def_lang',
        'password_changed_at',
        'email_verify_token',
        'email_verified',
        'email_verified_at',
        'deactivated_at'
    ];


    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function isActive(): bool
    {
        return $this->status === 1 && $this->deleted_at === null;
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', 1)->whereNull('deleted_at');
    }

    public function isDeactivated(): bool
    {
        return $this->status === 0;
    }

    public function isSuspended(): bool
    {
        return $this->status === 2;
    }

    public function deleteAccount(): bool
    {
        return $this->delete();
    }

    public function forceDeleteAccount(): bool
    {
        return $this->forceDelete();
    }

    public function restoreAccount(): bool
    {
        return $this->restore();
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function defaultAddress()
    {
        return $this->hasOne(CustomerAddress::class)->where('is_default', 1);
    }

    public function chats()
    {
        return $this->morphMany(Chat::class, 'user');
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

}
