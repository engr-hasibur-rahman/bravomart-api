<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Subscription\app\Http\Requests\BuySubscriptionRequest;
use Modules\Subscription\app\Services\SubscriptionService;

class BuySubscriptionPackageController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function buySubscriptionPackage(BuySubscriptionRequest $request)
    {
        $result = $this->subscriptionService->buySubscriptionPackage($request);
        return response()->json($result);
    }

}
