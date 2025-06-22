<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\SmsGateway\app\Http\Controllers\Api\V1\SmsProviderController;


//  Admin Sms settings
Route::middleware(['auth:sanctum','online.track'])->prefix('v1/admin/sms-provider/')->group(function () {
    Route::prefix('settings')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_SETTINGS->value])->group(function () {
        Route::post('update', [SmsProviderController::class, 'smsProviderSettingUpdate']);
        Route::post('status-update', [SmsProviderController::class, 'smsProviderStatusUpdate']);
        Route::post('status-update', [SmsProviderController::class, 'smsProviderStatusUpdate']);
    });
});

//  Customer
Route::middleware(['auth:sanctum','online.track'])->prefix('v1/customer/chat/')->group(function () {
    Route::get('list/', [CustomerChatController::class, 'customerChatList']);
    Route::post('send', [CustomerChatController::class, 'customerSendMessage']);
    Route::get('messages-details', [CustomerChatController::class, 'chatWiseFetchMessages']);
    Route::post('chat/seen', [CustomerChatController::class, 'markAsSeen']);
});

//  deliveryman
Route::middleware(['auth:sanctum','online.track'])->prefix('v1/deliveryman/chat/')->group(function () {
    Route::get('list/', [DeliverymanChatController::class, 'deliverymanChatList']);
    Route::post('send', [ChatController::class, 'sendMessage']);
    Route::get('messages-details', [DeliverymanChatController::class, 'deliverymanChatWiseFetchMessages']);
    Route::post('chat/seen', [DeliverymanChatController::class, 'markAsSeen']);
});
