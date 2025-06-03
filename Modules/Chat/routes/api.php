<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Chat\app\Http\Controllers\Api\AdminChatManageController;
use Modules\Chat\app\Http\Controllers\Api\ChatController;
use Modules\Chat\app\Http\Controllers\Api\ChatManageController;
use Modules\Chat\app\Http\Controllers\Api\DeliverymanChatController;
use Modules\Chat\app\Http\Controllers\Api\StoreChatController;
use Modules\Chat\app\Http\Controllers\Api\CustomerChatController;


//  Admin Chat manage
Route::middleware(['auth:sanctum'])->prefix('v1/admin/chat/')->group(function () {
    Route::prefix('settings')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_SETTINGS->value])->group(function () {
        Route::match(['get', 'post'], '/', [AdminChatManageController::class, 'chatPusherSettings']);
    });

    // prefix manage
    Route::prefix('manage/')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_MANAGE->value])->group(function () {
        Route::get('list', [ChatController::class, 'adminChatList']);
        Route::post('send', [ChatController::class, 'sendMessage']);
        Route::get('messages-details', [ChatController::class, 'chatWiseFetchMessages']);
        Route::post('chat/seen', [ChatController::class, 'markAsSeen']);
    });
});

//  Seller Chat manage
Route::middleware(['auth:sanctum'])->prefix('v1/seller/store/')->group(function () {
    Route::prefix('chat')->middleware(['permission:' . PermissionKey::SELLER_CHAT_MANAGE->value])->group(function () {
        Route::get('list', [StoreChatController::class, 'chatList']);
        Route::post('send', [ChatController::class, 'sendMessage']);
        Route::get('messages-details', [StoreChatController::class, 'chatWiseFetchMessages']);
        Route::post('chat/seen', [StoreChatController::class, 'markAsSeen']);
    });
});

//  Customer Chat manage
Route::middleware(['auth:sanctum'])->prefix('v1/customer/chat/')->group(function () {
    Route::get('list/', [CustomerChatController::class, 'customerChatList']);
    Route::post('send', [CustomerChatController::class, 'customerSendMessage']);
    Route::get('messages-details', [CustomerChatController::class, 'chatWiseFetchMessages']);
    Route::post('chat/seen', [CustomerChatController::class, 'markAsSeen']);
});

//  deliveryman Chat manage
Route::middleware(['auth:sanctum'])->prefix('v1/deliveryman/chat/')->group(function () {
    Route::get('list/', [DeliverymanChatController::class, 'deliverymanChatList']);
    Route::post('send', [ChatController::class, 'sendMessage']);
    Route::get('messages-details', [DeliverymanChatController::class, 'deliverymanChatWiseFetchMessages']);
    Route::post('chat/seen', [DeliverymanChatController::class, 'markAsSeen']);
});


// pusher info
Route::middleware(['auth:sanctum'])->prefix('v1/')->group(function () {
    Route::get('/chat-credentials', [ChatManageController::class, 'getChatCredentials']);
});
