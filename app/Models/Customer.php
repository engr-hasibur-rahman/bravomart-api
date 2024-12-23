<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

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
        'status',
        'def_lang',
        'password_changed_at',
        'email_verify_token',
        'email_verified',
        'email_verified_at',
    ];
    protected $guard_name = 'api';
    protected $hidden = [
        'password',
    ];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
