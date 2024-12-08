<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComStore extends Model
{
    use HasFactory;

    protected $table = 'com_stores';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'code',
        'coordinates',
    ];

    public $translationKeys = [
        'name'
    ];



    public function area()
    {
        return $this->belongsTo(ComArea::class,'area_id');
    }

    public function merchant()
    {
        return $this->belongsTo(ComMerchant::class,'merchant_id');
    }
}
