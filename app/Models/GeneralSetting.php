<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';

    protected $fillable = ['content', 'type', 'status'];

    protected $casts = [
        'content' => 'array',
    ];
    public $translationKeys = [
        'content',
    ];

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
