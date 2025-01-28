<?php

use App\Http\Controllers\Api\V1\Blog\BlogManageController;
use App\Http\Controllers\Api\V1\Com\ComSiteGeneralController;
use App\Http\Controllers\APi\V1\Com\HeaderFooterController;
use App\Http\Controllers\Api\V1\Com\SubscriberManageController;
use App\Http\Controllers\Api\V1\ContactManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerManageController;
use App\Http\Controllers\Api\V1\FrontendController;
use App\Http\Controllers\Api\V1\Seller\SellerManageController;
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


/*--------------------- Route without auth  ----------------------------*/
Route::group(['prefix' => 'v1/'], function () {
    // For customer register and login
    Route::group(['prefix' => 'customer/'], function () {
        Route::post('registration', [CustomerManageController::class, 'register']);
        Route::post('login', [CustomerManageController::class, 'login']);
        Route::post('forget-password', [CustomerManageController::class, 'forgetPassword']);
        Route::post('verify-token', [CustomerManageController::class, 'verifyToken']);
        Route::post('reset-password', [CustomerManageController::class, 'resetPassword']);
    });
    Route::group(['prefix' => 'seller/'], function () {
        // password reset
        Route::post('forget-password', [SellerManageController::class, 'forgetPassword']);
        Route::post('verify-token', [SellerManageController::class, 'verifyToken']);
        Route::post('reset-password', [SellerManageController::class, 'resetPassword']);
    });
    // Blog comment manage
    Route::post('blog/comment', [BlogManageController::class, 'comment']);
    Route::group(['prefix' => 'auth'], function () {
        Route::get('google', [UserController::class, 'redirectToGoogle']);
        Route::get('google/callback', [UserController::class, 'handleGoogleCallback']);
        Route::post('forget-password', [UserController::class, 'forgetPassword']);
        Route::post('verify-token', [UserController::class, 'verifyForgetPasswordToken']);
        Route::post('reset-password', [UserController::class, 'resetPassword']);
    });
    // Product Category
    Route::group(['prefix' => 'product-category/'], function () {
        Route::get('list', [FrontendController::class, 'productCategoryList']);
        Route::get('product', [FrontendController::class, 'categoryWiseProducts']);
    });

    // public routes for frontend
    Route::get('/slider-list', [FrontendController::class, 'allSliders']);
    Route::get('/product-list', [FrontendController::class, 'productList']);
    Route::get('/product/{product_slug}', [FrontendController::class, 'productDetails']);
    Route::post('/new-arrivals', [FrontendController::class, 'getNewArrivals']);
    Route::post('/best-selling-products', [FrontendController::class, 'getBestSellingProduct']);
    Route::get('/week-best-products', [FrontendController::class, 'getWeekBestProducts']);
    Route::get('/popular-products', [FrontendController::class, 'getPopularProducts']);
    Route::post('/top-deal-products', [FrontendController::class, 'getTopDeals']);
    Route::get('/banner-list', [FrontendController::class, 'index']);
    Route::post('/subscribe', [SubscriberManageController::class, 'subscribe']);
    Route::post('/unsubscribe', [SubscriberManageController::class, 'unsubscribe']);
    Route::get('/country-list', [FrontendController::class, 'countriesList']);
    Route::get('/state-list', [FrontendController::class, 'statesList']);
    Route::get('/city-list', [FrontendController::class, 'citiesList']);
    Route::get('/areas', [FrontendController::class, 'areas']);
    Route::get('/area-list', [FrontendController::class, 'areaList']);
    Route::get('/tag-list', [FrontendController::class, 'tagList']);
    Route::get('/brand-list', [FrontendController::class, 'brandList']);
    Route::get('/product/attribute-list', [FrontendController::class, 'productAttributeList']);
    Route::get('/store-types', [FrontendController::class, 'storeTypeList']);
    Route::get('/behaviour-list', [FrontendController::class, 'behaviourList']);
    Route::get('/unit-list', [FrontendController::class, 'unitList']);
    Route::get('/customer-list', [FrontendController::class, 'customerList']);
    Route::get('/store-list', [FrontendController::class, 'getStores']);
    Route::get('/store-details/{slug}', [FrontendController::class, 'getStoreDetails']);
    Route::get('/department-list', [FrontendController::class, 'departmentList']);
    Route::get('/flash-deals', [FrontendController::class, 'flashDeals']);
    Route::get('/flash-deal-products', [FrontendController::class, 'flashDealProducts']);
    Route::get('/product-suggestion', [FrontendController::class, 'getSearchSuggestions']);
    Route::get('/keyword-suggestion', [FrontendController::class, 'getKeywordSuggestions']);
    Route::get('/check-coupon', [FrontendController::class, 'checkCoupon']);

    // home page footer api route
    Route::get('/footer', [HeaderFooterController::class, 'siteFooterInfo']);
    Route::get('/site-general-info', [ComSiteGeneralController::class, 'siteGeneralInfo']);
});
