<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\ProductQueryManageInterface;
use Illuminate\Http\Request;

class AdminProductQueryManageController extends Controller
{
    public function __construct(protected ProductQueryManageInterface $productQueryRepo)
    {

    }

    public function getAllQueries(Request $request)
    {
        $filters = [
            "search" => $request->search,
            "date_filter" => $request->date_filter,
            "reply_status" => $request->reply_status,
            "status" => $request->status,
            "per_page" => $request->per_page,
        ];
        $queries = $this->productQueryRepo->getAllQuestionsAndReplies($filters);
        if ($queries->isEmpty()) {
            return [];
        }
        if ($queries) {
            return response()->json([
                'data' => $queries,
                'meta' => new PaginationResource($queries),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function destroy(Request $request)
    {

    }
}
