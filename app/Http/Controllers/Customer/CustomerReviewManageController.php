<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerReviewResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            "reviewable_type" => $request->reviewable_type,
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
                'message' => __('messages.data_found'),
                'data' => CustomerReviewResource::collection($reviews),
                'meta' => new PaginationResource($reviews)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found')
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
        if ($request->reviewable_type == 'product') {

            $product = Product::find($request->reviewable_id);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => 'Product not found!'
                ]);
            }
        }
        if ($request->reviewable_type == 'delivery_man') {

            $user = User::find($request->reviewable_id);
            $is_deliveryman = $user->isDeliveryman();
            if (!$is_deliveryman && $user) {
                return response()->json([
                    'status' => false,
                    'status_code' => 403,
                    'message' => 'This user is not a delivery man!'
                ]);
            }
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

    public function react(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review_id' => 'required|exists:reviews,id',
            'reaction_type' => 'required|in:like,dislike',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $success = $this->reviewService->reaction($request->review_id, $request->reaction_type);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Reaction'])
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.update_failed', ['name' => 'Reaction'])
            ]);
        }
    }

}
