<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Seller\SellerDetailsResource;
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
        $sellers = $query
            ->where('deleted_at', null)
            ->paginate($request->perPage ?? 10);
        return response()->json([
            'sellers' => SellerResource::collection($sellers),
            'meta' => new PaginationResource($sellers),
        ]);
    }

    public function getSellerDetails($slug)
    {
        $seller = User::isSeller()->where('slug', $slug)->first();
        return response()->json(new SellerDetailsResource($seller));
    }

    // Approve Seller
    public function approveSeller(Request $request)
    {
        $seller = User::isSeller()->findOrFail($request->id);
        $seller->update(['status' => 1]); // 1=Active
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.approve.success', ['name' => 'Seller'])
        ]);
    }

    // Reject Seller
    public function rejectSeller(Request $request)
    {
        $seller = User::isSeller()->findOrFail($request->id);
        $seller->update(['status' => 2]); // 2=Suspended
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.reject.success', ['name' => 'Seller'])
        ]);
    }

    // Get Pending Sellers
    public function pendingSellers()
    {
        $sellers = User::isSeller()
            ->where('status', 0)
            ->where('deleted_at', null)
            ->paginate(10); // 0=Inactive
        return response()->json([
            'sellers' => SellerResource::collection($sellers),
            'meta' => new PaginationResource($sellers),
        ]);
    }
}
