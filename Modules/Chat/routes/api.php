<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\app\Http\Controllers\Api\ChatController;


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('chat/start', [ChatController::class, 'startChat']);
    Route::post('chat/send', [ChatController::class, 'sendMessage']);
    Route::get('chat/messages/{chatId}', [ChatController::class, 'fetchMessages']);
    Route::post('chat/seen', [ChatController::class, 'markAsSeen']);
});
