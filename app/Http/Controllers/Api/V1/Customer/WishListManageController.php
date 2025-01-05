<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishListRequest;
use App\Http\Resources\Customer\WishListResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishListManageController extends Controller
{
    public function addToWishlist(WishListRequest $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $request['customer_id'] = auth('api_customer')->user()->id;
        try {
            $exists = Wishlist::where('customer_id', $request['customer_id'])
                ->where('product_id', $request->product_id)
                ->exists();
            if ($exists) {
                return response()->json([
                    'status' => false,
                    'status_code' => 401,
                    'message' => __('messages.exists', ['name' => 'Product'])
                ]);
            }
            Wishlist::create(request()->all());
            return $this->success(translate('messages.save_success', ['name' => 'Wish List']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function removeFromWishlist(Request $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            Wishlist::where('customer_id', auth('api_customer')->user()->id)
                ->where('product_id', $request->product_id)
                ->delete();
            return $this->success(translate('messages.delete_success', ['name' => 'Wish List']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getWishlist()
    {
        try {
            $wishlist = Wishlist::with(['product.variants', 'product.store'])->where('customer_id', auth('api_customer')->user()->id)->get();
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'wishlist' => WishlistResource::collection($wishlist)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
}
