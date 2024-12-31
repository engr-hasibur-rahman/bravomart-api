<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\PaymentGateways\app\Http\Controllers\PaymentGatewaysController;


Route::middleware(['auth:sanctum', 'permission:' . PermissionKey::ADMIN_PAYMENT_SETTINGS->value])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/payment-gateways'], function () {
        Route::match(['GET', 'POST'], '/settings/{gateway?}', [PaymentGatewaysController::class, 'settingsGetAndUpdate']);
    });
});
