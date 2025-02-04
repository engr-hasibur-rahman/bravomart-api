<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    protected $guarded = ['type'];
    protected $fillable = [
        'name',
        'image',
        'description',
        'total_stores',
        'status'
    ];
    public $translationKeys = [
        'name',
        'description',
    ];

    public function settings()
    {
        return $this->hasMany(StoreAreaSetting::class, 'com_store_type_id');
    }

    public function rangeCharges()
    {
        return $this->hasMany(StoreAreaRangeCharge::class, 'com_store_type_id');
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
