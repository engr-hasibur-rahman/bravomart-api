<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionPackageController;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionSellerController;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionTypeController;
use Modules\Subscription\app\Http\Controllers\SubscriptionController;
use Modules\Subscription\Http\Controllers\Api\AdminSubscriptionSettingsController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'subscription/'], function () {
        //  subscription type
        Route::prefix('type')->middleware(['permission:' . PermissionKey::ADMIN_SUBSCRIPTION_PACKAGE_TYPE_MANAGE->value])->group(function () {
            Route::get('list', [AdminSubscriptionTypeController::class, 'index']);
            Route::post('add', [AdminSubscriptionTypeController::class, 'store']);
            Route::get('edit/{id}', [AdminSubscriptionTypeController::class, 'show']);
            Route::patch('statusChange', [AdminSubscriptionTypeController::class, 'statusChange']);
            Route::delete('delete/{id}', [AdminSubscriptionTypeController::class, 'destroy']);
        });
        //  subscription package
        Route::prefix('package')->middleware(['permission:' . PermissionKey::ADMIN_SUBSCRIPTION_PACKAGE_MANAGE->value])->group(function () {
            Route::get('list', [AdminSubscriptionPackageController::class, 'index']);
            Route::post('add', [AdminSubscriptionPackageController::class, 'store']);
            Route::get('edit/{id}', [AdminSubscriptionPackageController::class, 'show']);
            Route::patch('statusChange', [AdminSubscriptionPackageController::class, 'statusChange']);
            Route::delete('delete/{id}', [AdminSubscriptionPackageController::class, 'destroy']);
        });
        // seller list
        Route::prefix('seller')->middleware(['permission:' . PermissionKey::ADMIN_SUBSCRIPTION_SELLER_PACKAGE_MANAGE->value])->group(function () {
            Route::get('list', [AdminSubscriptionSellerController::class, 'index']);
            Route::post('add', [AdminSubscriptionSellerController::class, 'store']);
            Route::get('edit/{id}', [AdminSubscriptionSellerController::class, 'show']);
            Route::patch('statusChange', [AdminSubscriptionSellerController::class, 'statusChange']);
        });
        // settings
        Route::get('settings', [AdminSubscriptionSettingsController::class, 'index'])->middleware(['permission:' . PermissionKey::ADMIN_SUBSCRIPTION_SETTINGS->value]);
    });
});