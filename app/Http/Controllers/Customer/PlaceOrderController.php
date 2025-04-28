<?php

namespace App\Http\Controllers\Customer;

use App\Events\MyEvent;
use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Http\Resources\Order\OrderMasterResource;
use App\Http\Resources\Order\PlaceOrderDetailsResource;
use App\Http\Resources\Order\PlaceOrderMasterResource;
use App\Models\Order;
use App\Models\OrderMaster;
use App\Models\UniversalNotification;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Services\OrderService;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PlaceOrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // place order
    public function placeOrder(PlaceOrderRequest $request): JsonResponse
    {

        $data = $request->validated();

//        $user = User::with('pushSubscriptions')->find(1);
//        // Get subscription data from the request
//        $endpoint = $request->input('endpoint');
//        $key = $request->input('keys.p256dh');
//        $token = auth()->user()->currentAccessToken()->token;
//        $contentEncoding = $request->input('content_encoding', 'aes128gcm');
//        Log::info('Sending notification...');
//
//        $user->updatePushSubscription($endpoint, $key, $token, $contentEncoding);
//        $user->notify(new NewOrderNotification($data));
//        return response()->json(['message' => 'Order placed and notification sent']);


        // login check
        if (!auth()->guard('api_customer')->user()
            && isset($data['guest_info'])
            && isset($data['guest_info']['guest_order'])
            && $data['guest_info']['guest_order'] === false) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to proceed with the order.',
            ], 400);
        }

        $orders = $this->orderService->createOrder($data);
        // if return false
        if($orders === false || empty($orders)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
            ], 400);
        }else{
            $all_orders = $orders[0];
            $order_master = $orders[1];
        }

        try {
            if ($orders) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully.',
                    'orders' => PlaceOrderDetailsResource::collection($all_orders),
                    'order_master' => new PlaceOrderMasterResource($order_master),
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while placing the order.',
                ],500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing the order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function sendWebPushNotification($user, $title, $body)
    {
        $firebaseToken = $user->firebase_token; // Ensure user has a firebase token saved

        // Firebase API URL for sending messages
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Your Firebase server key
        $serverKey = 'YOUR_FIREBASE_SERVER_KEY';

        $notification = [
            'title' => $title,
            'body'  => $body,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',  // This can be adjusted based on your requirements
        ];

        $data = [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'extra_data' => 'order_data'  // Customize this for your data
        ];

        $payload = [
            'to' => $firebaseToken, // the token of the device/user
            'notification' => $notification,
            'data' => $data,
        ];

        $headers = [
            'Authorization' => 'key=' . $serverKey,
            'Content-Type'  => 'application/json',
        ];

        $client = new Client();
        $response = $client->post($url, [
            'json' => $payload,
            'headers' => $headers,
        ]);

        return response()->json(json_decode($response->getBody(), true));
    }

}
