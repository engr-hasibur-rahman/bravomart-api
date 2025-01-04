<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Seller\SellerResource;
use App\Models\User;
use Illuminate\Http\Request;

class SellerManageController extends Controller
{
    public function getSellerList(Request $request)
    {
        $query = User::isSeller();

        if (isset($request->status)) {
            $query->where('status', $request->status);
        }
        if (isset($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $sellers = $query->paginate($request->perPage ?? 10);
        return response()->json([
            'sellers' => SellerResource::collection($sellers),
            'meta' => new PaginationResource($sellers),
        ]);
    }
}
