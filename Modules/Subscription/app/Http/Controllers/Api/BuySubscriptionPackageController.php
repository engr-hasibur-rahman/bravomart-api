<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Subscription\app\Http\Requests\RenewSubscriptionRequest;
use Modules\Subscription\app\Models\StoreSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;
use Modules\Subscription\app\Services\SubscriptionService;

class BuySubscriptionPackageController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function buySubscriptionPackage(Request $request)
    {
        $result = $this->subscriptionService->buySubscriptionPackage($request->all());
        return response()->json($result);
    }

    public function renewSubscriptionPackage(RenewSubscriptionRequest $request)
    {
        $store_id = $request->store_id;
        $subscription_id = $request->subscription_id;
        $payment_gateway = $request->payment_gateway;
        $result = $this->subscriptionService->renewSubscriptionPackage($store_id, $subscription_id, $payment_gateway);
        return response()->json($result);
    }

    public function packagePaymentStatusUpdate(Request $request)
    {
        // Check if the user is authenticated
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 401);
        }


        // Validate the required inputs using Validator::make
        $validated = Validator::make($request->all(), [
            'store_id' => 'required|integer',
            'transaction_ref' => 'nullable|string|max:255',
        ]);

        // Check if validation fails
        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors(),
            ], 400);
        }

        // Get necessary details
        $sellerEmail = $user->email ?? '';
        $providedHmac = $request->header('X-HMAC');
        $secretKey = '4b3403665fea6e60060fca1953b6e1eaa5c4dc102174f7e923217b87df40523a';

        // Generate the HMAC for comparison
        $calculatedHmac = hash_hmac('sha256', $sellerEmail, $secretKey);

        // Verify HMAC
        if (!hash_equals($providedHmac, $calculatedHmac)) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        // Find the subscription history
        $subscription = SubscriptionHistory::where('store_id', $request->store_id)->first();

        // Check if the subscription history exists
        if (empty($subscription)) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found'
            ], 404);
        }

        // Update the subscription history
        $subscription->update([
            'payment_status' => 'paid',
            'transaction_ref' => $request->transaction_ref ?? null,
            'status' => 1,
        ]);

        //subscription history get after update
        $subscription = SubscriptionHistory::where('store_id', $request->store_id)->first();
        // update com store subscription data
        $com_store_subscription = StoreSubscription::where('store_id', $request->store_id)->first();
        if (!$com_store_subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Store subscription not found'
            ], 404);
        }

        // update com store subscription data exiting data update
        $com_store_subscription->update($subscription->only([
            'store_id',
            'subscription_id',
            'name',
            'validity',
            'price',
            'pos_system',
            'self_delivery',
            'mobile_app',
            'live_chat',
            'order_limit',
            'product_limit',
            'product_featured_limit',
            'payment_gateway',
            'payment_status',
            'transaction_ref',
            'expire_date',
            'status',
        ]));


        // update store type
        $store = Store::where('id', $request->store_id)
            ->where('store_seller_id', auth()->guard('api')->id())
            ->first();

        if (!$store) {
            return response()->json([
                'message' => 'Store not found or you do not have access to this store.',
            ], 404);
        }

        // Update the subscription type
        $store->update([
            'subscription_type' => 'subscription',
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully',
        ]);
    }

}
