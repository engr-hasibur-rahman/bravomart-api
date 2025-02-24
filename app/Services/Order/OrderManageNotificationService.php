<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Service;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderManageNotificationService
{
    public function createOrderNotification($last_order_id)
    {
        // Order with relationship data get
        $order_details = Order::with('orderMaster.customer', 'orderMaster.orderAddress', 'store', 'deliveryman')->find($last_order_id);

        // if order not found
        if (!$order_details) {
            return;
        }

        // admin for order notification
        try {
            admin_notification($last_order_id, $order_details->user_id, 'order', __('New Order Created'), 'unread');
        }catch (\Exception $exception){}

        // Check the main order user's type and create a notification if the user type is 1
        $main_user = $order_details->client;
        if ($main_user && $main_user->type === 1) {
            $client_firebase_token = $main_user->firebase_token;

            if (!empty($client_firebase_token) && !is_array($client_firebase_token)) {
                $client_token = [$client_firebase_token];
            }

            $client_title = __('New Order Created.');
            $client_body = __('Your order ID: # :id has been placed successfully.', ['id' => $last_order_id]);
            $this->sendUserNotification($last_order_id, $main_user->id, $client_body);

            // Send notifications to all providers in one go
            if (!empty($client_token)) {
                $client_notification_data = [
                    "title" => $client_title,
                    "detailed_title" => "-",
                    "identify" => $last_order_id, // identify
                    "sub_order_id" => 0, // sub order id
                    "user_id" => $main_user->id ?? 0, // client id
                    "body" => $client_body,
                    "description" => "-",
                    "type" => "order",
                    "sound" => "default",
                    "screen" => "-"
                ];
                $this->sendFirebaseNotification($client_token, $client_title, $client_body, $client_notification_data);
            }

        }


        // Create notifications for each provider associated with the sub-orders
        foreach ($order_details->subOrders as $subOrder) {
            // If the sub-order has an associated admin, send a notification to the admin
            if (!empty($subOrder->admin_id) && !is_null($subOrder->admin_id)) {
                admin_notification($last_order_id, $subOrder->user_id, 'admin-order',__('You have a new order.'), 'unread');
            }else{
                if($subOrder->provider){
                    if ($subOrder->provider) {
                        // Check if the provider's firebase token is set and is not empty
                        if (!empty($subOrder->provider?->firebase_token)) {
                            // Always treat firebase_token as a string
                            $token = $subOrder->provider?->firebase_token;
                            if (!empty($token) && !is_null($token)) {
                                $provider_token = [$token];
                                $provider_title = __('New Order Created');
                                $provider_body = __('Your order ID: # :id has been created successfully.', ['id' => $subOrder->id]);

                                $provider_notification_data = [
                                    "title" => $provider_title,
                                    "detailed_title" => "-",
                                    "identify" => $subOrder->id, // identify
                                    "sub_order_id" => 0, // sub order id
                                    "user_id" => $subOrder->provider?->id ?? 0, // provider_id
                                    "body" => $provider_body,
                                    "description" => "-",
                                    "type" => "order",
                                    "sound" => "default",
                                    "screen" => "-"
                                ];

                                $this->sendFirebaseNotification($provider_token, $provider_title, $provider_body, $provider_notification_data);
                            }
                        }
                        // Notify the user for the provider
                        $this->sendUserNotification($subOrder->id, $subOrder->provider_id, $provider_body);
                    }
                }

            }
        }
    }

    private function sendUserNotification($order_id, $user_id, $message)
    {
        user_notification($order_id, $user_id, 'order', $message, 'unread');
    }

    private function sendAdminNotification($order_id, $admin_id, $message)
    {
        admin_notification($order_id, $admin_id, 'order', $message, 'unread');
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

    public function orderStatusChanceNotification($sub_order, $provider = null){
        // Map status codes to title and body messages
        $statusMessages = [
            0 => [
                'title' => __('Order ID #:order_id Pending', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been created successfully.')
            ],
            1 => [
                'title' => __('Order ID #:order_id Active', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been activated successfully.')
            ],
            2 => [
                'title' => __('Order ID #:order_id Completed', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been completed successfully.')
            ],
            3 => [
                'title' => __('Order ID #:order_id Delivered', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been delivered successfully.')
            ],
            4 => [
                'title' => __('Order ID #:order_id Cancelled', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been cancelled.')
            ],
            5 => [
                'title' => __('Order ID #:order_id Declined', ['order_id' => $sub_order->order_id]),
                'body' => __('Your order has been declined.')
            ]
        ];

        // Check if the status is in the array
        if (isset($statusMessages[$sub_order->status])) {
            $title = $statusMessages[$sub_order->status]['title'];
            $body = $statusMessages[$sub_order->status]['body'];
        } else {
            //in case status is not found
            $title = __('Unknown Status');
            $body = __('The status of your order is unknown.');
        }


        // Get client token
        if (!empty($sub_order->client->firebase_token)) {
            $client_token[] = $sub_order->client?->firebase_token;
            // Prepare the dynamic data for notification
            $client_notification_data = [
                "title" => $title,
                "detailed_title" => "-",
                "identify" => $sub_order->order_id ?? 0, // identify
                "sub_order_id" => $sub_order->id ?? 0, // identify
                "user_id" => $sub_order->client?->id ?? 0, // user id
                "body" => $body,
                "description" => "-",
                "type" => "order",
                "sound" => "default",
                "screen" => "-"
            ];

            // create user notification
            user_notification($sub_order->order_id, $sub_order->client?->id, 'order', $body, 'unread');

            // Check if the array has tokens and send notification
            if (!empty($provider_token)) {
                $this->sendFirebaseNotification($client_token, $title, $body, $client_notification_data);
            }
        }

        // Get provider token (If a specific provider is passed, use their token)
        if ($provider && !empty($provider->firebase_token)) {
            $provider_token[] = $provider->firebase_token;

            // Use sub_order ID in the title for the provider
            $provider_title = __('Order ID #:sub_order_id Status Changed', ['sub_order_id' => $sub_order->id]);

            // Prepare the dynamic data for notification
            $provider_notification_data = [
                "title" => $provider_title,
                "detailed_title" => "-",
                "identify" => $sub_order->id, // identify
                "sub_order_id" => $sub_order->id ?? 0, // identify
                "user_id" => $sub_order->client?->id ?? 0, // user id
                "body" => $body,
                "description" => "-",
                "type" => "order",
                "sound" => "default",
                "screen" => "-"
            ];

            // create user notification
            user_notification($sub_order->id, $provider->id ?? 0, 'order', $body, 'unread');

            // Check if the array has tokens and send notification
            if (!empty($provider_token)) {
                $this->sendFirebaseNotification($provider_token, $provider_title, $body, $provider_notification_data);
            }

        } elseif (!empty($sub_order->provider?->firebase_token)) {

            $provider_token[] = $sub_order->provider->firebase_token;

            // Use sub_order ID in the title for the provider
            $provider_title = __('Order ID #:sub_order_id Status Changed', ['sub_order_id' => $sub_order->id]);

            // Prepare the dynamic data for notification
            $provider_notification_data = [
                "title" => $provider_title,
                "detailed_title" => "-",
                "identify" => $sub_order->id, // identify
                "sub_order_id" => $sub_order->id ?? 0, // identify
                "user_id" => $sub_order->client?->id ?? 0, // user id
                "body" => $body,
                "description" => "-",
                "type" => "order",
                "sound" => "default",
                "screen" => "-"
            ];

            // create user notification
            user_notification($sub_order->id, $sub_order->provider?->id, 'order', $body, 'unread');

            // Check if the array has tokens and send notification
            if (!empty($provider_token)) {
                $this->sendFirebaseNotification($provider_token, $provider_title, $body, $provider_notification_data);
            }
        }


    }

}
