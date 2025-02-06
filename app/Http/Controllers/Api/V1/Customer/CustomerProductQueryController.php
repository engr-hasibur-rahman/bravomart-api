<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQueryRequest;
use App\Interfaces\ProductQueryManageInterface;
use Illuminate\Http\Request;

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
}
