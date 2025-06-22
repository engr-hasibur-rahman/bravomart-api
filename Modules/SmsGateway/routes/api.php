<?php

use App\Enums\PermissionKey;
use Illuminate\Support\Facades\Route;
use Modules\SmsGateway\app\Http\Controllers\Api\V1\SmsProviderController;
use Modules\SmsGateway\app\Http\Controllers\Api\V1\UserOtpController;


//  Admin Sms settings
Route::middleware(['auth:sanctum','online.track'])->prefix('v1/admin/sms-provider/')->group(function () {
    Route::prefix('settings')->middleware(['permission:' . PermissionKey::ADMIN_CHAT_SETTINGS->value])->group(function () {
        Route::post('update', [SmsProviderController::class, 'smsProviderSettingUpdate']);
        Route::post('status-update', [SmsProviderController::class, 'smsProviderStatusUpdate']);
        Route::post('otp-login-status', [SmsProviderController::class, 'smsProviderLoginStatus']);
    });
});

// global opt manage
Route::middleware(['auth:sanctum'])->prefix('v1/otp-login/')->group(function () {
    Route::post('send', [UserOtpController::class, 'sendOtp']);
    Route::post('verification', [UserOtpController::class, 'verificationOtp']);
    Route::post('resend', [UserOtpController::class, 'resendOtp']);
});
