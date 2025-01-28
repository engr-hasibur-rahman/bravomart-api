<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\Api\AdminWithdrawGatewayManageController;
use Modules\Wallet\app\Http\Controllers\Api\AdminWithdrawManageController;
use Modules\Wallet\app\Http\Controllers\Api\AdminWithdrawRequestManageController;
use Modules\Wallet\app\Http\Controllers\Api\SellerAndDeliverymanWithdrawController;
use Modules\Wallet\app\Http\Controllers\Api\WalletManageAdminController;
use Modules\Wallet\app\Http\Controllers\Api\WalletCommonController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // admin wallet manage
    Route::group(['prefix' => 'admin/wallet', PermissionKey::ADMIN_WALLET_MANAGE->value], function () {
        Route::match(['get','post'], 'settings', [WalletManageAdminController::class, 'depositSettings'])->middleware(['permission:' . PermissionKey::ADMIN_WALLET_SETTINGS->value]);
        Route::get('list', [WalletManageAdminController::class, 'index']);
        Route::post('status/{id?}', [WalletManageAdminController::class, 'status']);
        Route::post('deposit', [WalletManageAdminController::class, 'depositCreateByAdmin']);
        Route::get('transactions', [WalletManageAdminController::class, 'transactionRecords'])->middleware(['permission:' . PermissionKey::ADMIN_WALLET_TRANSACTION->value]);
        Route::post('transactions-status/{id}', [WalletManageAdminController::class, 'transactionStatus']);

        // withdraw gateway lists add
        Route::group(['prefix' => 'withdraw/'], function () {
            Route::get('/', [AdminWithdrawManageController::class, 'withdrawAllList']);
            Route::get('/details/{id?}', [AdminWithdrawManageController::class, 'withdrawDetails']);
            // gateway manage
            Route::get('/gateway-list', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayList']);
            Route::post('/gateway-add', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayAdd']);
            // withdraw request manage
            Route::post('/request-list', [AdminWithdrawRequestManageController::class, 'withdrawRequestList']);
            Route::post('/request-approve', [AdminWithdrawRequestManageController::class, 'withdrawRequestApprove']);
            Route::post('/request-reject', [AdminWithdrawRequestManageController::class, 'withdrawRequestReject']);
        });

    });

    // seller wallet routes
    Route::prefix('seller/store/financial/')->middleware(['permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WALLET->value])->group(function () {
        // seller wallet
        Route::group(['prefix' => 'wallet/'], function () {
            Route::get('/', [WalletCommonController::class, 'myWallet']);
            Route::post('deposit', [WalletCommonController::class, 'depositCreate']);
            Route::get('transactions', [WalletCommonController::class, 'transactionRecords']);
        });
        // withdraw history
        Route::group(['prefix' => 'withdraw/', 'middleware' => 'permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS->value], function () {
            Route::get('/', [SellerAndDeliverymanWithdrawController::class, 'withdrawList']);
            Route::post('/withdraw-request', [SellerAndDeliverymanWithdrawController::class, 'withdrawRequest']);
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

    // wallet payment status update for common
    Route::post('wallet/payment-status-update', [WalletCommonController::class, 'paymentStatusUpdate']);

});
