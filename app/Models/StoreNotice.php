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

    public function recipients()
    {
        return $this->hasMany(StoreNoticeRecipient::class, 'notice_id');
    }
}
