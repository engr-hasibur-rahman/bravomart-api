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
    // everytime checks the count of stores of the type when data fetching
    protected static function booted()
    {
        static::retrieved(function ($storeType) {
            $count = Store::where('store_type', $storeType->type)->count();

            if ($storeType->total_stores !== $count) {
                $storeType->updateQuietly(['total_stores' => $count]);
            }
        });
    }
    public function areaDetails()
    {
        return $this->belongsToMany(StoreAreaSetting::class, 'store_area_setting_store_types', 'store_type_id', 'store_area_setting_id')
            ->with(['rangeCharges']);
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
