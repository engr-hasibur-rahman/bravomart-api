<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BecomeSellerSetting extends Model
{
    protected $table = 'become_seller_settings';

    protected $fillable = ['content', 'status'];

    protected $casts = [
        'content' => 'array',
    ];
}
