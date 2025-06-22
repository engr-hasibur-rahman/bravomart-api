<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\PaymentGateways\App\Http\Controllers\Api\V1\PaymentGatewaysController;
use Modules\PaymentGateways\App\Http\Controllers\Api\V1\PaymentGatewaySettingsController;


Route::middleware(['auth:sanctum', 'permission:' . PermissionKey::ADMIN_PAYMENT_SETTINGS->value])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/payment-gateways'], function () {
        Route::match(['GET', 'POST'], '/settings/{gateway?}', [PaymentGatewaySettingsController::class, 'settingsGetAndUpdate']);
    });
});



Route::group(['prefix' => 'v1/'], function () {
    // payment gateways lists
    Route::get('currency-info', [PaymentGatewaysController::class, 'currencySettingsGet']);
    Route::get('payment-gateways', [PaymentGatewaysController::class, 'paymentGateways']);
});
