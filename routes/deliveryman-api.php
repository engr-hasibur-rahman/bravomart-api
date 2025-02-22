<?php

use App\Http\Controllers\Api\V1\Deliveryman\DeliverymanManageController;
use App\Http\Controllers\Api\V1\Deliveryman\DeliverymanOrderManageController;
use App\Http\Controllers\Api\V1\Deliveryman\DeliverymanReviewController;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => 'delivery-man/'], function () {
    Route::post('registration', [DeliverymanManageController::class, 'registration']);
    Route::post('login', [DeliverymanManageController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum', 'no.code.input'], function () {
        Route::get('dashboard', [DeliverymanManageController::class, 'dashboard']);
        Route::get('review', [DeliverymanReviewController::class, 'index']);
        Route::group(['prefix' => 'order/'], function () {
            Route::get('my-orders', [DeliverymanOrderManageController::class, 'getMyOrders']);
            Route::get('request', [DeliverymanOrderManageController::class, 'getOrderRequest']);
            Route::post('handle-request', [DeliverymanOrderManageController::class, 'handleOrderRequest']);
            Route::post('change-status', [DeliverymanOrderManageController::class, 'changeStatus']);
            Route::get('delivery-history', [DeliverymanOrderManageController::class, 'orderDeliveryHistory']);
        });
    });
});
