<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\OrderActivityType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCashCollectionController extends Controller
{
    public function collectCash(Request $request)
    {
        if ($request->isMethod('POST')) {
            $user = auth('api')->user();
            $store_level = $user->activity_scope == 'system_level';

            if (!$store_level) {
                return response()->json(['message' => __('messages.authorization_invalid')], 422);
            }

            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'deliveryman_id' => 'required|exists:users,id',
                'reference' => 'nullable|string|max:500',
                'activity_value' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $order = Order::with(['orderMaster', 'orderDeliveryHistory'])->find($request->order_id);

            if (!$order || !$this->isOrderValidForCashCollection($order, $request->deliveryman_id)) {
                return response()->json(['message' => __('messages.order_does_not_belong_to_deliveryman')], 422);
            }

            if (!$this->isCashOnDelivery($order)) {
                return response()->json(['message' => __('messages.order_is_not_cash_on_delivery')], 422);
            }

            $orderActivity = OrderActivity::create([
                'order_id' => $request->order_id,
                'ref_id' => $request->deliveryman_id,
                'reference' => $request->reference ?? null,
                'collected_by' => $user->id,
                'activity_from' => 'deliveryman',
                'activity_type' => OrderActivityType::CASH_DEPOSIT->value,
                'activity_value' => $request->activity_value
            ]);

            return response()->json([
                'message' => $orderActivity
                    ? __('messages.save_success', ['name' => 'Cash Deposit'])
                    : __('messages.save_failed', ['name' => 'Cash Deposit'])
            ], $orderActivity ? 201 : 500);
        }
    }

    private function isOrderValidForCashCollection($order, $deliverymanId)
    {
        return $order->orderDeliveryHistory->status == 'delivered' &&
            $order->orderDeliveryHistory->deliveryman_id == $deliverymanId;
    }

    private function isCashOnDelivery($order)
    {
        return $order->orderMaster->payment_gateway == 'cash_on_delivery';
    }

}
