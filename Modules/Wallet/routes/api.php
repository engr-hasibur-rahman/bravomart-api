<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\V1\Seller\SellerWithdrawController;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\Api\WalletCustomerController;
use Modules\Wallet\app\Http\Controllers\Api\WalletManageAdminController;
use Modules\Wallet\app\Http\Controllers\Api\WalletSellerController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::middleware([PermissionKey::ADMIN_WALLET_MANAGE->value])->prefix('v1')->group(function () {
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
    });

    // seller wallet routes
    Route::prefix('seller/store/financial/wallet/')->middleware(['permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WALLET->value])->group(function () {
        // seller wallet
        Route::get('wallet', [SellerWithdrawController::class, 'myWallet']);
        Route::get('list', [WalletSellerController::class, 'index']);
        Route::post('deposit', [WalletSellerController::class, 'depositCreate']);
        Route::get('transactions', [WalletSellerController::class, 'transactionRecords']);

        // withdraw history
        Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS->value], function () {
            Route::get('withdraw', [SellerWithdrawController::class, 'withdrawHistory']);
        });
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
