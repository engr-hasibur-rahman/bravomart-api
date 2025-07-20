<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'page_type',
        'layout',
        'page_class',
        'enable_builder',
        'show_breadcrumb',
        'page_parent',
        'page_order',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];
    public $translationKeys = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];


    protected $casts = [
        'content' => 'array',
    ];

    public function parsedContent()
    {
        // If it's valid JSON, return decoded
        $decoded = json_decode($this->content, true);

        return json_last_error() === JSON_ERROR_NONE
            ? $decoded
            : html_entity_decode($this->content);
    }


    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
