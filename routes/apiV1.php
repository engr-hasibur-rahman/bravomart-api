<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\v1\Admin\AdminAreaSetupManageController;
use App\Http\Controllers\Api\V1\Admin\AdminCashCollectionController;
use App\Http\Controllers\Api\v1\Admin\AdminCommissionManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliverymanManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliveryManPaymentController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliverymanReviewManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliverymanTypeManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDisbursementManageController;
use App\Http\Controllers\Api\v1\Admin\AdminPosSalesController;
use App\Http\Controllers\Api\v1\Admin\AdminReportAnalyticsManageController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreDisbursementController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreManageController;
use App\Http\Controllers\Api\V1\Admin\AdminWithdrawManageController;
use App\Http\Controllers\Api\V1\Admin\AdminWithdrawSettingsController;
use App\Http\Controllers\Api\V1\Admin\DepartmentManageController;
use App\Http\Controllers\Api\V1\Admin\AdminFlashSaleManageController;
use App\Http\Controllers\Api\V1\Admin\AdminInventoryManageController;
use App\Http\Controllers\Api\V1\Admin\AdminProductManageController;
use App\Http\Controllers\Api\V1\Admin\AdminSellerManageController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreNoticeController;
use App\Http\Controllers\Api\V1\Admin\CustomerManageController as AdminCustomerManageController;
use App\Http\Controllers\Api\V1\Admin\LocationManageController;
use App\Http\Controllers\Api\V1\Admin\PagesManageController;
use App\Http\Controllers\Api\V1\Admin\WithdrawMethodManageController;
use App\Http\Controllers\Api\V1\Blog\BlogManageController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use App\Http\Controllers\Api\V1\Com\BannerManageController;
use App\Http\Controllers\Api\V1\Com\SubscriberManageController;
use App\Http\Controllers\Api\V1\Com\SupportTicketManageController;
use App\Http\Controllers\Api\V1\CouponManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerAddressManageController;
use App\Http\Controllers\Api\V1\Customer\CustomerManageController as CustomerManageController;
use App\Http\Controllers\Api\V1\Customer\WishListManageController;
use App\Http\Controllers\Api\V1\CustomerContactMessageController;
use App\Http\Controllers\Api\V1\Dashboard\DashboardController;
use App\Http\Controllers\Api\V1\EmailSettingsController;
use App\Http\Controllers\Api\V1\FrontendController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use App\Http\Controllers\Api\V1\Product\ProductVariantController;
use App\Http\Controllers\Api\V1\Seller\SellerBusinessSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerFlashSaleProductManageController;
use App\Http\Controllers\Api\V1\Seller\SellerInventoryManageController;
use App\Http\Controllers\Api\V1\Seller\SellerPosSalesController;
use App\Http\Controllers\Api\V1\Seller\SellerPosSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerProductManageController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreManageController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerWithdrawController;
use App\Http\Controllers\Api\V1\Seller\StoreDashboardManageController;
use App\Http\Controllers\Api\V1\SliderManageController;
use App\Http\Controllers\Api\V1\SystemManagementController;
use App\Http\Controllers\Api\V1\TagManageController;
use App\Http\Controllers\Api\V1\UnitManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
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
    Route::get('/customer-list', [FrontendController::class, 'customerList']);
});


/*--------------------- Route without auth  ----------------------------*/
Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum']], function () {
    /*--------------------- Com route start  ----------------------------*/
    Route::get('/logout', [UserController::class, 'logout']);
    // media manage
    Route::group(['prefix' => 'media-upload'], function () {
        Route::post('/store', [MediaController::class, 'mediaUpload']);
        Route::get('/load-more', [MediaController::class, 'load_more']);
        Route::post('/alt', [MediaController::class, 'alt_change']);
        Route::post('/delete', [MediaController::class, 'delete_media']);
    });


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
        // Dashboard manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_POS_SALES->value]], function () {
            Route::get('dashboard', [DashboardController::class, 'dashboardData']);
        });
        // POS Manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_POS_SALES->value]], function () {
            Route::group(['prefix' => 'pos/'], function () {
                Route::get('', [AdminPosSalesController::class, 'index'])->name('admin.pos.index'); // Show POS dashboard
                Route::post('process', [AdminPosSalesController::class, 'processSale'])->name('admin.pos.process'); // Process a sale
                Route::get('products', [AdminPosSalesController::class, 'fetchProducts'])->name('admin.pos.products'); // Fetch products for POS
                Route::post('add-to-cart', [AdminPosSalesController::class, 'addToCart'])->name('admin.pos.addToCart'); // Add product to POS cart
                Route::get('cart', [AdminPosSalesController::class, 'getCart'])->name('admin.pos.cart'); // Fetch current POS cart
                Route::post('remove-from-cart', [AdminPosSalesController::class, 'removeFromCart'])->name('admin.pos.removeFromCart'); // Remove item from POS cart
                Route::post('apply-discount', [AdminPosSalesController::class, 'applyDiscount'])->name('admin.pos.applyDiscount'); // Apply discount to the order
                Route::post('apply-tax', [AdminPosSalesController::class, 'applyTax'])->name('admin.pos.applyTax'); // Apply tax to the order
                Route::get('customers', [AdminPosSalesController::class, 'fetchCustomers'])->name('admin.pos.customers'); // Fetch customers for POS
                Route::post('add-customer', [AdminPosSalesController::class, 'addCustomer'])->name('admin.pos.addCustomer'); // Add a new customer
                Route::post('finalize-sale', [AdminPosSalesController::class, 'finalizeSale'])->name('admin.pos.finalizeSale'); // Finalize the sale and generate invoice
                Route::get('order-history', [AdminPosSalesController::class, 'orderHistory'])->name('admin.pos.orderHistory'); // View POS order history
                // POS Settings (with specific permission)
                Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_POS_SETTINGS->value]], function () {
                    Route::get('settings', [AdminPosSalesController::class, 'posSettings']); // POS settings
                });
            });
        });
        // Product manage
        Route::group(['prefix' => 'product/'], function () {
            // Product Inventory
            Route::group(['prefix' => 'inventory', 'middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_INVENTORY->value]], function () {
                Route::get('/', [AdminInventoryManageController::class, 'allInventories']);
                Route::post('update', [AdminInventoryManageController::class, 'updateInventory']);
                Route::post('remove', [AdminInventoryManageController::class, 'deleteInventory']);
            });
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCTS_MANAGE->value]], function () {
                Route::get('list', [AdminProductManageController::class, 'index']);
                Route::post('add', [AdminProductManageController::class, 'store']);
                Route::get('details/{slug}', [AdminProductManageController::class, 'show']);
                Route::post('update', [AdminProductManageController::class, 'update']);
                Route::delete('remove/{id?}', [AdminProductManageController::class, 'destroy']);
                Route::post('approve', [AdminProductManageController::class, 'approveProductRequests']);
                Route::get('request', [AdminProductManageController::class, 'productRequests']);
                Route::post('export', [AdminProductManageController::class, 'export'])->middleware('permission:' . PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_EXPORT->value);
                Route::post('import', [AdminProductManageController::class, 'import'])->middleware('permission:' . PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_IMPORT->value);
                Route::post('change-status', [AdminProductManageController::class, 'changeStatus']);
                Route::get('stock-report', [SellerProductManageController::class, 'lowOrOutOfStockProducts'])->middleware('permission:' . PermissionKey::ADMIN_PRODUCT_STOCK_REPORT->value);
            });
        });
        // Store Management
        Route::group(['prefix' => 'store/'], function () {
            // Store List Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_LIST->value]], function () {
                Route::get('list', [AdminStoreManageController::class, 'index']);
                Route::get('seller-stores', [AdminStoreManageController::class, 'sellerStores']);
                Route::get('details', [AdminStoreManageController::class, 'show']);
            });
            // Store Add Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_ADD->value]], function () {
                Route::post('add', [AdminStoreManageController::class, 'store']);
                Route::post('update', [AdminStoreManageController::class, 'update']);
                Route::delete('remove/{id}', [AdminStoreManageController::class, 'destroy']);
                Route::get('deleted-records', [AdminStoreManageController::class, 'deletedRecords']);
            });
            // Store Approval Request Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_APPROVAL->value]], function () {
                Route::get('approval-request', [AdminStoreManageController::class, 'storeApproveRequest']);
                Route::post('approve', [AdminStoreManageController::class, 'changeStatus']);
            });
            // Recommended Store Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_RECOMMENDED->value]], function () {
                Route::get('recommended', [AdminStoreManageController::class, 'recommendedStores']);
                Route::post('set-recommended', [AdminStoreManageController::class, 'setRecommended']);
            });
        });
        // Flash Sale manage
        Route::group(['prefix' => 'promotional/'], function () {
            // Flash Deals
            Route::group(['prefix' => 'flash-deals'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_MANAGE->value]], function () {
                    Route::get('list', [AdminFlashSaleManageController::class, 'getFlashSale']);
                    Route::post('add', [AdminFlashSaleManageController::class, 'createFlashSale']);
                    Route::post('update', [AdminFlashSaleManageController::class, 'updateFlashSale']);
                    Route::post('change-status', [AdminFlashSaleManageController::class, 'changeStatus']);
                    Route::delete('remove/{id}', [AdminFlashSaleManageController::class, 'deleteFlashSale']);
                    Route::post('deactivate', [AdminFlashSaleManageController::class, 'deactivateFlashSale']);
                });
                // Join Deals
                Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_JOIN_DEALS->value]], function () {
                    Route::get('join-request', [AdminFlashSaleManageController::class, 'flashSaleProductRequest']);
                    Route::post('join-request/approve', [AdminFlashSaleManageController::class, 'approveFlashSaleProducts']);
                    Route::post('join-request/reject', [AdminFlashSaleManageController::class, 'rejectFlashSaleProducts']);
                });
            });
            // Banner Management
            Route::group(['prefix' => 'banner', 'middleware' => ['permission:' . PermissionKey::ADMIN_PROMOTIONAL_BANNER_MANAGE->value]], function () {
                Route::post('list', [BannerManageController::class, 'add']);
                Route::delete('remove/{id}', [BannerManageController::class, 'remove']);
            });
        });
        // Customer Manage
        Route::group(['prefix' => 'customer/'], function () {
            // CUSTOMER
            Route::group(['permission:' . PermissionKey::ADMIN_CUSTOMER_MANAGEMENT_LIST->value], function () {
                Route::get('list', [AdminCustomerManageController::class, 'getCustomerList']);
                Route::get('details', [AdminCustomerManageController::class, 'getCustomerDetails']);
                Route::post('change-status', [AdminCustomerManageController::class, 'changeStatus']);
            });
            // Newsletter
            Route::group(['permission:' . PermissionKey::ADMIN_CUSTOMER_MANAGEMENT_LIST->value], function () {
                Route::group(['prefix' => 'newsletter/'], function () {
                    Route::post('list', [SubscriberManageController::class, 'allSubscribers']);
                    Route::post('bulk-status-change', [SubscriberManageController::class, 'bulkStatusChange']);
                    Route::post('bulk-email-send', [SubscriberManageController::class, 'sendBulkEmail']);
                    Route::delete('remove/{id}', [SubscriberManageController::class, 'destroy']);
                });
            });
            // contact message
            Route::group(['permission:' . PermissionKey::ADMIN_CUSTOMER_CONTACT_MESSAGES->value], function () {
                Route::get('contact-messages', [CustomerContactMessageController::class, 'contactMessages']);
            });
        });
        // Seller Manage
        Route::group(['prefix' => 'seller/'], function () {
            Route::get('list', [AdminSellerManageController::class, 'getSellerList']);
            Route::get('active', [AdminSellerManageController::class, 'getActiveSellerList']);
            Route::get('details/{slug}', [AdminSellerManageController::class, 'getSellerDetails']);
            Route::get('list/pending', [AdminSellerManageController::class, 'pendingSellers']);
            Route::post('approve', [AdminSellerManageController::class, 'approveSeller']);
            Route::post('suspend', [AdminSellerManageController::class, 'rejectSeller']);
        });
        // Department manage
        Route::group(['prefix' => 'department/'], function () {
            Route::get('list', [DepartmentManageController::class, 'index']);
            Route::post('add', [DepartmentManageController::class, 'store']);
            Route::get('details', [DepartmentManageController::class, 'show']);
            Route::post('update', [DepartmentManageController::class, 'update']);
            Route::delete('remove/{id}', [DepartmentManageController::class, 'destroy']);
        });
        // Location Manage
        Route::group(['prefix' => 'location/'], function () {
            // Country
            Route::group(['prefix' => 'country/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'countriesList']);
                    Route::post('add', [LocationManageController::class, 'storeCountry']);
                    Route::get('details', [LocationManageController::class, 'countryDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCountry']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCountry']);
                });
            });
            // State
            Route::group(['prefix' => 'state/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'statesList']);
                    Route::post('add', [LocationManageController::class, 'storeState']);
                    Route::get('details', [LocationManageController::class, 'stateDetails']);
                    Route::post('update', [LocationManageController::class, 'updateState']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyState']);
                });
            });
            // City
            Route::group(['prefix' => 'city/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'citiesList']);
                    Route::post('add', [LocationManageController::class, 'storeCity']);
                    Route::get('details', [LocationManageController::class, 'cityDetails']);
                    Route::post('update', [LocationManageController::class, 'updateCity']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyCity']);
                });
            });
            // Area
            Route::group(['prefix' => 'area/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
                    Route::get('list', [LocationManageController::class, 'areasList']);
                    Route::post('add', [LocationManageController::class, 'storeArea']);
                    Route::get('details', [LocationManageController::class, 'areaDetails']);
                    Route::post('update', [LocationManageController::class, 'updateArea']);
                    Route::delete('remove/{id}', [LocationManageController::class, 'destroyArea']);
                });
            });
        });
        // Slider manage
        Route::group(['prefix' => 'slider/', 'middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('list', [SliderManageController::class, 'index']);
            Route::post('add', [SliderManageController::class, 'store']);
            Route::get('details', [SliderManageController::class, 'show']);
            Route::post('update', [SliderManageController::class, 'update']);
            Route::delete('remove/{id}', [SliderManageController::class, 'destroy']);
        });
        // Product Brand Routing
        Route::group(['prefix' => 'brand/'], function () {
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_BRAND_LIST->value]], function () {
                Route::get('list', [ProductBrandController::class, 'index']);
                Route::post('add', [ProductBrandController::class, 'store']);
                Route::post('update', [ProductBrandController::class, 'update']);
                Route::get('details', [ProductBrandController::class, 'show']);
                Route::post('approve', [ProductBrandController::class, 'productBrandStatus']);
            });
        });
        // Product Author manage
        Route::group(['prefix' => 'product/author/', 'middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_AUTHORS_MANAGE->value]], function () {
            Route::get('list', [ProductAuthorController::class, 'index']);
            Route::post('add', [ProductAuthorController::class, 'store']);
            Route::get('details/{id}', [ProductAuthorController::class, 'show']);
            Route::post('update', [ProductAuthorController::class, 'update']);
            Route::delete('remove/{id}', [ProductAuthorController::class, 'destroy']);
            Route::post('change-status', [ProductAuthorController::class, 'changeStatus']);
            Route::post('approve', [ProductAuthorController::class, 'approveAuthors']);
            Route::get('author-request', [ProductAuthorController::class, 'authorRequests']);
        });
        // Product Category Routing
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_CATEGORY_LIST->value]], function () {
            Route::get('product-categories', [ProductCategoryController::class, 'index']);
            Route::post('product-categories', [ProductCategoryController::class, 'store']);
            Route::get('product-categories/details', [ProductCategoryController::class, 'show']);
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
        Route::group(['prefix' => 'attribute/', 'middleware/' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('list', [ProductAttributeController::class, 'index']);
            Route::get('details', [ProductAttributeController::class, 'show']);
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
            Route::get('details', [CouponManageController::class, 'show']);
            Route::post('add', [CouponManageController::class, 'store']);
            Route::post('update', [CouponManageController::class, 'update']);
            Route::post('status-change', [CouponManageController::class, 'changeStatus']);
            Route::delete('remove/{id}', [CouponManageController::class, 'destroy']);
        });
        Route::group(['prefix' => 'coupon-line/', 'middleware' => ['permission:' . PermissionKey::ADMIN_COUPON_LINE_MANAGE->value]], function () {
            Route::get('list', [CouponManageController::class, 'couponLineIndex']);
            Route::get('details', [CouponManageController::class, 'couponLineShow']);
            Route::post('add', [CouponManageController::class, 'couponLineStore']);
            Route::post('update', [CouponManageController::class, 'couponLineUpdate']);
            Route::delete('remove/{id}', [CouponManageController::class, 'couponLineDestroy']);
        });


        // Tag manage
        Route::group(['prefix' => 'tag/', 'middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_TAG_LIST->value]], function () {
            Route::get('list', [TagManageController::class, 'index']);
            Route::post('add', [TagManageController::class, 'store']);
            Route::get('details', [TagManageController::class, 'show']);
            Route::post('update', [TagManageController::class, 'update']);
            Route::delete('remove/{id}', [TagManageController::class, 'destroy']);
        });

        // Unit manage
        Route::group(['prefix' => 'unit/', 'middleware' => ['permission:' . PermissionKey::ADMIN_PRODUCT_UNIT_LIST->value]], function () {
            Route::get('list', [UnitManageController::class, 'index']);
            Route::post('add', [UnitManageController::class, 'store']);
            Route::get('details', [UnitManageController::class, 'show']);
            Route::post('update', [UnitManageController::class, 'update']);
            Route::delete('remove/{id}', [UnitManageController::class, 'destroy']);
        });

        // Blog manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_LIST->value]], function () {
            Route::get('blog/list', [BlogManageController::class, 'blogIndex']);
        });
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_AREA_ADD->value]], function () {
            Route::post('blog/add', [BlogManageController::class, 'blogStore']);
            Route::get('blog/details', [BlogManageController::class, 'blogShow']);
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
            Route::get('blog/category/details', [BlogManageController::class, 'blogCategoryShow']);
            Route::post('blog/category/update', [BlogManageController::class, 'blogCategoryUpdate']);
            Route::post('blog/category/status-change', [BlogManageController::class, 'categoryStatusChange']);
            Route::delete('blog/category/remove/{id}', [BlogManageController::class, 'blogCategoryDestroy']);
        });
        // Pages manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_PAGES_LIST->value]], function () {
            Route::get('pages/list', [PagesManageController::class, 'pagesIndex']);
            Route::post('pages/store', [PagesManageController::class, 'pagesStore']);
            Route::get('pages/details', [PagesManageController::class, 'pagesShow']);
            Route::post('pages/update', [PagesManageController::class, 'pagesUpdate']);
            Route::post('pages/status-change', [PagesManageController::class, 'pagesStatusChange']);
            Route::delete('pages/remove/{id}', [PagesManageController::class, 'pagesDestroy']);
        });
        // Store Notice manage    
        Route::prefix('store-notices/')->middleware(['permission:' . PermissionKey::ADMIN_NOTICE_MANAGEMENT->value])->group(function () {
            Route::get('/', [AdminStoreNoticeController::class, 'index']); // Get all notices
            Route::post('/', [AdminStoreNoticeController::class, 'store']); // Create a new notice
            Route::get('details', [AdminStoreNoticeController::class, 'show']); // View a specific notice
            Route::post('update', [AdminStoreNoticeController::class, 'update']); // Update a specific notice
            Route::post('change-status', [AdminStoreNoticeController::class, 'statusChange']); // Change notice status
            Route::delete('remove/{id}', [AdminStoreNoticeController::class, 'destroy']); // Delete a specific notice
        });
        // Admin Deliveryman management
        Route::prefix('deliveryman/')->group(function () {
            //vehicle-types
            Route::prefix('vehicle-types/')->middleware(['permission:' . PermissionKey::ADMIN_DELIVERYMAN_VEHICLE_TYPE->value])->group(function () {
                Route::get('list', [AdminDeliverymanTypeManageController::class, 'index']);
                Route::post('add', [AdminDeliverymanTypeManageController::class, 'store']);
                Route::get('details', [AdminDeliverymanTypeManageController::class, 'show']);
                Route::put('update', [AdminDeliverymanTypeManageController::class, 'update']);
                Route::patch('status-change', [AdminDeliverymanTypeManageController::class, 'statusChange']);
                Route::delete('remove/{id}', [AdminDeliverymanTypeManageController::class, 'destroy']);
            });
            // delivery man manage
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_DELIVERYMAN_MANAGE_LIST->value]], function () {
                Route::get('list', [AdminDeliverymanManageController::class, 'index']);
                Route::post('add', [AdminDeliverymanManageController::class, 'store']);
                Route::get('details', [AdminDeliverymanManageController::class, 'show']);
                Route::put('update', [AdminDeliverymanManageController::class, 'update']);
                Route::delete('remove/{id}', [AdminDeliverymanManageController::class, 'destroy']);
            });
            // deliveryman review manage
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_DELIVERYMAN_MANAGE_REVIEW->value]], function () {
                Route::get('reviews', [AdminDeliverymanReviewManageController::class, 'index']);
            });
        });
        // FINANCIAL WITHDRAWALS management
        Route::group(['prefix' => 'financial/'], function () {
            Route::group(['prefix' => 'withdraw/'], function () {
                // withdraw history
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_HISTORY->value], function () {
                    Route::get('history', [AdminWithdrawManageController::class, 'withdrawHistory']);
                    Route::get('details/{id}', [AdminWithdrawManageController::class, 'withdrawDetails']);
                });
                // withdraw REQUEST
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST->value], function () {
                    Route::get('request', [AdminWithdrawManageController::class, 'withdrawRequest']);
                });
                // withdraw settings
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST->value], function () {
                    Route::get('settings', [AdminWithdrawSettingsController::class, 'withdrawSettings']);
                });
                // withdraw method
                Route::prefix('method')->middleware(['permission:' . PermissionKey::ADMIN_WITHDRAW_METHOD_MANAGEMENT->value])->group(function () {
                    Route::get('/list', [WithdrawMethodManageController::class, 'index']);
                    Route::post('/add', [WithdrawMethodManageController::class, 'store']);
                    Route::get('/{id}', [WithdrawMethodManageController::class, 'show']);
                    Route::put('/{id}', [WithdrawMethodManageController::class, 'update']);
                    Route::patch('/{id}/status', [WithdrawMethodManageController::class, 'statusChange']);
                    Route::delete('/{id}', [WithdrawMethodManageController::class, 'destroy']);
                });
            });

            // FINANCIAL DISBURSEMENTS (Payments & Payouts)
            Route::group(['prefix' => 'disbursement/'], function () {
                // Store Disbursement (for store payments)
                Route::get('store', [AdminStoreDisbursementController::class, 'storeDisbursement'])->middleware('permission:' . PermissionKey::ADMIN_FINANCIAL_STORE_DISBURSEMENT->value);
                // Delivery Man Disbursement (for delivery personnel payouts)
                Route::get('delivery-man', [AdminDisbursementManageController::class, 'deliveryManDisbursement'])->middleware('permission:' . PermissionKey::ADMIN_FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value);
            });
            // Collect Cash (for cash collection)
            Route::get('cash-collect', [AdminCashCollectionController::class, 'collectCash'])->middleware('permission:' . PermissionKey::ADMIN_FINANCIAL_COLLECT_CASH->value);
            // Delivery Man Payments (View and process delivery man payments)
            Route::get('delivery-man-payments', [AdminDeliveryManPaymentController::class, 'deliveryManPayments'])->middleware('permission:' . PermissionKey::ADMIN_FINANCIAL_DELIVERY_MAN_PAYMENTS->value);
        });
        // business-operations
        Route::group(['prefix' => 'business-operations/'], function () {
            // withdraw method
            Route::prefix('area/')->middleware(['permission:' . PermissionKey::ADMIN_GEO_AREA_MANAGE->value])->group(function () {
                Route::get('list', [AdminAreaSetupManageController::class, 'index']);
                Route::post('add', [AdminAreaSetupManageController::class, 'store']);
                Route::post('update', [AdminAreaSetupManageController::class, 'update']);
                Route::get('details', [AdminAreaSetupManageController::class, 'show']);
                Route::post('change-status', [AdminAreaSetupManageController::class, 'changeStatus']);
                Route::delete('remove/{id}', [AdminAreaSetupManageController::class, 'destroy']);
            });
            // Conditionally load Subscription Module routes
            if (function_exists('isModuleActive') && isModuleActive('Subscription')) {
                Route::group(['prefix' => 'business-operations/subscription'], function () {
                    include base_path('Modules/Subscription/routes/api.php');
                });
            }
            // withdraw method
            Route::prefix('commission')->middleware(['permission:' . PermissionKey::ADMIN_COMMISSION_SETTINGS->value])->group(function () {
                Route::match(['get', 'post'], '/settings', [AdminCommissionManageController::class, 'commissionSettings']);
                Route::get('/history', [AdminCommissionManageController::class, 'commissionHistory']);
            });
        });
        // report-analytics
        Route::get('report-analytics', [AdminReportAnalyticsManageController::class, 'reportList'])->middleware(['permission:' . PermissionKey::ADMIN_REPORT_ANALYTICS->value]);

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
        Route::get('/store-fetch-list', [SellerStoreManageController::class, 'ownerWiseStore']);
        Route::post('/support-ticket/messages', [SupportTicketManageController::class, 'replyMessage']);
        Route::get('attributes/type-wise', [ProductAttributeController::class, 'typeWiseAttributes']);
        // Store manage
        Route::group(['prefix' => 'store/'], function () {
            Route::get('dashboard', [StoreDashboardManageController::class, 'dashboard']);
            // POS Manage
            Route::group(['prefix' => 'pos/', 'middleware' => ['permission:' . PermissionKey::SELLER_STORE_POS_SALES->value]], function () {
                Route::get('', [SellerPosSalesController::class, 'index'])->name('seller.store.pos.index'); // Show POS dashboard for the store
                Route::post('process', [SellerPosSalesController::class, 'processSale'])->name('seller.store.pos.process'); // Process a sale for the store
                Route::get('products', [SellerPosSalesController::class, 'fetchProducts'])->name('seller.store.pos.products'); // Fetch store-specific products
                Route::post('add-to-cart', [SellerPosSalesController::class, 'addToCart'])->name('seller.store.pos.addToCart'); // Add product to POS cart
                Route::get('cart', [SellerPosSalesController::class, 'getCart'])->name('seller.store.pos.cart'); // Fetch POS cart for the store
                Route::post('remove-from-cart', [SellerPosSalesController::class, 'removeFromCart'])->name('seller.store.pos.removeFromCart'); // Remove product from POS cart
                Route::post('apply-discount', [SellerPosSalesController::class, 'applyDiscount'])->name('seller.store.pos.applyDiscount'); // Apply discount for the store
                Route::post('apply-tax', [SellerPosSalesController::class, 'applyTax'])->name('seller.store.pos.applyTax'); // Apply tax for the store
                Route::get('customers', [SellerPosSalesController::class, 'fetchCustomers'])->name('seller.store.pos.customers'); // Fetch store-specific customers
                Route::post('add-customer', [SellerPosSalesController::class, 'addCustomer'])->name('seller.store.pos.addCustomer'); // Add customer for the store
                Route::post('finalize-sale', [SellerPosSalesController::class, 'finalizeSale'])->name('seller.store.pos.finalizeSale'); // Finalize the sale
                Route::get('order-history', [SellerPosSalesController::class, 'orderHistory'])->name('seller.store.pos.orderHistory'); // POS order history for the store
            });
            // seller product manage
            Route::group(['prefix' => 'orders/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_ORDER_MANAGE->value]], function () {
                    Route::get('/', [SellerProductManageController::class, 'allOrders']);
                });
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_ORDERS_RETURNED_OR_REFUND->value]], function () {
                    Route::get('/returned', [SellerProductManageController::class, 'returnedOrders']);
                });
            });
            // seller store manage
            Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_MY_SHOP->value]], function () {
                Route::get('list', [SellerStoreManageController::class, 'index']);
                Route::get('details', [SellerStoreManageController::class, 'show']);
                Route::post('add', [SellerStoreManageController::class, 'store']);
                Route::post('update', [SellerStoreManageController::class, 'update']);
                Route::post('change-status', [SellerStoreManageController::class, 'status_update']);
                Route::delete('remove/{id}', [SellerStoreManageController::class, 'destroy']);
                Route::get('deleted/records', [SellerStoreManageController::class, 'deleted_records']);
            });
            // seller product manage
            Route::group(['prefix' => 'product/'], function () {
                // Product Inventory
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PRODUCT_INVENTORY->value]], function () {
                    Route::get('inventory', [SellerInventoryManageController::class, 'allInventories']);
                });
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PRODUCT_LIST->value]], function () {
                    Route::get('list', [SellerProductManageController::class, 'index']);
                    Route::get('details/{slug}', [SellerProductManageController::class, 'show']);
                    Route::post('add', [SellerProductManageController::class, 'store'])->middleware('permission:' . PermissionKey::SELLER_STORE_PRODUCT_ADD->value);
                    Route::post('update', [SellerProductManageController::class, 'update']);
                    Route::delete('remove/{id}', [SellerProductManageController::class, 'destroy']);
                    Route::get('deleted/records', [SellerProductManageController::class, 'deleted_records']);
                    Route::post('export', [SellerProductManageController::class, 'export'])->middleware('permission:' . PermissionKey::SELLER_STORE_PRODUCT_BULK_EXPORT->value);
                    Route::post('import', [SellerProductManageController::class, 'import'])->middleware('permission:' . PermissionKey::SELLER_STORE_PRODUCT_BULK_IMPORT->value);
                    Route::get('stock-report', [SellerProductManageController::class, 'lowStockProducts'])->middleware('permission:' . PermissionKey::SELLER_STORE_PRODUCT_STOCK_REPORT->value);
                });
            });
            // Staff manage
            Route::group(['prefix' => 'staff/', 'middleware' => ['permission:' . PermissionKey::SELLER_STAFF_LIST->value]], function () {
                Route::get('list', [StaffController::class, 'index']);
                Route::post('add', [StaffController::class, 'store']);
                Route::get('details', [StaffController::class, 'show']);
                Route::post('update', [StaffController::class, 'update']);
                Route::post('change-status', [StaffController::class, 'changestatus']);
            });
            // FINANCIAL WITHDRAWALS management
            Route::group(['prefix' => 'financial/'], function () {
                // wallet
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WALLET->value], function () {
                    Route::get('wallet', [SellerWithdrawController::class, 'myWallet']);
                });
                // withdraw history
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS->value], function () {
                    Route::get('withdraw', [SellerWithdrawController::class, 'withdrawHistory']);
                });
            });
            // store settings
            Route::group(['prefix' => 'settings/'], function () {
                // store notice
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_STORE_NOTICE->value], function () {
                    Route::get('notices', [SellerStoreSettingsController::class, 'storeNotice']);
                });
                // store config
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_STORE_CONFIG->value], function () {
                    Route::match(['get', 'put'], 'config', [SellerStoreSettingsController::class, 'storeConfig']);
                });
                // business settings
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_BUSINESS_PLAN->value], function () {
                    Route::match(['get', 'put'], 'business-plan', [SellerBusinessSettingsController::class, 'businessPlan']);
                });
                // pos settings
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_POS_CONFIG->value], function () {
                    Route::match(['get', 'put'], 'pos-config', [SellerPosSettingsController::class, 'pos-config']);
                });
            });
            // Flash Sale manage
            Route::group(['prefix' => 'promotional/'], function () {
                Route::group(['prefix' => 'flash-deals'], function () {
                    Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_MY_DEALS->value]], function () {
                        Route::get('my-deals', [SellerFlashSaleProductManageController::class, 'getFlashSaleProducts']);
                    });
                    Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_JOIN_DEALS->value]], function () {
                        Route::post('join-deals', [SellerFlashSaleProductManageController::class, 'addProductToFlashSale']);
                    });
                    Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_ACTIVE_DEALS->value]], function () {
                        Route::get('active-deals', [SellerFlashSaleProductManageController::class, 'getValidFlashSales']);
                    });
                });

                // Banner Management
                Route::group(['prefix' => 'banner', 'middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_BANNER_MANAGE->value]], function () {
                    Route::post('list', [BannerManageController::class, 'list']);
                    Route::post('add', [BannerManageController::class, 'add']);
                    Route::get('details', [BannerManageController::class, 'show']);
                    Route::post('update', [BannerManageController::class, 'update']);
                    Route::delete('remove/{id}', [BannerManageController::class, 'remove']);
                });
            });
        });  // END STORE ROUTE
        // Product variant manage
        Route::group(['prefix' => 'product/variant/', 'middleware' => ['permission:' . PermissionKey::PRODUCT_ATTRIBUTE_ADD->value]], function () {
            Route::get('list', [ProductVariantController::class, 'index']);
            Route::get('details', [ProductVariantController::class, 'show']);
            Route::post('add', [ProductVariantController::class, 'store']);
            Route::post('update', [ProductVariantController::class, 'update']);
            Route::post('change-status', [ProductVariantController::class, 'status_update']);
            Route::delete('remove/{id}', [ProductVariantController::class, 'destroy']);
            Route::get('deleted/records', [ProductVariantController::class, 'deleted_records']);
        });
        // Seller  Product Author manage
        Route::group(['prefix' => 'product/author/', 'middleware' => ['permission:' . PermissionKey::SELLER_PRODUCT_AUTHORS_MANAGE->value]], function () {
            Route::get('list', [ProductAuthorController::class, 'sellerAuthors']);
            Route::post('add', [ProductAuthorController::class, 'authorAddRequest']);
            Route::get('details', [ProductAuthorController::class, 'show']);
            Route::delete('remove/{id}', [ProductAuthorController::class, 'destroy']);
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
    // media manage
    Route::group(['prefix' => 'media-upload'], function () {
        Route::post('/store', [MediaController::class, 'mediaUpload']);
        Route::get('/load-more', [MediaController::class, 'load_more']);
        Route::post('/alt', [MediaController::class, 'alt_change']);
        Route::post('/delete', [MediaController::class, 'delete_media']);
    });

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
