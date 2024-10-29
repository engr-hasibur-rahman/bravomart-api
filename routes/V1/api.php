<?php

use App\Enums\Permission;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


/**
 * ******************************************
 * Available Public Routes
 * ******************************************
 */




/**
 * *****************************************
 * Authorized Route
 * *****************************************
 */

Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {


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
        Route::get('product/attribute/list', [ProductAttributeController::class, 'index']);
        Route::get('product/attribute/{id}', [ProductAttributeController::class, 'show']);
        Route::post('product/attribute/add', [ProductAttributeController::class, 'store']);
        Route::post('product/attribute/update/{id}', [ProductAttributeController::class, 'update']);
        Route::put('product/attribute/status/{id}', [ProductAttributeController::class, 'status_update']);
        Route::delete('product/attribute/remove/{id}', [ProductAttributeController::class, 'destroy']);
    });


    Route::group(['middleware' => [getPermissionMiddleware(Permission::ADMIN_AREA_ADD->value)]], function () {
        Route::get('com/area/list', [AreaController::class, 'index']);
        Route::get('com/area/{id}', [AreaController::class, 'show']);
        Route::post('com/area/add', [AreaController::class, 'store']);
        Route::post('com/area/update/{id}', [AreaController::class, 'update']);
        Route::put('com/area/status/{id}', [AreaController::class, 'changeStatus']);
        Route::delete('com/area/remove/{id}', [AreaController::class, 'destroy']);
    });
    Route::group(['middleware' => [getPermissionMiddleware(Permission::ADMIN_AREA_UPDATE->value)]], function () {
        Route::get('com/area/list', [AreaController::class, 'index']);
        Route::get('com/area/{id}', [AreaController::class, 'show']);
        Route::post('com/area/add', [AreaController::class, 'store']);
        Route::post('com/area/update/{id}', [AreaController::class, 'update']);
        Route::put('com/area/status/{id}', [AreaController::class, 'changeStatus']);
        Route::delete('com/area/remove/{id}', [AreaController::class, 'destroy']);
    });
});
