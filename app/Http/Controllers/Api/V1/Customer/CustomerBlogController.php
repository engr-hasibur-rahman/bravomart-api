<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Interfaces\BlogManageInterface;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class CustomerBlogController extends Controller
{
    public function __construct(protected BlogManageInterface $blogRepo)
    {
    }
    public function comment(CommentRequest $request)
    {
        try {
            if (!auth()->guard('api_customer')->check()) {
                return unauthorized_response();
            } else {
                $userId = auth('api_customer')->user()->id;
                $request['user_id'] = $userId;
                BlogComment::create($request->all());
                return response()->json([
                    'status' => true,
                    'status_code' => 201,
                    'message' => __('messages.save_success', ['name' => 'Comment']),
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
