<?php

use App\Enums\Permission;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\SystemManagementController;
use App\Http\Controllers\Api\V1\TagManageController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use App\Http\Controllers\Api\V1\CouponManageController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use App\Http\Controllers\Api\V1\Product\ProductVariantController;
use App\Http\Controllers\Api\V1\UnitManageController;
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


// =====================================================================FAYSAL IBNEA HASAN JESAN========================================================================================
     //Product Management 
     Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
        Route::get('product/list', [ProductController::class, 'index']);
        Route::get('product/{id}', [ProductController::class, 'show']);
        Route::post('product/add', [ProductController::class, 'store']);
        Route::post('product/update', [ProductController::class, 'update']);
        Route::put('product/status/{id}', [ProductController::class, 'status_update']);
        Route::delete('product/remove/{id}', [ProductController::class, 'destroy']);
        Route::get('product/deleted/records', [ProductController::class, 'deleted_records']);
    });
     //Product Variant Management 
     Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
        Route::get('product/variant/list', [ProductVariantController::class, 'index']);
        Route::get('product/variant/{id}', [ProductVariantController::class, 'show']);
        Route::post('product/variant/add', [ProductVariantController::class, 'store']);
        Route::post('product/variant/update', [ProductVariantController::class, 'update']);
        Route::put('product/variant/status/{id}', [ProductVariantController::class, 'status_update']);
        Route::delete('product/variant/remove/{id}', [ProductVariantController::class, 'destroy']);
        Route::get('product/variant/deleted/records', [ProductVariantController::class, 'deleted_records']);
    });
     //Coupon Management 
     Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
        Route::get('product/coupon/list', [CouponManageController::class, 'index']);
        Route::get('product/coupon/{id}', [CouponManageController::class, 'show']);
        Route::post('product/coupon/add', [CouponManageController::class, 'store']);
        Route::post('product/coupon/update', [CouponManageController::class, 'update']);
        Route::put('product/coupon/status/{id}', [CouponManageController::class, 'status_update']);
        Route::delete('product/coupon/remove/{id}', [CouponManageController::class, 'destroy']);
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
    // Tag Management
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
        Route::get('tag/list', [TagManageController::class, 'index']);
    });
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::post('tag/add', [TagManageController::class, 'store']);
        Route::get('tag/{id}', [TagManageController::class, 'show']);
        Route::post('tag/update', [TagManageController::class, 'update']);
        Route::delete('tag/remove/{id}', [TagManageController::class, 'destroy']);
    });
    // Unit Management
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
        Route::get('unit/list', [UnitManageController::class, 'index']);
    });
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::post('unit/add', [UnitManageController::class, 'store']);
        Route::get('unit/{id}', [UnitManageController::class, 'show']);
        Route::post('unit/update', [UnitManageController::class, 'update']);
        Route::delete('unit/remove/{id}', [UnitManageController::class, 'destroy']);
    });
    // =====================================================================FAYSAL IBNEA HASAN JESAN========================================================================================
    // Marketing Area Management T
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

    /*--------------------- Media Manage ----------------------------*/
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::group(['prefix' => 'media-upload'], function () {
            Route::post('/store',[MediaController::class, 'mediaUpload']);
            Route::get('/load-more',[MediaController::class, 'load_more']);
            Route::post('/alt',[MediaController::class, 'alt_change']);
            Route::post('/delete',[MediaController::class, 'delete_media']);
        });
    });

    /*--------------------- System management ----------------------------*/
    // General Settings T
    Route::group(['middleware' =>  ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::group(['prefix' => 'system-management'], function () {
            Route::match(['get', 'post'], '/general-settings',[SystemManagementController::class, 'generalSettings']);
        });
    });

    /* ==================================> vendor route start <================================= */
    Route::group(['prefix' => 'vendor/'], function () {        
        //Coupon Management
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('product/coupon/list', [CouponManageController::class, 'index']);
            Route::get('product/coupon/{id}', [CouponManageController::class, 'show']);
            Route::post('product/coupon/add', [CouponManageController::class, 'store']);
            Route::post('product/coupon/update', [CouponManageController::class, 'update']);
            Route::put('product/coupon/status/{id}', [CouponManageController::class, 'status_update']);
            Route::delete('product/coupon/remove/{id}', [CouponManageController::class, 'destroy']);
        });

    });
    /* ==================================> vendor route end <================================= */

});
