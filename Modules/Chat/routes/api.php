<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\Chat\app\Http\Controllers\Api\AdminChatManageController;
use Modules\Chat\app\Http\Controllers\Api\ChatController;


//  Admin Chat manage
Route::middleware(['auth:sanctum'])->prefix('v1/admin/chat/')->group(function () {
    Route::prefix('settings')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_SETTINGS->value])->group(function () {
        Route::match(['get', 'post'], '/', [AdminChatManageController::class, 'chatPusherSettings']);
    });
    Route::prefix('list')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_MANAGE->value])->group(function () {
        Route::get('/', [AdminChatManageController::class, 'index']);
    });
});

// admin, store, customer, deliveryman common routes
Route::middleware(['auth:sanctum'])->prefix('v1/admin/')->group(function () {
    Route::post('chat/start', [ChatController::class, 'startChat']);
    Route::post('chat/send', [ChatController::class, 'sendMessage']);
    Route::get('chat/messages/{chatId}', [ChatController::class, 'fetchMessages']);
    Route::post('chat/seen', [ChatController::class, 'markAsSeen']);
});
