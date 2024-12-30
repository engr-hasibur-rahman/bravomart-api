<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\PaymentGateways\app\Http\Controllers\PaymentGatewaysController;
use Modules\PaymentGateways\app\Http\Controllers\PaymentGatewaySettingsController;


//Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//    Route::group(['prefix' => 'admin/payment-gateway'], function () {
//        Route::get('/settings/{gateway}', [PaymentGatewaysController::class, 'getSettings']);
//        Route::post('/update', [PaymentGatewaysController::class, 'updateGateway']);
//    });
//});

Route::middleware(['auth:sanctum', 'permission:' . PermissionKey::PAYMENT_SETTINGS->value])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/system-management'], function () {
        Route::get('/payment-settings/{gateway}', [PaymentGatewaysController::class, 'getSettings']);
        Route::post('/payment-settings/update', [PaymentGatewaysController::class, 'updateGateway']);
    });
});
