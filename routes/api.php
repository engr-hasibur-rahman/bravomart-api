<?php

use App\Enums\Permission;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
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



/**
 * *****************************************
 * Authorized Route
 * *****************************************
 */

Route::group(['middleware' => ['auth:sanctum']], function () {


    Route::get('me', [UserController::class, 'me']);


    // Route::get('/permissions', PermissionController::class);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('permissions-for-store-owner', [PermissionController::class, 'permissionForStoreOwner']);
    Route::get('module-wise-permissions', [PermissionController::class, 'moduleWisePermissions']);


    // Route::apiResource('/roles', RoleController::class);
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::post('roles-for-store-owner', [RoleController::class, 'roleForStoreOwner']);


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
    Route::group(['middleware' => [getPermissionMiddleware('category-list')]], function () {
        Route::get('product-categories', [ProductCategoryController::class, 'index']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('category-store')]], function () {
        Route::post('product-categories', [ProductCategoryController::class, 'store']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('category-show')]], function () {
        Route::get('product-categories/{id}', [ProductCategoryController::class, 'show']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('category-status')]], function () {
        Route::post('product-categories/status', [ProductCategoryController::class, 'productCategoryStatus']);
    });


    Route::group(['middleware' => [getPermissionMiddleware('ban-user')]], function () {
        Route::post('users/block-user', [UserController::class, 'banUser']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('active-user')]], function () {
        Route::post('users/unblock-user', [UserController::class, 'activeUser']);
    });

    Route::group(['middleware' => [getPermissionMiddleware('product-attribute')]], function () {
        Route::apiResource('/product-attribute', ProductAttributeController::class);
    });
});

