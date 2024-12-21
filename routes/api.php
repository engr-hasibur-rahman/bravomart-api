<?php

use App\Enums\Permission;
use App\Http\Controllers\Api\V1\SliderManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\Store\StoreController;
use App\Http\Controllers\Api\V1\Auth\PartnerLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


/**
 * ******************************************
 * Available Public Routes
 * ******************************************
 */


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

    // Routes for managing general user-related actions, such as profile information and other user account operations.
    Route::group(['prefix' => 'user/'], function () {
        Route::get('me', [UserController::class, 'me']);
        Route::get('profile', [UserController::class, 'userProfile']);
        Route::post('/profile-edit', [UserController::class, 'userProfileUpdate']);
        Route::post('/email-change', [UserController::class, 'userEmailUpdate']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
});