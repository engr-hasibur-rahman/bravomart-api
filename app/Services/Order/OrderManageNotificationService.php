<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\UniversalNotification;
use App\Models\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderManageNotificationService
{
    public function createOrderNotification($last_order_id)
    {
        // Order with relationship data get
        $order_details = Order::with('orderMaster.customer', 'orderMaster.orderAddress', 'store.seller', 'deliveryman')
            ->find($last_order_id);

        // if order not found
        if (!$order_details) {
            return;
        }

        // Notification Data
        $title = 'New Order Update';
        $message = 'You have a new update for Order #' . $order_details->id;
        $data = ['order_id' => $order_details->id];

        // create notification for every one
        $this->notifyAdmin($title, $message, $data);
        $this->notifyStore($order_details, $title, $message, $data);
        $this->notifyCustomer($order_details, $title, $message, $data);
        $this->notifyDeliveryman($order_details, $title, $message, $data);

        // Customer notification
        $this->sendOrderNotification(
            $order_details->orderMaster?->customer,
            'customer_id',
            $order_details->orderMaster?->customer_id ?? 0,
            $last_order_id,
            __('Order Placed Successfully'),
            __('Your order ID: # :id has been placed successfully.', ['id' => $last_order_id])
        );

        // Seller notification
        $this->sendOrderNotification(
            $order_details->store?->seller,
            'seller_id',
            $order_details->store?->store_seller_id ?? 0,
            $last_order_id,
            __('New Order Received'),
            __('You have received a new order. Order ID: # :id.', ['id' => $last_order_id])
        );

        // Deliveryman notification
        $this->sendOrderNotification(
            $order_details->deliveryman,
            'deliveryman_id',
            $order_details->deliveryman?->id ?? 0,
            $last_order_id,
            __('New Delivery Assigned'),
            __('A new delivery has been assigned. Order ID: # :id.', ['id' => $last_order_id])
        );

    }

    private function sendOrderNotification($recipient, $idKey, $idValue, $orderId, $title, $body)
    {
        if (empty($recipient)) {
            return;
        }
        $token = is_array($recipient->firebase_token) ? $recipient->firebase_token : [$recipient->firebase_token];
        $notification_data = [
            "title" => $title,
            "detailed_title" => "-",
            "order_id" => $orderId,
            $idKey => $idValue,
            "body" => $body,
            "description" => "-",
            "type" => "order",
            "sound" => "default",
            "screen" => "-"
        ];
        $this->sendFirebaseNotification($token, $title, $body, $notification_data);
    }


    // Notify Admins
    protected function notifyAdmin($title, $message, $data)
    {
        $admins = User::where('activity_scope', 'system_level')->get();

        foreach ($admins as $admin) {
            $this->sendNotification($admin->id, 'admin', $title, $message, $data);
        }
    }
    // Notify Store Owner
    protected function notifyStore($order_details, $title, $message, $data)
    {
        if ($order_details->store) {
            $this->sendNotification($order_details->store->owner_id, 'store', $title, $message, $data);
        }
    }

    // Notify Customer
    protected function notifyCustomer($order_details, $title, $message, $data)
    {
        if ($order_details->orderMaster && $order_details->orderMaster->customer) {
            $this->sendNotification($order_details->orderMaster->customer->id, 'customer', $title, $message, $data);
        }
    }

    // Notify Deliveryman
    protected function notifyDeliveryman($order_details, $title, $message, $data)
    {
        if ($order_details->deliveryman) {
            $this->sendNotification($order_details->deliveryman->id, 'deliveryman', $title, $message, $data);
        }
    }


    public function sendFirebaseNotification(array $firebaseTokens, $title, $body, $data)
    {

        try {
            // Check if the third parameter (image URL) is being passed as an array.
            $imageUrl = isset($data['imageUrl']) && is_string($data['imageUrl']) ? $data['imageUrl'] : null;
            // Path to the Firebase credentials JSON file
            $credentialsPath = storage_path('app/firebase/firebase_credentials.json');
            // Load the credentials from the JSON file
            $jsonCredentials = file_get_contents($credentialsPath);
            $credentials = json_decode($jsonCredentials, true);
            // Convert to JSON
            $jsonCredentials = json_encode($credentials);
            // Initialize Firebase Admin SDK
            $factory = (new Factory)->withServiceAccount($jsonCredentials);
            $messaging = $factory->createMessaging();
            // Create the Notification object
            $notification = Notification::create($title, $body, $imageUrl);
            // Process the data to ensure all values are scalar
            $processedData = [];
            foreach ($data as $key => $value) {
                // Convert array values to JSON, otherwise cast to string
                if (is_array($value)) {
                    // Ensure only top-level arrays are converted to JSON
                    $processedData[$key] = json_encode($value); // Convert array to JSON string
                } else {
                    $processedData[$key] = (string)$value; // Ensure it's a string
                }
            }

            // Prepare the data array without nested arrays
            $dataToSend = array_merge(
                [
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'notification' => json_encode([
                        'title' => $title,
                        'body' => $body,
                    ]),
                ],
                $processedData
            );

            // Construct the CloudMessage with notification and data payloads
            $message = CloudMessage::new()->withData($dataToSend);
            // Send the notification to multiple tokens
            $messaging->sendMulticast($message, $firebaseTokens);

        }catch (\Exception $exception){}
    }
}
