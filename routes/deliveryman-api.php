<?php

use App\Http\Controllers\Api\V1\Deliveryman\DeliverymanManageController;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => 'delivery-man/'], function () {
    Route::post('/registration', [DeliverymanManageController::class, 'registration']);
    Route::post('/login', [DeliverymanManageController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/dashboard', [DeliverymanManageController::class, 'dashboard']);
    });
});
