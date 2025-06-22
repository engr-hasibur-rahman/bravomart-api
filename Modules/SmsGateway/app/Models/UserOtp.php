<?php

namespace Modules\SmsGateway\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\SmsGateway\Database\Factories\UserOtpFactory;

class UserOtp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = 'user_otps';
    protected $fillable = [
        'user_id',
        'user_type',
        'otp_code',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->morphTo();
    }


}
