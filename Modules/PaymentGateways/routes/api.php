<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentGateways\app\Http\Controllers\PaymentGatewaysController;
use Modules\PaymentGateways\app\Http\Controllers\PaymentGatewaySettingsController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/payment-gateway'], function () {
//        Route::get('/paypal', [PaymentGatewaysController::class, 'paypalSettings']);
//        Route::get('/stripe', [PaymentGatewaysController::class, 'stripeSettings']);
//        Route::get('/paytm', [PaymentGatewaysController::class, 'paytmSettings']);
//        Route::get('/payfast', [PaymentGatewaysController::class, 'stripeSettings']);
//        Route::get('/manual-payment', [PaymentGatewaysController::class, 'manualPaymentSettings']);
//        Route::get('/cash-on-delivery', [PaymentGatewaysController::class, 'cashOneDeliverySettings']);
//        Route::get('/update-payment-gateway', [PaymentGatewaysController::class, 'updatePaymentGateway']);

        Route::get('/settings/{gateway}', [PaymentGatewaysController::class, 'getSettings']);
        Route::post('/update', [PaymentGatewaysController::class, 'updateGateway']);

    });
});