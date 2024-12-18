<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class ComStore extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'com_stores';
    protected $guarded = [];
    protected $fillable = [
        'area_id',
        'merchant_id',
        'store_type',
        'name',
        'slug',
        'phone',
        'email',
        'logo',
        'banner',
        'address',
        'latitude',
        'longitude',
        'vat_tax_number',
        'is_featured',
        'opening_time',
        'closing_time',
        'subscription_type',
        'package_id',
        'admin_commi_percent',
        'admin_commi_amount',
        'delivery_charge',
        'delivery_time',
        'delivery_self_system',
        'delivery_take_away',
        'order_minimum',
        'veg_status',
        'off_day',
        'enable_saling',
        'meta_title',
        'meta_description',
        'meta_image',
        'status',
        'created_by',
        'updated_by',
    ];
    public $translationKeys = [
        'name',
        'slug',
        'address',
        'meta_title',
        'meta_description',
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
    public function area()
    {
        return $this->belongsTo(ComArea::class, 'area_id');
    }
    public function merchant()
    {
        return $this->belongsTo(ComMerchant::class, 'merchant_id');
    }
    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
