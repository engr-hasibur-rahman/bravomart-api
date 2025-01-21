<?php

use App\Http\Controllers\Api\V1\Customer\CustomerAddressManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerManageController as CustomerManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerOrderController;
use App\Http\Controllers\Api\V1\Customer\CustomerSupportTicketManageController;
use App\Http\Controllers\Api\V1\Customer\WishListManageController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Customer\OrderPaymentController;
use App\Http\Controllers\Customer\PlaceOrderController;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => 'customer/', 'middleware' => ['auth:api_customer', 'check.customer.account.status']], function () {
     // media manage
    Route::group(['prefix' => 'media-upload'], function () {
        Route::post('/store', [MediaController::class, 'mediaUpload']);
        Route::get('/load-more', [MediaController::class, 'load_more']);
        Route::post('/alt', [MediaController::class, 'alt_change']);
        Route::post('/delete', [MediaController::class, 'delete_media']);
    });
    Route::group(['middleware' => ['check.email.verification.option']], function () {
        Route::group(['prefix' => 'profile/'], function () {
            Route::get('/', [CustomerManageController::class, 'getProfile']);
            Route::post('/update', [CustomerManageController::class, 'updateProfile']);
            Route::post('/change-email', [CustomerManageController::class, 'updateEmail']);
            Route::get('/deactivate', [CustomerManageController::class, 'deactivateAccount']);
            Route::get('/delete', [CustomerManageController::class, 'deleteAccount']);
        });
        Route::group(['prefix' => 'address/'], function () {
            Route::post('add', [CustomerAddressManageController::class, 'store']);
            Route::post('update', [CustomerAddressManageController::class, 'update']);
            Route::get('customer-addresses', [CustomerAddressManageController::class, 'index']);
            Route::get('customer-address', [CustomerAddressManageController::class, 'show']);
            Route::post('make-default', [CustomerAddressManageController::class, 'defaultAddress']);
            Route::delete('remove/{id}', [CustomerAddressManageController::class, 'destroy']);
        });
        Route::group(['prefix' => 'support-ticket'], function () {
            Route::get('list', [CustomerSupportTicketManageController::class, 'index']);
            Route::post('store', [CustomerSupportTicketManageController::class, 'store']);
            Route::post('update', [CustomerSupportTicketManageController::class, 'update']);
            Route::get('details', [CustomerSupportTicketManageController::class, 'show']);
            Route::get('resolve', [CustomerSupportTicketManageController::class, 'resolve']);
            Route::post('add-message', [CustomerSupportTicketManageController::class, 'addMessage']);
            Route::get('messages', [CustomerSupportTicketManageController::class, 'getTicketMessages']);
        });
        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('list', [WishListManageController::class, 'getWishlist']);
            Route::post('store', [WishListManageController::class, 'addToWishlist']);
            Route::post('remove', [WishListManageController::class, 'removeFromWishlist']);
        });
         // order manage
        Route::group(['prefix' => 'orders/'], function () {
            Route::get('list', [CustomerOrderController::class, 'myOrders']);
        });
    });

    // customer place order
    Route::post('orders/checkout', [PlaceOrderController::class, 'placeOrder']);
    Route::post('orders/payment-status-update', [OrderPaymentController::class, 'orderPaymentStatusUpdate']);

    // customer verify email
    Route::post('send-verification-email', [CustomerManageController::class, 'sendVerificationEmail']);
    Route::post('verify-email', [CustomerManageController::class, 'verifyEmail']);
    Route::post('resend-verification-email', [CustomerManageController::class, 'resendVerificationEmail']);
});
