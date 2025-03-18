<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Http\Resources\Order\OrderSummaryResource;
use App\Http\Resources\Order\StoreOrderResource;
use App\Jobs\DispatchOrderEmails;
use App\Models\Order;
use App\Models\Store;
use App\Services\Order\OrderManageNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerStoreOrderController extends Controller
{

    protected $orderManageNotificationService;

    public function __construct(OrderManageNotificationService $orderManageNotificationService)
    {
        $this->orderManageNotificationService = $orderManageNotificationService;
    }
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

            $order = Order::with(['orderMaster.customer', 'orderDetail.product', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
                ->where('id', $request->order_id)
                ->first();

            if (!$order) {
                return response()->json([
                    'message' => __('message.data_not_found'),
                ], 404);
            }

            $seller_id = auth('api')->user()->id;
            $seller_stores = Store::where('store_seller_id', $seller_id)->pluck('id');

            if (!$seller_stores->contains($order->store_id)) {
                return response()->json(['message' => __('messages.order_does_not_belong_to_seller')], 422);
            }

            return response()->json([
                    'order_data' => new StoreOrderResource($order),
                    'order_summary' => new OrderSummaryResource($order)
                ]);
        }

        if (isset($request->store_id)) {
            $store = Store::where('id', $request->store_id)
                ->where('store_seller_id', auth('api')->user()->id)
                ->first();

            // auth seller store check
            if (empty($store) || !$store) {
                return response()->json([
                    'message' => __('messages.data_not_found'),
                ], 404);
            }

            // Get store-wise order info
            $orders = Order::with(['orderMaster.customer', 'orderDetail.product', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
                ->where('store_id', $request->store_id);

            // Apply status filter
            if (isset($request->status)) {
                $orders->where('status', $request->status);
            }

            // Apply payment_status filter
            if (isset($request->payment_status)) {
                $orders->whereHas('orderMaster', function ($query) use ($request) {
                    $query->where('payment_status',$request->payment_status);
                });
            }

            $orders = $orders->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'order_masters' => StoreOrderResource::collection($orders),
                'meta' => new PaginationResource($orders)
            ]);
        } else {
            return response()->json([
                'messages' => __('messages.data_not_found'),
            ], 404);
        }
    }

    public function invoice(Request $request)
    {
        $order = Order::with(['orderMaster.customer', 'orderDetail.product', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
            ->where('id', $request->order_id)
            ->first();

        if (!$order) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
        $seller_id = auth('api')->user()->id;
        $seller_stores = Store::where('store_seller_id', $seller_id)->pluck('id');
        if (!$seller_stores->contains($order->store_id)) {
            return response()->json(['message' => __('messages.order_does_not_belong_to_seller')], 422);
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

    public function changeOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,confirmed,processing'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $seller_id = auth('api')->user()->id;
        $seller_stores = Store::where('store_seller_id', $seller_id)->pluck('id');
        $order = Order::with('orderMaster')->find($request->order_id);

        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        if (!$seller_stores->contains($order->store_id)) {
            return response()->json(['message' => __('messages.order_does_not_belong_to_seller')], 422);
        }
        if ($order->status === 'pending' || $order->status === 'confirmed' || $order->status === 'processing') {

            $success = $order->update([
                'status' => $request->status
            ]);

            // Notify seller and customer
            $order = [$order->id];
            $this->orderManageNotificationService->createOrderNotification($order);

            try {
                // Dispatch the email job asynchronously
                dispatch(new DispatchOrderEmails($order->orderMaster?->id));
            }catch (\Exception $e) {}

            if ($success) {
                return response()->json([
                    'message' => __('messages.update_success', ['name' => 'Order status'])
                ]);
            } else {
                return response()->json([
                    'message' => __('messages.update_failed', ['name' => 'Order status'])
                ], 500);
            }

        } else {
            return response()->json([
                'message' => __('messages.order_status_not_changeable')
            ], 422);
        }
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
            return response()->json(['message' => __('messages.order_does_not_belong_to_seller')], 422);
        }
        if ($order->status === 'pending' || $order->status === 'confirmed') {
            $success = $order->update([
                'cancelled_by' => auth('api')->user()->id,
                'cancelled_at' => Carbon::now(),
                'status' => 'cancelled'
            ]);

            // Notify seller and customer
            $order = [$order->id];
            $this->orderManageNotificationService->createOrderNotification($order, 'order-cancelled');

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
