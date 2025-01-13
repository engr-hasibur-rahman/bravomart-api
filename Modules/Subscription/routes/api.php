<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionPackageController;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionSellerController;
use Modules\Subscription\app\Http\Controllers\Api\AdminSubscriptionSettingsController;

Route::middleware(['auth:sanctum'])->prefix('v1/admin/business-operations/subscription/')->group(function () {
        //  subscription package
        Route::prefix('package/')->middleware(['permission:' . PermissionKey::ADMIN_SUBSCRIPTION_PACKAGE_MANAGE->value])->group(function () {
            Route::get('list', [AdminSubscriptionPackageController::class, 'index']);
            Route::post('store', [AdminSubscriptionPackageController::class, 'store']);
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
