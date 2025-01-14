<?php

namespace Modules\Subscription\app\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\Subscription;

class SubscriptionService
{
    public function buySubscriptionPackage($request)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        // Validate subscription package
        $subscription_package = Subscription::where('id', $request->subscription_id)
            ->where('status', 1)
            ->first();

        if (!$subscription_package) {
            return [
                'success' => false,
                'message' => 'Invalid subscription ID or the package is inactive.',
            ];
        }


//        // if membership payment gateway not select
//        $commission = AdminCommission::first();
//        if ($request->selected_payment_gateway == 'cash_on_delivery' || $request->selected_payment_gateway == 'manual_payment') {
//            $payment_status = 'pending';
//        } else {
//            $payment_status = 'pending';
//        }
//        if ($membership_details->price > 0) {
//            if (empty($request->selected_payment_gateway) || is_null($request->selected_payment_gateway)) {
//                toastr_error(__('Payment gateway is missing. Please try again.'));
//                return redirect()->back();
//            }
//        }
//        $payment_gateway_name = $request->selected_payment_gateway;
//
//        if ($total_service_amount_check == 0) {
//            return response()->json([
//                'message' => __('Service price is 0, order cannot be created. Please try other services.'),
//            ], 400);
//        }
//
//        // create order
//        $order = Order::create([
//            'user_id' => $user_id,
//            'sub_total' => 0,
//            'tax' => 0,
//            'total' => 0,
//            'status' => 0,
//            'payment_gateway' => $payment_gateway_name,
//            'payment_status' => $payment_status,
//            'invoice_number' => $invoiceNumber,
//        ]);
//
//        $order_details = Order::with('client','subOrders.subOrderAddons', 'subOrders.subOrderLocations', 'subOrders.staff', 'subOrders.service', 'subOrders.job', 'subOrders.reviews', 'subOrders.order_complete_request')->find($last_order_id);
//
//        try {
//            // Create order notifications
//            $this->orderServiceNotification->createOrderNotification($last_order_id, $request);
//            // Dispatch job to send email in the background
//            dispatch(new SendOrderCreateEmail($order_details));
//        }catch (\Exception $exception){
//
//        }
//
//
//        return response()->json([
//            'order_details'=> new OrderDetailsResource($order_details),
//        ]);
//
//
//
//        // if subscription payment gateway not selected
//        if(){
//
//        }

        return [
            'success' => true,
            'message' => 'Subscription package purchased successfully.',
            'data' => [
                'subscription_name' => $subscription_package->name,
                'validity' => $subscription_package->validity . ' days',
                'expires_at' => $seller->subscription_expiry,
            ],
        ];
    }
}
