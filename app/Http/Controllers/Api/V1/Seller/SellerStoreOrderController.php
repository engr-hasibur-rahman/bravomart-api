<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\OrderPaymentResource;
use App\Http\Resources\Order\SellerStoreOrderPackageResource;
use App\Http\Resources\Order\SellerStoreOrderPaymentResource;
use App\Http\Resources\Order\SellerStoreOrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\OrderPayment;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerStoreOrderController extends Controller
{
    public function allOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'nullable|exists:stores,id',
            'package_id' => 'nullable|exists:order_masters,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->package_id) {
            $order_package_details = OrderMaster::with(['order.customer', 'orderDetails', 'order.orderPayment'])
                ->where('id', $request->package_id)
                ->first();
            if (!$order_package_details) {
                return response()->json([
                    'message' => __('message.data_not_found'),
                ], 404);
            }
            return response()->json(new SellerStoreOrderPackageResource($order_package_details));
        }
        if (isset($request->store_id)){
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
            $order_masters = OrderMaster::with(['order.customer', 'orderDetails', 'order.orderPayment'])->where('store_id', $request->store_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'order_masters' => SellerStoreOrderPackageResource::collection($order_masters),
                'meta' => new PaginationResource($order_masters)
            ]);
        } else {
            return response()->json([
                'messages' => __('messages.data_not_found'),
            ],404);
        }
    }

    public function invoice(Request $request)
    {
        $order_package = OrderMaster::with(['order.customer', 'order.orderMaster.orderDetails.product', 'order.orderPayment', 'order.shippingAddress'])
            ->where('id', $request->order_package_id)
            ->first();

        if (!$order_package) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }

        $order = $order_package->order;
        $order->setRelation('orderMaster', collect([$order_package]));

        return response()->json(new InvoiceResource($order));
    }
}
