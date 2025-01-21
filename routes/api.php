<?php

use App\Http\Controllers\Api\V1\ContactManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Auth\PartnerLoginController;
use Illuminate\Support\Facades\Route;

/* Admin Login */
Route::post('/token', [UserController::class, 'token']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forget-password', [UserController::class, 'forgetPassword']);
Route::post('/verify-forget-password-token', [UserController::class, 'verifyForgetPasswordToken']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/store/ownerreg', [UserController::class, 'StoreOwnerRegistration']);
/* Partner (Shop Owner/Shop Staff/Delivery-Man/FitterMan Login) Login */
Route::post('partner/login', [PartnerLoginController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getpermissions', [PermissionController::class, 'getpermissions']);
    Route::get('/get-roles', [PermissionController::class, 'getRoles']);
    Route::post('/logout', [UserController::class, 'logout']);
    // Routes for managing general user-related actions, such as profile information and other user account operations.
    Route::group(['prefix' => 'user/'], function () {
        Route::get('me', [UserController::class, 'me']);
        Route::get('profile', [UserController::class, 'userProfile']);
        Route::post('/profile-edit', [UserController::class, 'userProfileUpdate']);
        Route::post('/email-change', [UserController::class, 'userEmailUpdate']);
    });
});
Route::post('contact-us', [ContactManageController::class, 'store']);