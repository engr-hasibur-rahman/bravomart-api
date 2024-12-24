<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\StoreDetailsResource;
use App\Interfaces\StoreManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreDashboardManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {

    }

    public function dashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|exists:com_merchant_stores,slug',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => $validator->errors()
            ], 400);
        }
        $storeDashboard = $this->storeRepo->storeDashboard($request->slug);
        return response()->json(new StoreDetailsResource($storeDashboard));
    }
}
