<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentGateways\App\Http\Controllers\Api\PaymentGatewaysController;


Route::group([], function () {
    Route::resource('paymentgateways', PaymentGatewaysController::class)->names('paymentgateways');
});
