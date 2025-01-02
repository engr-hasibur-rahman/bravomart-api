<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\WalletController;
use Modules\Wallet\app\Http\Controllers\WalletTransactionController;


Route::middleware(['auth:sanctum', 'permission:' . PermissionKey::ADMIN_WALLET_MANAGE->value])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'admin/wallet'], function () {
        // Wallet settings
        Route::match(['get','post'], 'settings', [WalletController::class, 'depositSettings']);
        // Wallet list
        Route::get('lists', [WalletController::class, 'index']);
        // Wallet status
        Route::get('status/{id?}', [WalletController::class, 'status']);
        // Create deposit by admin
        Route::post('deposit-create', [WalletController::class, 'depositCreateByAdmin']);
        // Wallet transaction records
        Route::get('transactions/records', [WalletTransactionController::class, 'records']);
        // Transaction status
        Route::get('transactions/status/{id}', [WalletTransactionController::class, 'transactionStatus']);
    });
 });