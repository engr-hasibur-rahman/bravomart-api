<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerProfileResource;
use App\Http\Resources\Seller\SellerProfileResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class SellerManageController extends Controller
{
    public function getProfile()
    {
        try {
            if (!auth('sanctum')->check()) {
                return unauthorized_response();
            }

            $userId = auth('sanctum')->id();
            $user = User::findOrFail($userId);

            return response()->json(new SellerProfileResource($user));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.something_went_wrong'),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
