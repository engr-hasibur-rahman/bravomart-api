<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\UniversalNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderManageNotificationService
{
    public function createOrderNotification($last_order_ids, $otherCheckData = null)
    {
//        try {
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

//        }catch (\Exception $exception){}


    }

    private function sendOrderNotification($recipient, $idKey, $idValue, $orderId, $title, $body)
    {

        if (empty($recipient)) {
            return;
        }

        // super admin token
        $super_admin = User::where('activity_scope', 'system_level')
            ->where('slug', 'system-admin-1')
            ->first();

        $fcm_web_token = $super_admin->firebase_token;
        $user_firebase_token = $recipient->firebase_token;

        // Collect tokens (add web token and recipient's token)
        // Start with the web token
        $token = [$fcm_web_token];

        // If the recipient has a firebase_token (Flutter token), add it
        if (!empty($user_firebase_token)) {
            $flutterToken = is_array($user_firebase_token)
                ? $user_firebase_token
                : [$user_firebase_token];

            // Merge Flutter tokens with Web token
            $tokens = array_merge($token, $flutterToken);
        }

        // empty check
        $tokens = array_filter($tokens);
        if (!empty($tokens)) {
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
            $this->sendFirebaseNotification($tokens, $title, $body, $notification_data);
            
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

//        try {
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
                ],
                $processedData
            );

            // Construct the CloudMessage with notification and data payloads
            $message = CloudMessage::new()
                ->withNotification($notification)  // Pass the Notification object
                ->withData($dataToSend);
            // Send the notification to multiple tokens
        $response =  $messaging->sendMulticast($message, $firebaseTokens);
//dd($firebaseTokens);

            // Check for the success or failure of each token
            $successCount = 0;
            $failureCount = 0;
            // Loop through the results to check for successful and failed deliveries
            foreach ($response->successes() as $success) {
                $successCount++;
            }

            // Loop through the failed responses
            foreach ($response->failures() as $failure) {
                $failureCount++;
                // Log the error message if needed
                Log::error("Failed to send notification: " . $failure->error()->message());
            }

            // Check if all notifications were sent successfully
            if ($successCount == count($firebaseTokens)) {
                Log::info('All notifications sent successfully!');
            } else {
                Log::info("Notifications sent: Success - {$successCount}, Failure - {$failureCount}");
            }


//        }catch (\Exception $exception){}
    }

}
