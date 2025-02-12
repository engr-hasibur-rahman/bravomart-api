<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\OrderPaymentResource;
use App\Http\Resources\Order\SellerStoreOrderPackageResource;
use App\Http\Resources\Order\SellerStoreOrderPaymentResource;
use App\Http\Resources\Order\SellerStoreOrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use App\Models\OrderPayment;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerStoreOrderController extends Controller
{
    public function allOrders(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:stores,id',
        ]);

        // Check for validation failure
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

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
        $order_packages = OrderPackage::with(['order.customer', 'orderDetails', 'order.orderPayment'])->where('store_id', $request->store_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $firstOrderPackage = $order_packages->first();

        return response()->json([
            'order' => $firstOrderPackage ? new SellerStoreOrderResource($firstOrderPackage) : null,
            'order_packages' => SellerStoreOrderPackageResource::collection($order_packages),
            'customer' => $firstOrderPackage && $firstOrderPackage->order
                ? new CustomerResource($firstOrderPackage->order->customer)
                : null,
            'order_payment' => $firstOrderPackage && $firstOrderPackage->order
                ? new SellerStoreOrderPaymentResource($firstOrderPackage->order->orderPayment)
                : null,
            'meta' => new PaginationResource($order_packages)
        ]);
    }
}
