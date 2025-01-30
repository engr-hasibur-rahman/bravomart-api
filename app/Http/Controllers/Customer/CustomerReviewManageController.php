<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerReviewResource;
use App\Models\Order;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class CustomerReviewManageController extends Controller
{
    public function __construct(protected ReviewService $reviewService)
    {

    }

    public function index(Request $request)
    {
        $filters = [
            "min_rating" => $request->min_rating,
            "max_rating" => $request->min_rating,
            "rating" => $request->rating,
            "status" => $request->status,
            "store_id" => $request->store_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "per_page" => $request->per_page,
        ];
        $reviews = $this->reviewService->getCustomerReviews($filters);
        if (!empty($reviews)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => CustomerReviewResource::collection($reviews),
                'meta' => new PaginationResource($reviews)
            ]);
        }
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

        $review_already_exists = Review::where('order_id', $request->order_id)
            ->where('reviewable_id', $request->reviewable_id)
            ->where('reviewable_type', $request->reviewable_type)
            ->where('status', 'approved')->exists();
        if ($review_already_exists) {
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message' => 'This review already exists!'
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
