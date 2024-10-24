<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class ComMerchant extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'com_merchant';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
