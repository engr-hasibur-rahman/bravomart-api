<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Chat\app\Models\ChatMessage;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    // The channel to broadcast on
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    // The event name
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    // The data to send with the event
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'sender_id' => $this->message->sender_id,
            'sender_type' => $this->message->sender_type,
            'receiver_id' => $this->message->receiver_id,
            'receiver_type' => $this->message->receiver_type,
            'message' => $this->message->message,
            'file' => $this->message->file,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
