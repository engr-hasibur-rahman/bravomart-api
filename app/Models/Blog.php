<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Blog extends Model
{
    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'views',
        'visibility',
        'status',
        'schedule_date',
        'tag_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'author',
    ];
    public $translationKeys = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
    protected $casts = [
        'schedule_date' => 'datetime',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
