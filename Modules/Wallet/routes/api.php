<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\Api\WalletCustomerController;
use Modules\Wallet\app\Http\Controllers\Api\WalletManageAdminController;
use Modules\Wallet\app\Http\Controllers\Api\WalletSellerController;


Route::middleware(['auth:sanctum', 'permission:' . PermissionKey::ADMIN_WALLET_MANAGE->value])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/wallet'], function () {
        // Wallet settings
        Route::match(['get','post'], 'settings', [WalletManageAdminController::class, 'depositSettings']);
        // Wallet list
        Route::get('lists', [WalletManageAdminController::class, 'index']);
        // Wallet status
        Route::post('status/{id?}', [WalletManageAdminController::class, 'status']);
        // Create deposit by admin
        Route::post('deposit', [WalletManageAdminController::class, 'depositCreateByAdmin']);
        // Wallet transaction records
        Route::get('transactions', [WalletManageAdminController::class, 'transactionRecords']);
        // Transaction status
        Route::post('transactions-status/{id}', [WalletManageAdminController::class, 'transactionStatus']);
    });

    Route::group(['prefix' => 'seller/wallet'], function () {
        // Wallet list
        Route::get('lists', [WalletSellerController::class, 'index']);
        // Create deposit by admin
        Route::post('deposit', [WalletSellerController::class, 'depositCreate']);
        // Wallet transaction records
        Route::get('transactions', [WalletSellerController::class, 'transactionRecords']);
    });

    Route::group(['prefix' => 'customer/wallet'], function () {
        // Wallet list
        Route::get('lists', [WalletCustomerController::class, 'index']);
        // Create deposit by admin
        Route::post('deposit', [WalletCustomerController::class, 'depositCreate']);
        // Wallet transaction records
        Route::get('transactions', [WalletCustomerController::class, 'transactionRecords']);
    });
 });