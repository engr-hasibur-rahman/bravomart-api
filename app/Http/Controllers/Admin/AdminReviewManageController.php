<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminReviewResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class AdminReviewManageController extends Controller
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
            "customer_name" => $request->customer_name,
            "rating" => $request->rating,
            "status" => $request->status,
            "store_id" => $request->store_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "per_page" => $request->per_page,
        ];
        $reviews = $this->reviewService->getAllReviews($filters);
        if (!empty($reviews)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => AdminReviewResource::collection($reviews),
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

    public function approveReview()
    {
    }

    public function rejectReview()
    {
    }

    public function destroy()
    {
    }

}
