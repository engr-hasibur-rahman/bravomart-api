<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\ProductQueryManageInterface;
use Illuminate\Http\Request;

class SellerProductQueryController extends Controller
{
    public function __construct(protected ProductQueryManageInterface $productQueryRepo)
    {

    }

    public function getQuestions(Request $request)
    {
        $filters = [
            "date_filter" => $request->date_filter,
            "reply_status" => $request->reply_status,
            "per_page" => $request->per_page,
        ];
        $questions = $this->productQueryRepo->getSellerQuestions($filters);
        if ($questions->isEmpty()) {
            return [];
        }
        if ($questions) {
            return response()->json([
                'data' => $questions,
                'meta' => new PaginationResource($questions)
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 500);
        }
    }

    public function replyQuestion(Request $request)
    {

    }
}
