<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\OrderRefundReasonDetailsResource;
use App\Http\Resources\Order\OrderRefundReasonResource;
use App\Interfaces\OrderRefundInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminOrderRefundManageController extends Controller
{
    public function __construct(protected OrderRefundInterface $orderRefundRepo)
    {

    }

    /* -------------------------------------------------------->Order Refund<--------------------------------------------------- */


    /* -------------------------------------------------------->Refund Reason<--------------------------------------------------- */

    public function allOrderRefundReason(Request $request)
    {
        $filters = [
            'per_page' => $request->per_page,
            'search' => $request->search,
        ];
        $reasons = $this->orderRefundRepo->order_refund_list($filters);
        return response()->json([
            'data' => OrderRefundReasonResource::collection($reasons),
            'meta' => new PaginationResource($reasons)
        ], 200);
    }

    public function createOrderRefundReason(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $success = $this->orderRefundRepo->create_order_refund_reason($request->reason);
        $this->orderRefundRepo->createOrUpdateTranslation($request, $success, 'App\Models\OrderRefundReason', $this->orderRefundRepo->translationKeys());
        if ($success) {
            return response()->json([
                'message' => __('messages.save_success', ['name' => 'Order Refund Reason']),
            ], 201);
        } else {
            return response()->json([
                'message' => __('messages.save_failed', ['name' => 'Order Refund Reason']),
            ], 500);
        }
    }

    public function updateOrderRefundReason(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:order_refund_reasons,id',
            'reason' => 'required|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $success = $this->orderRefundRepo->update_order_refund_reason($request->all());
        $this->orderRefundRepo->createOrUpdateTranslation($request, $success, 'App\Models\OrderRefundReason', $this->orderRefundRepo->translationKeys());
        if ($success) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Order Refund Reason']),
            ], 201);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Order Refund Reason']),
            ], 500);
        }
    }

    public function showOrderRefundReason(Request $request)
    {
        $validator = Validator::make(['id' => $request->id], [
            'id' => 'required|exists:order_refund_reasons,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $reason = $this->orderRefundRepo->get_order_refund_reason_by_id($request->id);
        if ($reason) {
            return response()->json(new OrderRefundReasonDetailsResource($reason), 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }

    public function deleteOrderRefundReason(int $id)
    {
        $success = $this->orderRefundRepo->delete_order_refund_reason($id);
        if ($success) {
            return response()->json([
                'message' => __('messages.delete_success', ['name' => 'Order Refund Reason']),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.delete_failed', ['name' => 'Order Refund Reason']),
            ], 500);
        }
    }
}
