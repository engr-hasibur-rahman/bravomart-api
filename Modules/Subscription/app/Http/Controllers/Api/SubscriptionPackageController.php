<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Transformers\SubscriptionPackagePublicResource;
use Spatie\LaravelPackageTools\Package;

class SubscriptionPackageController extends Controller
{
    public function packages()
    {
        $packages = Subscription::where('status', 1)->paginate(10);
        return response()->json([
            'packages' => SubscriptionPackagePublicResource::collection($packages),
            'meta' => new PaginationResource($packages),
        ]);
    }
}
