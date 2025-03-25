<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use Illuminate\Http\Request;
use Modules\Subscription\app\Models\StoreSubscription;

class AdminSubscriptionSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StoreSubscription::query();
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('expire_date')) {
            $query->whereDate('expire_date', $request->expire_date);
        }

        if ($request->has('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $perPage = $request->input('per_page', 10);
        $subscriptions = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => $subscriptions,
            'meta' => new PaginationResource($subscriptions),
        ]);
    }

}
