<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreNotice extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'active_date',
        'expire_date',
        'priority',
        'status',
    ];
    public $translationKeys = [
        'title',
        'message',
    ];

    public function recipients()
    {
        return $this->hasMany(StoreNoticeRecipient::class, 'notice_id');
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
