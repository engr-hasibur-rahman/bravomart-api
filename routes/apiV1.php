<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\V1\Admin\DepartmentManageController;
use App\Http\Controllers\Api\V1\Admin\LocationManageController;
use App\Http\Controllers\Api\V1\Admin\PagesManageController;
use App\Http\Controllers\Api\V1\Admin\PaymentSettingsController;
use App\Http\Controllers\Api\V1\Blog\BlogManageController;
use App\Http\Controllers\Api\V1\Com\BannerManageController;
use App\Http\Controllers\Api\V1\Com\SubscriberManageController;
use App\Http\Controllers\Api\V1\Com\SupportTicketManageController;
use App\Http\Controllers\Api\V1\Customer\AddressManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerAddressManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerManageController as CustomerManageController;
use App\Http\Controllers\Api\V1\Admin\CustomerManageController as AdminCustomerManageController;
use App\Http\Controllers\Api\V1\Customer\WishListManageController;
use App\Http\Controllers\Api\V1\Dashboard\DashboardController;
use App\Http\Controllers\Api\V1\EmailSettingsController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\Seller\StoreDashboardManageController;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*--------------------- Route without auth  ----------------------------*/
Route::group(['namespace' => 'Api\V1'], function () {

    // For customer register and login
    Route::post('customer/registration', [CustomerManageController::class, 'register']);
    Route::post('customer/login', [CustomerManageController::class, 'login']);
    Route::post('customer/forget-password', [CustomerManageController::class, 'forgetPassword']);
    Route::post('customer/verify-token', [CustomerManageController::class, 'verifyToken']);
    Route::post('customer/reset-password', [CustomerManageController::class, 'resetPassword']);

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
    Route::get('/product/{product_slug}', [FrontendController::class, 'productDetails']);
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
    Route::get('/tag-list', [FrontendController::class, 'tagList']);
    Route::get('/brand-list', [FrontendController::class, 'brandList']);
    Route::get('/product/attribute-list', [FrontendController::class, 'productAttributeList']);
    Route::get('/store-types', [FrontendController::class, 'storeTypeList']);
    Route::get('/behaviour-list', [FrontendController::class, 'behaviourList']);
    Route::get('/unit-list', [FrontendController::class, 'unitList']);
});


/*--------------------- Route without auth  ----------------------------*/
Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {
    /*--------------------- Com route start  ----------------------------*/
    Route::get('/logout', [UserController::class, 'logout']);
//    Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
    // media manage
    Route::group(['prefix' => 'media-upload'], function () {
        Route::post('/store', [MediaController::class, 'mediaUpload']);
        Route::get('/load-more', [MediaController::class, 'load_more']);
        Route::post('/alt', [MediaController::class, 'alt_change']);
        Route::post('/delete', [MediaController::class, 'delete_media']);
    });
//    });


    // Marketing area manage
    Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
        Route::get('com/area/list', [AreaController::class, 'index']);
    });
    Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
        Route::get('com/area/{id}', [AreaController::class, 'show']);
        Route::post('com/area/add', [AreaController::class, 'store']);
        Route::post('com/area/update', [AreaController::class, 'update']);
        Route::put('com/area/status/{id}', [AreaController::class, 'changeStatus']);
        Route::delete('com/area/remove/{id}', [AreaController::class, 'destroy']);
    });
    /*--------------------- Com route end  ----------------------------*/


    /* --------------------- Admin route start ------------------------- */
    Route::group(['prefix' => 'admin/'], function () {
        // Customer Manage
        Route::group(['prefix'=>'customer-management/'], function () {
            Route::get('customer-list',[AdminCustomerManageController::class, 'getCustomerList']);
            Route::get('customer-details',[AdminCustomerManageController::class, 'getCustomerDetails']);
            Route::post('change-status',[AdminCustomerManageController::class, 'changeStatus']);
        });
        // Seller Manage
        Route::group(['prefix'=>'seller-management/'], function () {

        });
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
        Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::post('product/approve', [ProductController::class, 'changeStatus']);
            Route::post('product/author/approve', [ProductAuthorController::class, 'changeStatus']);
        });
        // Location Manage
        Route::group(['prefix' => 'location/'], function () {
            // Country
            Route::group(['prefix' => 'country/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'countriesList']);
                    Route::post('add', [LocationManageController::class, 'storeCountry']);
                    Route::get('{id}', [LocationManageController::class, 'countryDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCountry']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCountry']);
                });
            });
            // State
            Route::group(['prefix' => 'state/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'statesList']);
                    Route::post('add', [LocationManageController::class, 'storeState']);
                    Route::get('{id}', [LocationManageController::class, 'stateDetails']);
                    Route::post('update', [LocationManageController::class, 'updateState']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyState']);
                });
            });
            // City
            Route::group(['prefix' => 'city/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'citiesList']);
                    Route::post('add', [LocationManageController::class, 'storeCity']);
                    Route::get('{id}', [LocationManageController::class, 'cityDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCity']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCity']);
                });
            });
            // Area
            Route::group(['prefix' => 'area/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'areasList']);
                    Route::post('add', [LocationManageController::class, 'storeArea']);
                    Route::get('{id}', [LocationManageController::class, 'areaDetails']);
                    Route::post('update', [LocationManageController::class, 'updateArea']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyArea']);
                });
            });
        });

        // Slider manage
        Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('slider/list', [SliderManageController::class, 'index']);
            Route::post('slider/add', [SliderManageController::class, 'store']);
            Route::get('slider/{id}', [SliderManageController::class, 'show']);
            Route::post('slider/update', [SliderManageController::class, 'update']);
            Route::delete('slider/remove/{id}', [SliderManageController::class, 'destroy']);
        });


        // Product Brand Routing
        Route::group(['prefix' => 'product-brands/'], function () {
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_BRAND_LIST->value]], function () {
                Route::get('list', [ProductBrandController::class, 'index']);
                Route::post('add', [ProductBrandController::class, 'store']);
                Route::post('update', [ProductBrandController::class, 'update']);
                Route::get('{id}', [ProductBrandController::class, 'show']);
                Route::post('approve', [ProductBrandController::class, 'productBrandStatus']);
            });
        });


        // Product Category Routing
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_CATEGORY_LIST->value]], function () {
            Route::get('product-categories', [ProductCategoryController::class, 'index']);
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
        Route::group(['prefix'=>'attribute','middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('list', [ProductAttributeController::class, 'index']);
            Route::get('/', [ProductAttributeController::class, 'show']);
            Route::get('type-wise', [ProductAttributeController::class, 'typeWiseAttributes']);
            Route::post('add', [ProductAttributeController::class, 'store']);
            Route::post('value/add', [ProductAttributeController::class, 'storeAttributeValue']);
            Route::post('update', [ProductAttributeController::class, 'update']);
            Route::put('status/{id}', [ProductAttributeController::class, 'status_update']);
            Route::delete('remove/{id}', [ProductAttributeController::class, 'destroy']);
        });
        // Coupon manage
        Route::group(['prefix' => 'coupon/', 'middleware' => ['permission:' . PermissionKey::ADMIN_COUPON_MANAGE->value]], function () {
            Route::get('list', [CouponManageController::class, 'index']);
            Route::get('{id}', [CouponManageController::class, 'show']);
            Route::post('add', [CouponManageController::class, 'store']);
            Route::post('update', [CouponManageController::class, 'update']);
            Route::post('status-change', [CouponManageController::class, 'changeStatus']);
            Route::delete('remove/{id}', [CouponManageController::class, 'destroy']);
        });
        Route::group(['prefix' => 'coupon-line/', 'middleware' => ['permission:' . PermissionKey::ADMIN_COUPON_LINE_MANAGE->value]], function () {
            Route::get('list', [CouponManageController::class, 'couponLineIndex']);
            Route::get('{id}', [CouponManageController::class, 'couponLineShow']);
            Route::post('add', [CouponManageController::class, 'couponLineStore']);
            Route::post('update', [CouponManageController::class, 'couponLineUpdate']);
            Route::delete('remove/{id}', [CouponManageController::class, 'couponLineDestroy']);
        });
        // Tag manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('tag/list', [TagManageController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::post('tag/add', [TagManageController::class, 'store']);
            Route::get('tag/{id}', [TagManageController::class, 'show']);
            Route::post('tag/update', [TagManageController::class, 'update']);
            Route::delete('tag/remove/{id}', [TagManageController::class, 'destroy']);
        });
        // Unit manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('unit/list', [UnitManageController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::post('unit/add', [UnitManageController::class, 'store']);
            Route::get('unit/{id}', [UnitManageController::class, 'show']);
            Route::post('unit/update', [UnitManageController::class, 'update']);
            Route::delete('unit/remove/{id}', [UnitManageController::class, 'destroy']);
        });
        // Blog manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('blog/list', [BlogManageController::class, 'blogIndex']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::post('blog/add', [BlogManageController::class, 'blogStore']);
            Route::get('blog/{id}', [BlogManageController::class, 'blogShow']);
            Route::post('blog/update', [BlogManageController::class, 'blogUpdate']);
            Route::delete('blog/remove/{id}', [BlogManageController::class, 'blogDestroy']);
        });
        // Blog category manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('blog/category/list', [BlogManageController::class, 'blogCategoryIndex']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::get('blog/category/fetch/list', [BlogManageController::class, 'blogCategoryList']);
            Route::post('blog/category/add', [BlogManageController::class, 'blogCategoryStore']);
            Route::get('blog/category/{id}', [BlogManageController::class, 'blogCategoryShow']);
            Route::post('blog/category/update', [BlogManageController::class, 'blogCategoryUpdate']);
            Route::post('blog/category/status-change', [BlogManageController::class, 'categoryStatusChange']);
            Route::delete('blog/category/remove/{id}', [BlogManageController::class, 'blogCategoryDestroy']);
        });

        // Pages manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PAGES_LIST->value]], function () {
            Route::get('pages/list', [PagesManageController::class, 'pagesIndex']);
            Route::post('pages/store', [PagesManageController::class, 'pagesStore']);
            Route::get('pages/{id}', [PagesManageController::class, 'pagesShow']);
            Route::post('pages/update', [PagesManageController::class, 'pagesUpdate']);
            Route::post('pages/status-change', [PagesManageController::class, 'pagesStatusChange']);
            Route::delete('pages/remove/{id}', [PagesManageController::class, 'pagesDestroy']);
        });

        /*--------------------- System management ----------------------------*/
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_SYSTEM_MANAGEMENT_SETTINGS->value]], function () {
            Route::group(['prefix' => 'system-management'], function () {
                Route::match(['get', 'post'], '/general-settings', [SystemManagementController::class, 'generalSettings']);
                Route::match(['get', 'post'], '/footer-customization', [SystemManagementController::class, 'footerCustomization']);
                Route::match(['get', 'post'], '/maintenance-settings', [SystemManagementController::class, 'maintenanceSettings']);
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
    /* --------------------- admin route end ------------------------- */


    /* --------------------- vendor route start ------------------------- */
    Route::group(['prefix' => 'seller/'], function () {
        Route::post('/registration', [UserController::class, 'StoreOwnerRegistration']);
        Route::get('/store-fetch-list', [StoreManageController::class, 'ownerWiseStore']);
        Route::post('/support-ticket/messages', [SupportTicketManageController::class, 'replyMessage']);
        Route::get('attributes/type-wise', [ProductAttributeController::class, 'typeWiseAttributes']);
        // Store manage
        Route::group(['prefix' => 'store/'], function () {
            Route::get('dashboard', [StoreDashboardManageController::class, 'dashboard']);
            Route::group(['middleware' => ['permission:' . PermissionKey::STORE_MY_SHOP->value]], function () {
                // seller store manage
                Route::get('list', [StoreManageController::class, 'index']);
                Route::get('{id}', [StoreManageController::class, 'show']);
                Route::post('add', [StoreManageController::class, 'store']);
                Route::post('update', [StoreManageController::class, 'update']);
                Route::put('status/{id}', [StoreManageController::class, 'status_update']);
                Route::delete('remove/{id}', [StoreManageController::class, 'destroy']);
                Route::get('deleted/records', [StoreManageController::class, 'deleted_records']);
                // seller product manage
                Route::group(['prefix' => 'product'], function () {
                    Route::get('list', [ProductController::class, 'index']);
                    Route::get('{slug}', [ProductController::class, 'show']);
                    Route::post('add', [ProductController::class, 'store']);
                    Route::post('update', [ProductController::class, 'update']);
                    Route::delete('remove/{id}', [ProductController::class, 'destroy']);
                    Route::get('deleted/records', [ProductController::class, 'deleted_records']);
                    Route::post('export', [ProductController::class, 'export']);
                    Route::post('import', [ProductController::class, 'import']);
                });
                // Staff manage
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STAFF_LIST->value]], function () {
                    Route::get('staff/list', [StaffController::class, 'index']);
                    Route::post('staff/add', [StaffController::class, 'store']);
                    Route::get('staff/{id}', [StaffController::class, 'show']);
                    Route::post('staff/update', [StaffController::class, 'update']);
                    Route::post('staff/change-status', [StaffController::class, 'changestatus']);
                });
            });
        });


        // Banner manage
        Route::post('banner/add', [BannerManageController::class, 'store']);
        Route::get('banner/{id}', [BannerManageController::class, 'show']);
        Route::post('banner/update', [BannerManageController::class, 'update']);
        Route::delete('banner/remove/{id}', [BannerManageController::class, 'destroy']);

        // Product manage
        Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_PRODUCT_ADD->value]], function () {

        });

        // Product variant manage
        Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('product/variant/list', [ProductVariantController::class, 'index']);
            Route::get('product/variant/{id}', [ProductVariantController::class, 'show']);
            Route::post('product/variant/add', [ProductVariantController::class, 'store']);
            Route::post('product/variant/update', [ProductVariantController::class, 'update']);
            Route::put('product/variant/status/{id}', [ProductVariantController::class, 'status_update']);
            Route::delete('product/variant/remove/{id}', [ProductVariantController::class, 'destroy']);
            Route::get('product/variant/deleted/records', [ProductVariantController::class, 'deleted_records']);
        });


        // Product Author manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('product/author/list', [ProductAuthorController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::post('product/author/add', [ProductAuthorController::class, 'store']);
            Route::get('product/author/{id}', [ProductAuthorController::class, 'show']);
            Route::post('product/author/update', [ProductAuthorController::class, 'update']);
            Route::delete('product/author/remove/{id}', [ProductAuthorController::class, 'destroy']);
            Route::post('product/author/status', [ProductAuthorController::class, 'changeStatus']);
        });
    });
    /* --------------------------> vendor route end <----------------------------- */
    /* --------------------------> delivery route start <------------------------- */
    Route::group(['prefix' => 'delivery/'], function () {
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
        });
    });
    /* --------------------------> delivery route end <-------------------------- */
});

Route::group(['namespace' => 'Api\V1', 'prefix' => 'customer/', 'middleware' => ['auth:api_customer']], function () {
    Route::group(['middleware' => ['check.email.verification.option']], function () {
        Route::group(['prefix' => 'address/'], function () {
            Route::post('add', [CustomerAddressManageController::class, 'store']);
            Route::post('update', [CustomerAddressManageController::class, 'update']);
            Route::get('customer-addresses', [CustomerAddressManageController::class, 'index']);
            Route::get('customer-address', [CustomerAddressManageController::class, 'show']);
            Route::post('make-default', [CustomerAddressManageController::class, 'defaultAddress']);
            Route::delete('remove/{id}', [CustomerAddressManageController::class, 'destroy']);
        });
        Route::group(['prefix' => 'support-ticket'], function () {
            Route::get('list', [SupportTicketManageController::class, 'index']);
            Route::post('store', [SupportTicketManageController::class, 'store']);
            Route::post('update', [SupportTicketManageController::class, 'update']);
            Route::get('details', [SupportTicketManageController::class, 'show']);
            Route::get('resolve', [SupportTicketManageController::class, 'resolve']);
            Route::post('add-message', [SupportTicketManageController::class, 'addMessage']);
            Route::get('messages', [SupportTicketManageController::class, 'getTicketMessages']);
        });
        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('list', [WishListManageController::class, 'getWishlist']);
            Route::post('store', [WishListManageController::class, 'addToWishlist']);
            Route::post('remove', [WishListManageController::class, 'removeFromWishlist']);
        });
    });
    // customer verify email
    Route::post('send-verification-email', [CustomerManageController::class, 'sendVerificationEmail']);
    Route::post('verify-email', [CustomerManageController::class, 'verifyEmail']);
    Route::post('resend-verification-email', [CustomerManageController::class, 'resendVerificationEmail']);
});
