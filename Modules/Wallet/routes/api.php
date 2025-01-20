<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\V1\Seller\SellerWithdrawController;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\Api\WalletManageAdminController;
use Modules\Wallet\app\Http\Controllers\Api\WalletCommonController;


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
    Route::prefix('seller/store/financial/wallet')->middleware(['permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WALLET->value])->group(function () {
        // seller wallet
        Route::get('/', [WalletCommonController::class, 'myWallet']);
        Route::post('deposit', [WalletCommonController::class, 'depositCreate']);
        Route::get('transactions', [WalletCommonController::class, 'transactionRecords']);

        // withdraw history
        Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS->value], function () {
            Route::get('withdraw', [SellerWithdrawController::class, 'withdrawHistory']);
        });
    });

    // deliveryman wallet routes
    Route::group(['prefix' => 'deliveryman/wallet'], function () {
        Route::get('/', [WalletCommonController::class, 'myWallet']);
        Route::post('deposit', [WalletCommonController::class, 'depositCreate']);
        Route::get('transactions', [WalletCommonController::class, 'transactionRecords']);
    });

    // Customer Wallet
    Route::group(['prefix' => 'customer/wallet'], function () {
        Route::get('/', [WalletCommonController::class, 'myWallet']);
        Route::post('deposit', [WalletCommonController::class, 'depositCreate']);
        Route::get('transactions', [WalletCommonController::class, 'transactionRecords']);
    });

});
