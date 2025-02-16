<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\OrderPaymentResource;
use App\Http\Resources\Order\OrderSummaryResource;
use App\Http\Resources\Order\SellerStoreOrderPackageResource;
use App\Http\Resources\Order\SellerStoreOrderPaymentResource;
use App\Http\Resources\Order\SellerStoreOrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\OrderPayment;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerStoreOrderController extends Controller
{
    public function allOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'nullable|exists:stores,id',
            'order_id' => 'nullable|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->order_id) {
            $order = Order::with(['orderMaster.customer', 'orderDetails', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
                ->where('id', $request->order_id)
                ->first();
            if (!$order) {
                return response()->json([
                    'message' => __('message.data_not_found'),
                ], 404);
            }
            return response()->json(
                [
                    'order_data' => new AdminOrderResource($order),
                    'order_summary' => new OrderSummaryResource($order->orderDetails)
                ],200
            );
        }
        if (isset($request->store_id)) {
            $store = Store::where('id', $request->store_id)
                ->where('store_seller_id', auth('api')->user()->id)
                ->first();

            // auth seller store check
            if (empty($store) || !$store) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store not found',
                ], 404);
            }

            // get store wise order info
            $order_masters = Order::with(['customer', 'orderMaster', 'orderDetails', 'store', 'deliveryman', 'orderMaster.shippingAddress'])->where('store_id', $request->store_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'order_masters' => SellerStoreOrderPackageResource::collection($order_masters),
                'meta' => new PaginationResource($order_masters)
            ]);
        } else {
            return response()->json([
                'messages' => __('messages.data_not_found'),
            ], 404);
        }
    }

    public function invoice(Request $request)
    {
        $order = Order::with(['orderMaster.customer', 'orderMaster', 'orderDetails.product', 'orderMaster.shippingAddress'])
            ->where('id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }

        if ($order->orderMaster) {
            $order->customer = $order->orderMaster->customer;
            $order->shipping_address = $order->orderMaster->shippingAddress;
        }
        if (!$order) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
        return response()->json(new InvoiceResource($order));
    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $seller_id = auth('api')->user()->id;
        $seller_stores = Store::where('store_seller_id', $seller_id)->pluck('id');
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        if (!$seller_stores->contains($order->store_id)) {
            return response()->json(['message' => 'Order belongs to the seller\'s store.'], 422);
        }
        if ($order->status === 'pending') {
            $success = $order->update([
                'cancelled_by' => auth('api')->user()->id,
                'cancelled_at' => Carbon::now(),
                'status' => 'cancelled'
            ]);
            if ($success) {
                return response()->json([
                    'message' => __('messages.order_cancel_successful')
                ], 200);
            } else {
                return response()->json([
                    'message' => __('messages.order_cancel_failed')
                ], 500);
            }
        } else {
            return response()->json([
                'message' => __('messages.order_status_not_changeable')
            ], 422);
        }
    }
}
