<?php

use Illuminate\Support\Facades\Route;
use Modules\SmsGateway\app\Http\Controllers\SmsGatewayController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('smsgateway', SmsGatewayController::class)->names('smsgateway');
});
