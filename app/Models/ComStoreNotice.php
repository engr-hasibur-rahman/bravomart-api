<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComStoreNotice extends Model
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

    public function recipients()
    {
        return $this->hasMany(ComStoreNoticeRecipient::class, 'notice_id');
    }
}
