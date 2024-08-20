<?php

use App\Enums\Permission;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


/**
 * ******************************************
 * Available Public Routes
 * ******************************************
 */


 
Route::post('/token', [UserController::class, 'token']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forget-password', [UserController::class, 'forgetPassword']);
Route::post('/verify-forget-password-token', [UserController::class, 'verifyForgetPasswordToken']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);

/**
 * ******************************************
 * Authorized Route for Customers only
 * ******************************************
 */

Route::group(['middleware' => ['can:' . Permission::CUSTOMER, 'auth:sanctum']], function () {
    Route::get('user', [UserController::class, 'user']);
});

/**
 * ******************************************
 * Authorized Route for Staff & Store Owner
 * ******************************************
 */

Route::group(
    ['middleware' => ['permission:' . Permission::STAFF . '|' . Permission::STORE_OWNER, 'auth:sanctum']],
    function () {
        // Route::apiResource('products', ProductController::class, [
        //     'only' => ['store', 'update', 'destroy'],
        // ]);
    }
);

/**
 * *****************************************
 * Authorized Route for Store owner Only
 * *****************************************
 */

Route::group(
    ['middleware' => ['permission:' . Permission::STORE_OWNER, 'auth:sanctum']],
    function () {
        // Route::apiResource('shops', ShopController::class, [
        //     'only' => ['store', 'update', 'destroy'],
        // ]);
    }
);

/**
 * *****************************************
 * Authorized Route for Super Admin only
 * *****************************************
 */

Route::group(['middleware' => ['permission:' . Permission::SUPER_ADMIN, 'auth:sanctum']], function () {
    
    Route::post('users/block-user', [UserController::class, 'banUser']);
    Route::post('users/unblock-user', [UserController::class, 'activeUser']);
});


/**
 * *****************************************
 * Authorized Route for delivery man only
 * *****************************************
 */

Route::group(['middleware' => ['permission:' . Permission::DELIVERY_MAN, 'auth:sanctum']], function () {
    // Route::apiResource('types', TypeController::class, [
    //     'only' => ['store', 'update', 'destroy'],
    // ]);
});

/**
 * *****************************************
 * Authorized Route for fitter man only
 * *****************************************
 */

Route::group(['middleware' => ['permission:' . Permission::FITTER_MAN, 'auth:sanctum']], function () {
    // Route::apiResource('types', TypeController::class, [
    //     'only' => ['store', 'update', 'destroy'],
    // ]);
});
