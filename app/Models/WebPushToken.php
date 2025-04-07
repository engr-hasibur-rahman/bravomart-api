<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NotificationChannels\WebPush\PushSubscription;

class WebPushToken extends Model
{
    protected $fillable = ['user_id', 'token', 'endpoint', 'key','content_encoding'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toPushSubscription()
    {
        // Create an array with the required keys for PushSubscription
        return new PushSubscription([
            'endpoint' => $this->endpoint,
            'key' => $this->key,
            'token' => $this->token,
        ]);
    }
}
