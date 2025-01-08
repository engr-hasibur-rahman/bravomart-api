<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SellerWiseStoreForDropdownResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\Store\StoreListResource;
use App\Interfaces\StoreManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminStoreManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {

    }

    public function index(Request $request)
    {
        $stores = $this->storeRepo->getAllStores(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        // Return the stores as a resource collection
        return response()->json([
            'data' => StoreListResource::collection($stores),
            'meta' => new PaginationResource($stores),
        ]);
    }

    public function sellerStores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $stores = $this->storeRepo->getSellerWiseStores($request->seller_id);
        if ($stores) {
            return response()->json(SellerWiseStoreForDropdownResource::collection($stores));
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }
}
