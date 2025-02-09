<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQueryRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\ProductQueryManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerProductQueryController extends Controller
{
    public function __construct(protected ProductQueryManageInterface $productQueryRepo)
    {
    }

    public function askQuestion(ProductQueryRequest $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $question = $this->productQueryRepo->askQuestion($request->all());
        if ($question) {
            return response()->json([
                'message' => __('messages.customer_product_query_submitted_successful')
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.customer_product_query_submitted_failed')
            ], 500);
        }
    }

    public function searchQuestion(Request $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'search' => 'required|string'
        ]);
        $questions = $this->productQueryRepo->searchQuestion($request->all());
        if ($questions->isEmpty()) {
            return [];
        }
        if ($questions) {
            return response()->json([
                'data' => $questions,
                'meta' => new PaginationResource($questions),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }
}
