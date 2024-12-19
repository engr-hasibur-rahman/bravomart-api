<?php

use App\Enums\Permission;
use App\Http\Controllers\Api\V1\Admin\DepartmentManageController;
use App\Http\Controllers\Api\V1\Admin\LocationManageController;
use App\Http\Controllers\Api\V1\Admin\PaymentSettingsController;
use App\Http\Controllers\Api\V1\Blog\BlogManageController;
use App\Http\Controllers\Api\V1\Com\BannerManageController;
use App\Http\Controllers\Api\V1\Com\SubscriberManageController;
use App\Http\Controllers\Api\V1\Customer\AddressManageController;
use App\Http\Controllers\Api\V1\Dashboard\DashboardController;
use App\Http\Controllers\Api\V1\EmailSettingsController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\SliderManageController;
use App\Http\Controllers\Api\V1\SystemManagementController;
use App\Http\Controllers\Api\V1\TagManageController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\FrontendController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use App\Http\Controllers\Api\V1\Com\StoreManageController;
use App\Http\Controllers\Api\V1\CouponManageController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use App\Http\Controllers\Api\V1\Product\ProductVariantController;
use App\Http\Controllers\Api\V1\UnitManageController;
use Illuminate\Support\Facades\Route;

/*--------------------- Route without auth  ----------------------------*/
Route::group(['namespace' => 'Api\V1'], function () {
    Route::post('customer/registration', [UserController::class, 'register']);
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
    Route::get('/slider-list', [FrontendController::class, 'allSliders']);
    Route::get('/product-list', [FrontendController::class, 'productList']);
    Route::post('/product-details', [FrontendController::class, 'productDetails']);
    Route::post('/new-arrivals', [FrontendController::class, 'getNewArrivals']);
    Route::post('/best-selling-products', [FrontendController::class, 'getBestSellingProduct']);
    Route::post('/top-deal-products', [FrontendController::class, 'getTopDeals']);
    Route::get('/banner-list', [FrontendController::class, 'index']);
    Route::post('/subscribe', [SubscriberManageController::class, 'subscribe']);
    Route::post('/unsubscribe', [SubscriberManageController::class, 'unsubscribe']);
    Route::get('/country-list', [FrontendController::class, 'countriesList']);
    Route::get('/state-list', [FrontendController::class, 'statesList']);
    Route::get('/city-list', [FrontendController::class, 'citiesList']);
    Route::get('/area-list', [FrontendController::class, 'areasList']);
});
/*--------------------- Route without auth  ----------------------------*/
Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {
    /*--------------------- Com route start  ----------------------------*/
    Route::get('/logout', [UserController::class, 'logout']);
//    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
    // media manage
    Route::group(['prefix' => 'media-upload'], function () {
        Route::post('/store', [MediaController::class, 'mediaUpload']);
        Route::get('/load-more', [MediaController::class, 'load_more']);
        Route::post('/alt', [MediaController::class, 'alt_change']);
        Route::post('/delete', [MediaController::class, 'delete_media']);
    });
//    });


    // Marketing area manage
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
        Route::get('com/area/list', [AreaController::class, 'index']);
    });
    Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        Route::get('com/area/{id}', [AreaController::class, 'show']);
        Route::post('com/area/add', [AreaController::class, 'store']);
        Route::post('com/area/update', [AreaController::class, 'update']);
        Route::put('com/area/status/{id}', [AreaController::class, 'changeStatus']);
        Route::delete('com/area/remove/{id}', [AreaController::class, 'destroy']);
    });
    /*--------------------- Com route end  ----------------------------*/


    /* --------------------- Admin route start ------------------------- */
    Route::group(['prefix' => 'admin/'], function () {
        // Department manage
        Route::group(['prefix' => 'department/'], function () {
            Route::get('list', [DepartmentManageController::class, 'index']);
            Route::post('add', [DepartmentManageController::class, 'store']);
            Route::get('{id}', [DepartmentManageController::class, 'show']);
            Route::post('update', [DepartmentManageController::class, 'update']);
            Route::delete('remove/{id}', [DepartmentManageController::class, 'destroy']);
        });
        // Dashboard manage
        Route::group(['prefix' => 'dashboard/'], function () {
            Route::get('summary-data', [DashboardController::class, 'loadSummaryData']);
            Route::post('bulk-status-change', [SubscriberManageController::class, 'bulkStatusChange']);
            Route::post('bulk-email-send', [SubscriberManageController::class, 'sendBulkEmail']);
            Route::delete('remove/{id}', [SubscriberManageController::class, 'destroy']);
        });

        // Newsletter manage
        Route::group(['prefix' => 'newsletter/'], function () {
            Route::post('subscriber-list', [SubscriberManageController::class, 'allSubscribers']);
            Route::post('bulk-status-change', [SubscriberManageController::class, 'bulkStatusChange']);
            Route::post('bulk-email-send', [SubscriberManageController::class, 'sendBulkEmail']);
            Route::delete('remove/{id}', [SubscriberManageController::class, 'destroy']);
        });

        // Product manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::post('product/approve', [ProductController::class, 'changeStatus']);
            Route::post('product/author/approve', [ProductAuthorController::class, 'changeStatus']);
        });
        // Location Manage
        Route::group(['prefix' => 'location/'], function () {
            // Country
            Route::group(['prefix' => 'country/'], function () {
                Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'countriesList']);
                    Route::post('add', [LocationManageController::class, 'storeCountry']);
                    Route::get('{id}', [LocationManageController::class, 'countryDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCountry']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCountry']);
                });
            });
            // State
            Route::group(['prefix' => 'state/'], function () {
                Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'statesList']);
                    Route::post('add', [LocationManageController::class, 'storeState']);
                    Route::get('{id}', [LocationManageController::class, 'stateDetails']);
                    Route::post('update', [LocationManageController::class, 'updateState']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyState']);
                });
            });
            // City
            Route::group(['prefix' => 'city/'], function () {
                Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'citiesList']);
                    Route::post('add', [LocationManageController::class, 'storeCity']);
                    Route::get('{id}', [LocationManageController::class, 'cityDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCity']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCity']);
                });
            });
            // Area
            Route::group(['prefix' => 'area/'], function () {
                Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'areasList']);
                    Route::post('add', [LocationManageController::class, 'storeArea']);
                    Route::get('{id}', [LocationManageController::class, 'areaDetails']);
                    Route::post('update', [LocationManageController::class, 'updateArea']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyArea']);
                });
            });
        });

        // Slider manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('slider/list', [SliderManageController::class, 'index']);
            Route::post('slider/add', [SliderManageController::class, 'store']);
            Route::get('slider/{id}', [SliderManageController::class, 'show']);
            Route::post('slider/update', [SliderManageController::class, 'update']);
            Route::delete('slider/remove/{id}', [SliderManageController::class, 'destroy']);
        });
        // Product Brand Routing
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_BRAND_LIST->value]], function () {
            Route::get('product-brands', [ProductBrandController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_BRAND_ADD->value]], function () {
            Route::post('product-brands', [ProductBrandController::class, 'store']);
            Route::get('product-brands/{id}', [ProductBrandController::class, 'show']);
            Route::post('product-brands/approve', [ProductBrandController::class, 'productBrandStatus']);
        });

        // Product Category Routing
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_CATEGORY_LIST->value]], function () {
            Route::get('product-categories', [ProductCategoryController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_CATEGORY_ADD->value]], function () {
            Route::post('product-categories', [ProductCategoryController::class, 'store']);
            Route::get('product-categories/{id}', [ProductCategoryController::class, 'show']);
            Route::post('product-categories/status', [ProductCategoryController::class, 'productCategoryStatus']);
        });

        // User Management
        Route::group(['middleware' => [getPermissionMiddleware('ban-user')]], function () {
            Route::post('users/block-user', [UserController::class, 'banUser']);
        });
        Route::group(['middleware' => [getPermissionMiddleware('active-user')]], function () {
            Route::post('users/unblock-user', [UserController::class, 'activeUser']);
        });

        //Product Attribute Management
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('product/attribute/list', [ProductAttributeController::class, 'index']);
            Route::get('product/attribute/{id}', [ProductAttributeController::class, 'show']);
            Route::post('product/attribute/add', [ProductAttributeController::class, 'store']);
            Route::post('product/attribute/update', [ProductAttributeController::class, 'update']);
            Route::put('product/attribute/status/{id}', [ProductAttributeController::class, 'status_update']);
            Route::delete('product/attribute/remove/{id}', [ProductAttributeController::class, 'destroy']);
        });

        // Tag manage
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
            Route::get('tag/list', [TagManageController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::post('tag/add', [TagManageController::class, 'store']);
            Route::get('tag/{id}', [TagManageController::class, 'show']);
            Route::post('tag/update', [TagManageController::class, 'update']);
            Route::delete('tag/remove/{id}', [TagManageController::class, 'destroy']);
        });

        // Unit manage
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
            Route::get('unit/list', [UnitManageController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::post('unit/add', [UnitManageController::class, 'store']);
            Route::get('unit/{id}', [UnitManageController::class, 'show']);
            Route::post('unit/update', [UnitManageController::class, 'update']);
            Route::delete('unit/remove/{id}', [UnitManageController::class, 'destroy']);
        });
        // Blog manage
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
            Route::get('blog/list', [BlogManageController::class, 'blogIndex']);
        });
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::post('blog/add', [BlogManageController::class, 'blogStore']);
            Route::get('blog/{id}', [BlogManageController::class, 'blogShow']);
            Route::post('blog/update', [BlogManageController::class, 'blogUpdate']);
            Route::delete('blog/remove/{id}', [BlogManageController::class, 'blogDestroy']);
        });
        // Blog category manage
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
            Route::get('blog/category/list', [BlogManageController::class, 'blogCategoryIndex']);
        });
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::post('blog/category/add', [BlogManageController::class, 'blogCategoryStore']);
            Route::get('blog/category/{id}', [BlogManageController::class, 'blogCategoryShow']);
            Route::post('blog/category/update', [BlogManageController::class, 'blogCategoryUpdate']);
            Route::delete('blog/category/remove/{id}', [BlogManageController::class, 'blogCategoryDestroy']);
        });

        /*--------------------- System management ----------------------------*/
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::group(['prefix' => 'system-management'], function () {
                Route::match(['get', 'post'], '/general-settings', [SystemManagementController::class, 'generalSettings']);
                Route::match(['get', 'post'], '/footer-customization', [SystemManagementController::class, 'footerCustomization']);
                Route::match(['get', 'post'], '/maintenance-settings', [SystemManagementController::class, 'maintenanceSettings']);
                Route::match(['get', 'post'], '/payment-settings', [PaymentSettingsController::class, 'paymentSettings']);
                Route::match(['get', 'post'], '/seo-settings', [SystemManagementController::class, 'seoSettings']);
                Route::match(['get', 'post'], '/firebase-settings', [SystemManagementController::class, 'firebaseSettings']);
                Route::match(['get', 'post'], '/social-login-settings', [SystemManagementController::class, 'socialLoginSettings']);
                Route::match(['get', 'post'], '/google-map-settings', [SystemManagementController::class, 'googleMapSettings']);
                // database and cache settings
                Route::post('/cache-management', [SystemManagementController::class, 'cacheManagement']);
                Route::post('/database-update-controls', [SystemManagementController::class, 'DatabaseUpdateControl']);
                // email settings
                Route::match(['get', 'post'], '/email-settings/smtp', [EmailSettingsController::class, 'smtpSettings']);
                Route::post('/email-settings/test-mail-send', [EmailSettingsController::class, 'testMailSend']);
            });
        });

        /*--------------------- Roles &  permissions manage ----------------------------*/
        // Route::get('/permissions', PermissionController::class);
        Route::get('permissions', [PermissionController::class, 'index']);
        Route::post('permissions-for-store-owner', [PermissionController::class, 'permissionForStoreOwner']);
        Route::get('module-wise-permissions', [PermissionController::class, 'moduleWisePermissions']);


        Route::get('roles', [RoleController::class, 'index']);
        Route::post('roles', [RoleController::class, 'store']);
        Route::get('roles/{id}', [RoleController::class, 'show']);
        Route::post('roles-status-update', [RoleController::class, 'roleForStoreOwner']);
    });
    /* --------------------- vendor route end ------------------------- */
    /* --------------------- vendor route start ------------------------- */
    Route::group(['prefix' => 'seller/'], function () {
        Route::post('/registration', [UserController::class, 'StoreOwnerRegistration']);
        Route::get('/store-fetch-list', [StoreManageController::class, 'ownerWiseStore']);

        // Store manage
        Route::group(['middleware' => ['permission:' . Permission::STORE_MY_SHOP->value]], function () {
            Route::get('store/list', [StoreManageController::class, 'index']);
            Route::get('store/{id}', [StoreManageController::class, 'show']);
            Route::post('store/add', [StoreManageController::class, 'store']);
            Route::post('store/update', [StoreManageController::class, 'update']);
            Route::put('store/status/{id}', [StoreManageController::class, 'status_update']);
            Route::delete('store/remove/{id}', [StoreManageController::class, 'destroy']);
            Route::get('store/deleted/records', [StoreManageController::class, 'deleted_records']);
        });

        // Staff manage
        Route::group(['middleware' => ['permission:' . Permission::SELLER_STAFF_MANAGE->value]], function () {
            //Route::apiResource('/staff', StaffController::class);
            Route::post('staff/add', [StaffController::class, 'store']);
            Route::get('staff/{id}', [StaffController::class, 'show']);
            Route::post('staff/update', [StaffController::class, 'update']);
            Route::post('staff/change-status', [StaffController::class, 'changestatus']);
        });
        // Banner manage
//        Route::group(['middleware' => ['permission:' . Permission::SELLER_STAFF_MANAGE->value]], function () {
//        });
        Route::post('banner/add', [BannerManageController::class, 'store']);
        Route::get('banner/{id}', [BannerManageController::class, 'show']);
        Route::post('banner/update', [BannerManageController::class, 'update']);
        Route::delete('banner/remove/{id}', [BannerManageController::class, 'destroy']);

        // Product manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_PRODUCT_ADD->value]], function () {

        });
        Route::get('product/list', [ProductController::class, 'index']);
        Route::get('product/{id}', [ProductController::class, 'show']);
        Route::post('product/add', [ProductController::class, 'store']);
        Route::post('product/update', [ProductController::class, 'update']);
        Route::put('product/status/{id}', [ProductController::class, 'status_update']);
        Route::delete('product/remove/{id}', [ProductController::class, 'destroy']);
        Route::get('product/deleted/records', [ProductController::class, 'deleted_records']);
        Route::post('product/export', [ProductController::class, 'export']);
        Route::post('product/import', [ProductController::class, 'import']);
        // Product brand manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::post('product-brands/add', [ProductBrandController::class, 'store']);
        });

        // Product variant manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('product/variant/list', [ProductVariantController::class, 'index']);
            Route::get('product/variant/{id}', [ProductVariantController::class, 'show']);
            Route::post('product/variant/add', [ProductVariantController::class, 'store']);
            Route::post('product/variant/update', [ProductVariantController::class, 'update']);
            Route::put('product/variant/status/{id}', [ProductVariantController::class, 'status_update']);
            Route::delete('product/variant/remove/{id}', [ProductVariantController::class, 'destroy']);
            Route::get('product/variant/deleted/records', [ProductVariantController::class, 'deleted_records']);
        });

        // Coupon manage
        Route::group(['middleware' => ['permission:' . Permission::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('product/coupon/list', [CouponManageController::class, 'index']);
            Route::get('product/coupon/{id}', [CouponManageController::class, 'show']);
            Route::post('product/coupon/add', [CouponManageController::class, 'store']);
            Route::post('product/coupon/update', [CouponManageController::class, 'update']);
            Route::put('product/coupon/status/{id}', [CouponManageController::class, 'status_update']);
            Route::delete('product/coupon/remove/{id}', [CouponManageController::class, 'destroy']);
        });

        // Product Author manage
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_LIST->value]], function () {
            Route::get('product/author/list', [ProductAuthorController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
            Route::post('product/author/add', [ProductAuthorController::class, 'store']);
            Route::get('product/author/{id}', [ProductAuthorController::class, 'show']);
            Route::post('product/author/update', [ProductAuthorController::class, 'update']);
            Route::delete('product/author/remove/{id}', [ProductAuthorController::class, 'destroy']);
            Route::post('product/author/status', [ProductAuthorController::class, 'changeStatus']);
        });
    });
    /* --------------------------> vendor route end <----------------------------- */
    /* --------------------------> customer route start <------------------------- */
    Route::group(['prefix' => 'customer/'], function () {
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        });
        Route::group(['prefix' => 'address/'], function () {
            Route::post('add', [AddressManageController::class, 'store']);
            Route::post('customer-addresses', [AddressManageController::class, 'index']);
            Route::post('make-default', [AddressManageController::class, 'defaultAddress']);
        });
    });
    /* --------------------------> customer route end <-------------------------- */
    /* --------------------------> delivery route start <------------------------- */
    Route::group(['prefix' => 'delivery/'], function () {
        Route::group(['middleware' => ['permission:' . Permission::ADMIN_AREA_ADD->value]], function () {
        });
    });
    /* --------------------------> delivery route end <-------------------------- */
});
