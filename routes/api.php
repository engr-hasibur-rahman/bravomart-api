<?php

use App\Enums\Permission;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\V1\Product\AttributeController;
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
Route::post('/logout', [UserController::class, 'logout']);

Route::post('/store/ownerreg', [UserController::class, 'StoreOwnerRegistration']);

/* Partner (Shop Owner/Shop Staff/Delivery-Man/FitterMan Login) Login */
Route::post('partner/login', [PartnerLoginController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('me', [UserController::class, 'me']);
    Route::apiResource('/staff', StaffController::class);
    Route::get('staff/{id}', [StaffController::class, 'show']);
    Route::post('staff/update', [StaffController::class, 'update']);
    Route::post('staff/change-status/{id}/{is_active}', [StaffController::class, 'changestatus']);

    // Route::get('/permissions', PermissionController::class);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('permissions-for-store-owner', [PermissionController::class, 'permissionForStoreOwner']);
    Route::get('module-wise-permissions', [PermissionController::class, 'moduleWisePermissions']);


    // Route::apiResource('/roles', RoleController::class);
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::post('roles-status-update', [RoleController::class, 'roleForStoreOwner']);
});
