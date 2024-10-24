<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class ComMerchant extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'com_stores';

    protected $guarded = [];

    public function area()
    {
        return $this->belongsTo(ComAreas::class,'area_id');
    }

    public function merchant()
    {
        return $this->belongsTo(ComMerchant::class,'merchant_id');
    }

}
