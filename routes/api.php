<?php

use App\Enums\Permission;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RoleController;
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
Route::post('/logout', [UserController::class, 'logout']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('me', [UserController::class, 'me']);
});


Route::apiResource('/permissions', PermissionController::class);

Route::apiResource('/roles', RoleController::class);




/**
 * *****************************************
 * Authorized Route for Super Admin only
 * *****************************************
 */

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::apiResource('product-brands', ProductBrandController::class);

    Route::group(['middleware' => [getPermissionMiddleware('brand-list')]], function () {
        Route::get('product-brands', [ProductBrandController::class, 'index']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('add-product-brand')]], function () {

        Route::post('product-brands', [ProductBrandController::class, 'store']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('edit-product-brand')]], function () {
        Route::get('product-brands/{id}', [ProductBrandController::class, 'show']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('product-brand-status')]], function () {
        Route::post('product-brands/status', [ProductBrandController::class, 'productBrandStatus']);
    });




    // Route::apiResource('product-categories', ProductCategoryController::class);
    Route::get('product-categories', [ProductCategoryController::class, 'index']);
    Route::post('product-categories', [ProductCategoryController::class, 'store']);
    Route::get('product-categories/{id}', [ProductCategoryController::class, 'show']);
    Route::post('product-categories/status', [ProductCategoryController::class, 'productCategoryStatus']);

    Route::post('users/block-user', [UserController::class, 'banUser']);
    Route::post('users/unblock-user', [UserController::class, 'activeUser']);
});
