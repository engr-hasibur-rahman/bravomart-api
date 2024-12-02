<?php

use App\Enums\Permission;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


/**
 * *****************************************
 * Authorized Route
 * https://spatie.be/docs/laravel-permission/v6/basic-usage/middleware
 * *****************************************
 */

Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {


    // Product Brand Routing
    Route::group(['middleware' => ['permission:' .Permission::PRODUCT_BRAND_LIST->value]], function () {
        Route::get('product-brands', [ProductBrandController::class, 'index']);
    });
    Route::group(['middleware' => ['permission:' .Permission::PRODUCT_BRAND_ADD->value]], function () {
        Route::post('product-brands', [ProductBrandController::class, 'store']);
        Route::get('product-brands/{id}', [ProductBrandController::class, 'show']);
        Route::post('product-brands/status', [ProductBrandController::class, 'productBrandStatus']);
    });

    // Product Category Routing
    Route::group(['middleware' => ['permission:' .Permission::PRODUCT_CATEGORY_LIST->value]], function () {
        Route::get('product-categories', [ProductCategoryController::class, 'index']);
    });
    Route::group(['middleware' => ['permission:' .Permission::PRODUCT_CATEGORY_ADD->value]], function () {
        Route::post('product-categories', [ProductCategoryController::class, 'store']);
        Route::get('product-categories/{id}', [ProductCategoryController::class, 'show']);
        Route::post('product-categories/status', [ProductCategoryController::class, 'productCategoryStatus']);
    });

    // User Management
    Route::group(['middleware' => [getPermissionMiddleware('ban-user')]], function () {
        Route::post('users/block-user', [UserController::class, 'banUser']);
    });
    Route::group(['middleware' => [getPermissionMiddleware('active-user')]], function () {
        Route::post('users/unblock-user', [UserController::class, 'activeUser']);
    });

    //Product Attribute Management
    Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
        Route::get('product/attribute/list', [ProductAttributeController::class, 'index']);
        Route::get('product/attribute/{id}', [ProductAttributeController::class, 'show']);
        Route::post('product/attribute/add', [ProductAttributeController::class, 'store']);
        Route::post('product/attribute/update', [ProductAttributeController::class, 'update']);
        Route::put('product/attribute/status/{id}', [ProductAttributeController::class, 'status_update']);
        Route::delete('product/attribute/remove/{id}', [ProductAttributeController::class, 'destroy']);
    });



     //Product Management 
     Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
        Route::get('product/list', [ProductController::class, 'index']);
        Route::get('product/{id}', [ProductController::class, 'show']);
        Route::post('product/add', [ProductController::class, 'store']);
        Route::post('product/update', [ProductAttributeController::class, 'update']);
        Route::put('product/status/{id}', [ProductController::class, 'status_update']);
        Route::delete('product/remove/{id}', [ProductController::class, 'destroy']);
    });
    // Product Author Management
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
        Route::get('product/author/list', [ProductAuthorController::class, 'index']);
        
    });
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::post('product/author/add', [ProductAuthorController::class, 'store']);
        Route::get('product/author/{id}', [ProductAuthorController::class, 'show']);
        Route::post('product/author/update', [ProductAuthorController::class, 'update']);
        Route::delete('product/author/remove/{id}', [ProductAuthorController::class, 'destroy']);
        Route::post('product/author/status', [ProductAuthorController::class, 'changeStatus']);
    });
    // Marketing Area Management
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
        Route::get('com/area/list', [AreaController::class, 'index']);
    });
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::get('com/area/{id}', [AreaController::class, 'show']);
        Route::post('com/area/add', [AreaController::class, 'store']);
        Route::post('com/area/update', [AreaController::class, 'update']);
        Route::put('com/area/status/{id}', [AreaController::class, 'changeStatus']);
        Route::delete('com/area/remove/{id}', [AreaController::class, 'destroy']);
    });

});
