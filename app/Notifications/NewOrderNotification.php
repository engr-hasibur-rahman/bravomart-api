<?php

namespace App\Notifications;

use App\Models\UniversalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        Log::info('Via WebPushChannel');
        return [WebPushChannel::class]; // Using the WebPushChannel to send web push
    }

    public function toWebPush($notifiable, $notification)
    {
        Log::info('Sending Web Push Notification final done');
        return (new WebPushMessage)
            ->title('New Order Placed')
            ->icon('/order-icon.png') // Set the icon for the notification
            ->body('A new order has been placed with the order number: ' . $this->data['shipping_address_id']) // Body content
            ->action('View Order', 'view_order') // Action button in the notification
            ->options(['TTL' => 1000, 'content_encoding' => 'aes128gcm']); // Set other options such as TTL
    }

}
