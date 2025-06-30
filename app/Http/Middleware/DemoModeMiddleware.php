<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{

    protected array $blockedMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
    protected array $protectedPaths = [
        // for admin
        'api/v1/admin/profile*',
        'api/v1/admin/payment-gateways*',
        'api/v1/admin/attribute*',
        'api/v1/admin/blog*',
        'api/v1/admin/brand*',
        'api/v1/admin/coupon*',
        'api/v1/admin/customer*',
        'api/v1/admin/stores*',
        'api/v1/admin/department*',
        'api/v1/admin/orders*',
        'api/v1/admin/product*',
        'api/v1/admin/product-categories*',
        'api/v1/admin/product/author*',
        'api/v1/admin/product/inventory*',
        'api/v1/admin/promotional*',
        'api/v1/admin/pages*',
        'api/v1/admin/roles*',
        'api/v1/admin/store*',
        'api/v1/admin/store-notices*',
        'api/v1/admin/staff*',
        'api/v1/admin/notifications*',
        'api/v1/admin/slider*',
        'api/v1/admin/media-manage*',
        'api/v1/admin/seller*',
        'api/v1/admin/system-management*',
        'api/v1/admin/tag*',
        'api/v1/admin/unit*',
        'api/v1/admin/deliveryman*',
        'api/v1/admin/financial*',
        'api/v1/admin/business-operations*',
        'api/v1/admin/contact-messages*',
        'api/v1/admin/feedback-control*',
        'api/v1/admin/support-ticket*',
        'api/v1/admin/sms-provider/settings*',

        // for seller
        'api/v1/seller/store/product*',
        'api/v1/seller/store/product*',
        'api/v1/seller/store/settings*',
        'api/v1/seller/store/orders*',
        'api/v1/seller/store/remove*',
        'api/v1/seller/store/update*',
        'api/v1/seller/store/financial/wallet*',
        'api/v1/seller/store/promotional/wallet*',
        'api/v1/seller/store/feedback-control/wallet*',
        'api/v1/seller/store/support-ticket*',
        'api/v1/seller/store/staff*',
        'api/v1/seller/store/deliveryman*',
        'api/v1/seller/profile*',
        'api/v1/admin/attribute*',

        // for customer
        'api/v1/customer/profile*',
        'api/v1/customer/reset-password',
        'api/v1/customer/forget-password',
        'api/v1/customer/verify-token',
        'api/v1/customer/orders*',
        'api/v1/customer/address*',
        'api/v1/customer/wish-list*',
        'api/v1/customer/wallet*',
        'api/v1/customer/support-ticket*',
        'api/v1/customer/review*',
        'api/v1/customer/product-query*',
        'api/v1/customer/blog*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (env('DEMO_MODE') === true) {
            if (in_array($request->method(), $this->blockedMethods)) {
                foreach ($this->protectedPaths as $path) {
                    if ($request->is("$path*")) {
                        return response()->json([
                            'message' => 'This action is not allowed in demo mode',
                        ], 403);
                    }
                }
            }
        }

        return $next($request);
    }
}
