<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Order;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class CustomerReviewManageController extends Controller
{
    public function __construct(protected ReviewService $reviewService)
    {

    }

    public function index()
    {

    }

    public function submitReview(ReviewRequest $request)
    {
        $customer_id = auth('api_customer')->user()->id;
        $order = Order::findorfail($request->order_id);
        $order_belongs_to_customer = $order->where('customer_id', $customer_id)->exists();
        if (!$order_belongs_to_customer) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => 'This order does not belongs to this customer'
            ]);
        }
        $order_is_delivered = $order->status == 'delivered';
        if (!$order_is_delivered) {
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message' => 'This order is not delivered yet!'
            ]);
        }
        $success = $this->reviewService->addReview($request->all());
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.save_success', ['name' => 'Review'])
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.save_failed', ['name' => 'Review'])
            ]);
        }
    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function toggleReaction()
    {

    }

    public function destroy()
    {

    }
}
