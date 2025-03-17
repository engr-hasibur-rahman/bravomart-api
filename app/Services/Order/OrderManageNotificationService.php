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
    public function createOrderNotification($last_order_ids, $otherCheckData = null)
    {
        if (empty($last_order_ids)) {
            return;
        }

        // Order with relationship data get
        if (!is_array($last_order_ids)) {
            $order_ids_convert_to_array = collect($last_order_ids)->toArray();
        } else {
            $order_ids_convert_to_array = $last_order_ids;
        }

        $orders = Order::with('orderMaster.customer', 'orderMaster.orderAddress', 'store.seller', 'deliveryman')
            ->whereIn('id' ,$order_ids_convert_to_array)
            ->get();

        // if order not found
        if ($orders->count() === 0) {
            return;
        }

        // check others data
        $other_check = false;
        if (!empty($otherCheckData) && $otherCheckData == 'new-order'){
            $other_check = true;
        }

        foreach ($orders as $order_details) {
            $last_order_id = $order_details->id;
            // Notification Data
            $messages = getOrderStatusMessage($order_details, $other_check);
            $data = ['order_id' => $order_details->id];
            // create notification for every one
            $this->notifyAdmin($messages['title'], $messages['admin'], $data);
            $this->notifyStore($order_details, $messages['title'], $messages['store'], $data);
            $this->notifyCustomer($order_details, $messages['title'], $messages['customer'], $data);
            $this->notifyDeliveryman($order_details, $messages['title'], $messages['deliveryman'], $data);

            // Customer notification
            $this->sendOrderNotification(
                $order_details->orderMaster?->customer,
                'customer_id',
                $order_details->orderMaster?->customer_id ?? 0,
                $last_order_id,
                $messages['title'],
                $messages['customer']
            );

            // Seller notification
            $this->sendOrderNotification(
                $order_details->store?->seller,
                'seller_id',
                $order_details->store?->store_seller_id ?? 0,
                $last_order_id,
                $messages['title'],
                $messages['store']
            );

            // Deliveryman notification
            $this->sendOrderNotification(
                $order_details->deliveryman,
                'deliveryman_id',
                $order_details->deliveryman?->id ?? 0,
                $last_order_id,
                $messages['title'],
                $messages['deliveryman']
            );
        }


    }

    private function sendOrderNotification($recipient, $idKey, $idValue, $orderId, $title, $body)
    {
        if (empty($recipient)) {
            return;
        }

        $token = is_array($recipient->firebase_token) ? $recipient->firebase_token : [$recipient->firebase_token];
        $token = ['eVpGQEQwSaKsP6Pi1SoJ-I:APA91bF4TbvmI5CsFP2cuztDIe0-na7ryFkaSganZ9iod1PJdUdsPY1G7S9Z6wm_tsB76mzYTVqRv4FXL1qcbq49w0ZPYGDYIvd8uwY5L52gwDMz4yBTzN4'];

        // empty check
        $token = array_filter($token);
        if (!empty($token)) {
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

            // Send notification
            $this->sendFirebaseNotification($token, $title, $body, $notification_data);
            
        }
    }


    // Notify Admins
    protected function notifyAdmin($title, $message, $data)
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->first();

        if ($admin) {
            $this->sendNotification($admin->id, 'admin', $title, $message, $data);
        }
    }
    // Notify Store Owner
    protected function notifyStore($order_details, $title, $message, $data)
    {
        if ($order_details->store) {
            $this->sendNotification($order_details->store?->seller?->id, 'store', $title, $message, $data);
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
        if ($order_details->deliveryman && !empty($order_details->deliveryman)) {
            $this->sendNotification($order_details->deliveryman->id, 'deliveryman', $title, $message, $data);
        }
    }

    // Send and Store Notification
    protected function sendNotification($user_id, $notifiable_type, $title, $message, $data)
    {
        // Store notification in database
        UniversalNotification::create([
            'notifiable_id'  => $user_id,
            'title'          => $title,
            'message'        => $message,
            'data'           => json_encode($data),
            'notifiable_type' => $notifiable_type,
            'status'         => 'unread',
        ]);
    }


    public function sendFirebaseNotification(array $firebaseTokens, $title, $body, $data)
    {

        try {
            // Check if the third parameter (image URL) is being passed as an array.
            $imageUrl = isset($data['imageUrl']) && is_string($data['imageUrl']) ? $data['imageUrl'] : null;
            // Path to the Firebase credentials JSON file
            $credentialsPath = storage_path('app/firebase/firebase.json');
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
