<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\v1\Admin\AdminAreaSetupManageController;
use App\Http\Controllers\Api\V1\Admin\AdminBannerManageController;
use App\Http\Controllers\Api\V1\Admin\AdminBlogManageController;
use App\Http\Controllers\Api\V1\Admin\AdminCashCollectionController;
use App\Http\Controllers\Api\v1\Admin\AdminCommissionManageController;
use App\Http\Controllers\Api\V1\Admin\AdminContactManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliverymanManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDeliverymanReviewManageController;
use App\Http\Controllers\Api\V1\Admin\AdminFlashSaleManageController;
use App\Http\Controllers\Api\V1\Admin\AdminInventoryManageController;
use App\Http\Controllers\Api\V1\Admin\AdminOrderManageController;
use App\Http\Controllers\Api\V1\Admin\AdminOrderRefundManageController;
use App\Http\Controllers\Api\v1\Admin\AdminPosSalesController;
use App\Http\Controllers\Api\V1\Admin\AdminProductManageController;
use App\Http\Controllers\Api\V1\Admin\AdminProductQueryManageController;
use App\Http\Controllers\Api\v1\Admin\AdminReportAnalyticsManageController;
use App\Http\Controllers\Api\V1\Admin\AdminReviewManageController;
use App\Http\Controllers\Api\V1\Admin\AdminSellerManageController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreManageController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreNoticeController;
use App\Http\Controllers\Api\V1\Admin\AdminStoreTypeManageController;
use App\Http\Controllers\Api\V1\Admin\AdminSupportTicketManageController;
use App\Http\Controllers\Api\V1\Admin\AdminWithdrawManageController;
use App\Http\Controllers\Api\V1\Admin\AdminWithdrawSettingsController;
use App\Http\Controllers\Api\V1\Admin\CustomerManageController as AdminCustomerManageController;
use App\Http\Controllers\Api\V1\Admin\AdminDashboardController;
use App\Http\Controllers\Api\V1\Admin\DepartmentManageController;
use App\Http\Controllers\Api\V1\Admin\EmailSettingsController;
use App\Http\Controllers\Api\V1\Admin\EmailTemplateManageController;
use App\Http\Controllers\Api\V1\Admin\LocationManageController;
use App\Http\Controllers\Api\V1\Admin\PagesManageController;
use App\Http\Controllers\Api\V1\AdminUnitManageController;
use App\Http\Controllers\Api\V1\Com\AreaController;
use App\Http\Controllers\Api\V1\Com\SubscriberManageController;
use App\Http\Controllers\Api\V1\CouponManageController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use App\Http\Controllers\Api\V1\Seller\SellerProductManageController;
use App\Http\Controllers\Api\V1\SliderManageController;
use App\Http\Controllers\Api\V1\SystemManagementController;
use App\Http\Controllers\Api\V1\TagManageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\app\Http\Controllers\Api\AdminWithdrawGatewayManageController;
use Modules\Wallet\app\Http\Controllers\Api\AdminWithdrawRequestManageController;
use Modules\Wallet\app\Http\Controllers\Api\WalletManageAdminController;


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
            Route::get('dashboard', [AdminDashboardController::class, 'summaryData']);
            Route::get('sales-summary', [AdminDashboardController::class, 'salesSummaryData']);
            Route::get('other-summary', [AdminDashboardController::class, 'otherSummaryData']);
        });
        // POS Manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_POS_SALES->value]], function () {
            Route::group(['prefix' => 'pos/'], function () {
                Route::get('', [AdminPosSalesController::class, 'index']); // Show POS dashboard
                Route::post('process', [AdminPosSalesController::class, 'processSale']); // Process a sale
                Route::get('products', [AdminPosSalesController::class, 'fetchProducts']); // Fetch products for POS
                Route::post('add-to-cart', [AdminPosSalesController::class, 'addToCart']); // Add product to POS cart
                Route::get('cart', [AdminPosSalesController::class, 'getCart']); // Fetch current POS cart
                Route::post('remove-from-cart', [AdminPosSalesController::class, 'removeFromCart']); // Remove item from POS cart
                Route::post('apply-discount', [AdminPosSalesController::class, 'applyDiscount']); // Apply discount to the order
                Route::post('apply-tax', [AdminPosSalesController::class, 'applyTax']); // Apply tax to the order
                Route::get('customers', [AdminPosSalesController::class, 'fetchCustomers']); // Fetch customers for POS
                Route::post('add-customer', [AdminPosSalesController::class, 'addCustomer']); // Add a new customer
                Route::post('finalize-sale', [AdminPosSalesController::class, 'finalizeSale']); // Finalize the sale and generate invoice
                Route::get('order-history', [AdminPosSalesController::class, 'orderHistory']); // View POS order history
                // POS Settings (with specific permission)
                Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_POS_SETTINGS->value]], function () {
                    Route::get('settings', [AdminPosSalesController::class, 'posSettings']); // POS settings
                });
            });
        });


        // Orders & Reviews Manage
        Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_ORDERS_ALL->value]], function () {
            Route::group(['prefix' => 'orders/'], function () {
                Route::get('invoice', [AdminOrderManageController::class, 'invoice']);
                Route::post('change-order-status', [AdminOrderManageController::class, 'changeOrderStatus']);
                Route::post('change-payment-status', [AdminOrderManageController::class, 'changePaymentStatus']);
                Route::post('assign-deliveryman', [AdminOrderManageController::class, 'assignDeliveryMan']);
                Route::post('cancel-order', [AdminOrderManageController::class, 'cancelOrder']);
                Route::get('refund-request', [AdminOrderRefundManageController::class, 'orderRefundRequest'])->middleware('permission:' . PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND_REQUEST->value);
                Route::post('refund-request/handle', [AdminOrderRefundManageController::class, 'handleRefundRequest'])->middleware('permission:' . PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND_REQUEST->value);
                Route::group(['prefix' => 'refund-reason/', 'middleware' => ['permission:' . PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND_REASON->value]], function () {
                    Route::get('list', [AdminOrderRefundManageController::class, 'allOrderRefundReason']);
                    Route::post('add', [AdminOrderRefundManageController::class, 'createOrderRefundReason']);
                    Route::get('details/{id}', [AdminOrderRefundManageController::class, 'showOrderRefundReason']);
                    Route::post('update', [AdminOrderRefundManageController::class, 'updateOrderRefundReason']);
                    Route::delete('remove/{id}', [AdminOrderRefundManageController::class, 'deleteOrderRefundReason']);
                });
                // Dynamic route should be last
                Route::get('{order_id?}', [AdminOrderManageController::class, 'allOrders']);
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
                Route::get('store-wise-products', [AdminProductManageController::class, 'getStoreWiseProducts']);
                Route::post('add', [AdminProductManageController::class, 'store']);
                Route::get('details/{slug}', [AdminProductManageController::class, 'show']);
                Route::post('update', [AdminProductManageController::class, 'update']);
                Route::delete('remove/{id?}', [AdminProductManageController::class, 'destroy']);
                Route::post('approve', [AdminProductManageController::class, 'approveProductRequests']);
                Route::get('request', [AdminProductManageController::class, 'productRequests'])->middleware('permission:' . PermissionKey::ADMIN_PRODUCT_PRODUCT_APPROVAL_REQ->value);
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
                Route::get('details/{id}', [AdminStoreManageController::class, 'show']);
            });
            // Store Add Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_ADD->value]], function () {
                Route::post('add', [AdminStoreManageController::class, 'store']);
                Route::post('update', [AdminStoreManageController::class, 'update']);
                Route::post('change-status', [AdminStoreManageController::class, 'changeStatus']);
                Route::delete('remove/{id}', [AdminStoreManageController::class, 'destroy']);
                Route::get('deleted-records', [AdminStoreManageController::class, 'deletedRecords']);
            });
            // Store Approval Request Routes
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_STORE_APPROVAL->value]], function () {
                Route::get('request', [AdminStoreManageController::class, 'storeRequest']);
                Route::post('approve', [AdminStoreManageController::class, 'approveStoreRequests']);
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
                    Route::get('list-dropdown', [AdminFlashSaleManageController::class, 'flashSaleDropdown']);
                    Route::post('add', [AdminFlashSaleManageController::class, 'createFlashSale']);
                    Route::post('add-products', [AdminFlashSaleManageController::class, 'adminAddProductToFlashSale']);
                    Route::get('all-products', [AdminFlashSaleManageController::class, 'getAllFlashSaleProducts']);
                    Route::get('store-wise-products', [AdminFlashSaleManageController::class, 'getProductsNotInFlashSale']);
                    Route::post('update-products', [AdminFlashSaleManageController::class, 'adminUpdateProductToFlashSale']);
                    Route::get('details/{id}', [AdminFlashSaleManageController::class, 'FlashSaleDetails']);
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
            Route::group(['prefix' => 'banner/', 'middleware' => ['permission:' . PermissionKey::ADMIN_PROMOTIONAL_BANNER_MANAGE->value]], function () {
                Route::get('list', [AdminBannerManageController::class, 'index']);
                Route::post('add', [AdminBannerManageController::class, 'store']);
                Route::get('details/{id}', [AdminBannerManageController::class, 'show']);
                Route::post('update', [AdminBannerManageController::class, 'update']);
                Route::delete('remove/{id}', [AdminBannerManageController::class, 'destroy']);
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
        });
        // contact message
        Route::group(['prefix' => 'contact-messages/', 'middleware' => ['permission:' . PermissionKey::ADMIN_CUSTOMER_CONTACT_MESSAGES->value]], function () {
            Route::get('list', [AdminContactManageController::class, 'index']);
            Route::post('reply', [AdminContactManageController::class, 'reply']);
            Route::post('change-status', [AdminContactManageController::class, 'changeStatus']);
            Route::delete('remove', [AdminContactManageController::class, 'destroy']);
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
            Route::get('details/{id}', [ProductAttributeController::class, 'show']);
            Route::get('type-wise', [ProductAttributeController::class, 'typeWiseAttributes']);
            Route::post('add', [ProductAttributeController::class, 'store']);
            Route::post('update', [ProductAttributeController::class, 'update']);
            Route::post('change-status', [ProductAttributeController::class, 'changeStatus']);
            Route::delete('remove/{id}', [ProductAttributeController::class, 'destroy']);
        });
        // Coupon manage
        Route::group(['prefix' => 'coupon/', 'middleware' => ['permission:' . PermissionKey::ADMIN_COUPON_MANAGE->value]], function () {
            Route::get('list', [CouponManageController::class, 'index']);
            Route::get('details/{id}', [CouponManageController::class, 'show']);
            Route::post('add', [CouponManageController::class, 'store']);
            Route::post('update', [CouponManageController::class, 'update']);
            Route::post('status-change', [CouponManageController::class, 'changeStatus']);
            Route::delete('remove/{id}', [CouponManageController::class, 'destroy']);
        });
        Route::group(['prefix' => 'coupon-line/', 'middleware' => ['permission:' . PermissionKey::ADMIN_COUPON_LINE_MANAGE->value]], function () {
            Route::get('list', [CouponManageController::class, 'couponLineIndex']);
            Route::get('details/{id}', [CouponManageController::class, 'couponLineShow']);
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
            Route::get('list', [AdminUnitManageController::class, 'index']);
            Route::post('add', [AdminUnitManageController::class, 'store']);
            Route::get('details/{id}', [AdminUnitManageController::class, 'show']);
            Route::post('update', [AdminUnitManageController::class, 'update']);
            Route::delete('remove/{id}', [AdminUnitManageController::class, 'destroy']);
        });
        // Blog manage
        Route::group(['prefix' => 'blog/', 'middleware' => ['permission:' . PermissionKey::ADMIN_BLOG_MANAGE->value]], function () {
            Route::get('list', [AdminBlogManageController::class, 'blogIndex']);
            Route::post('add', [AdminBlogManageController::class, 'blogStore']);
            Route::get('details/{id}', [AdminBlogManageController::class, 'blogShow']);
            Route::post('update', [AdminBlogManageController::class, 'blogUpdate']);
            Route::post('change-status', [AdminBlogManageController::class, 'changeStatus']);
            Route::delete('remove/{id}', [AdminBlogManageController::class, 'blogDestroy']);
            // Blog category manage
            Route::group(['prefix' => 'category/', 'middleware' => ['permission:' . PermissionKey::ADMIN_BLOG_CATEGORY_MANAGE->value]], function () {
                Route::get('list', [AdminBlogManageController::class, 'blogCategoryIndex']);
                Route::get('fetch/list', [AdminBlogManageController::class, 'blogCategoryList']);
                Route::post('add', [AdminBlogManageController::class, 'blogCategoryStore']);
                Route::get('details/{id}', [AdminBlogManageController::class, 'blogCategoryShow']);
                Route::post('update', [AdminBlogManageController::class, 'blogCategoryUpdate']);
                Route::post('change-status', [AdminBlogManageController::class, 'categoryStatusChange']);
                Route::delete('remove/{id}', [AdminBlogManageController::class, 'blogCategoryDestroy']);
            });
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
            Route::get('list', [AdminStoreNoticeController::class, 'index']); // Get all notices
            Route::post('add', [AdminStoreNoticeController::class, 'store']); // Create a new notice
            Route::get('details/{id}', [AdminStoreNoticeController::class, 'show']); // View a specific notice
            Route::post('update', [AdminStoreNoticeController::class, 'update']); // Update a specific notice
            Route::post('change-status', [AdminStoreNoticeController::class, 'changeStatus']); // Change notice status
            Route::delete('remove/{id}', [AdminStoreNoticeController::class, 'destroy']); // Delete a specific notice
        });
        Route::group(['prefix' => 'feedback-control/'], function () {
            Route::group(['prefix' => 'review/'], function () {
                Route::get('/', [AdminReviewManageController::class, 'index']);
                Route::post('approve', [AdminReviewManageController::class, 'approveReview']);
                Route::post('reject', [AdminReviewManageController::class, 'rejectReview']);
                Route::post('remove', [AdminReviewManageController::class, 'destroy']);
            });
            Route::group(['prefix' => 'questions/'], function () {
                Route::get('/', [AdminProductQueryManageController::class, 'getAllQueries']);
                Route::post('change-status', [AdminProductQueryManageController::class, 'changeStatus']);
                Route::post('remove', [AdminProductQueryManageController::class, 'destroy']);
            });
        });
        // Admin Deliveryman management
        Route::prefix('deliveryman/')->group(function () {
            // delivery man manage
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_DELIVERYMAN_MANAGE_LIST->value]], function () {
                Route::get('list', [AdminDeliverymanManageController::class, 'index']);
                Route::get('list-dropdown', [AdminDeliverymanManageController::class, 'deliverymanDropdownList']);
                Route::get('request', [AdminDeliverymanManageController::class, 'deliverymanRequest']);
                Route::post('add', [AdminDeliverymanManageController::class, 'store']);
                Route::get('details/{id}', [AdminDeliverymanManageController::class, 'show']);
                Route::post('update', [AdminDeliverymanManageController::class, 'update']);
                Route::post('change-status', [AdminDeliverymanManageController::class, 'changeStatus']);
                Route::post('approve', [AdminDeliverymanManageController::class, 'approveRequest']);
                Route::delete('remove/{id}', [AdminDeliverymanManageController::class, 'destroy']);
            });
            //vehicle-types
            Route::prefix('vehicle-types/')->middleware(['permission:' . PermissionKey::ADMIN_DELIVERYMAN_VEHICLE_TYPE->value])->group(function () {
                Route::get('list', [AdminDeliverymanManageController::class, 'indexVehicle']);
                Route::get('list-dropdown', [AdminDeliverymanManageController::class, 'vehicleTypeDropdown']);
                Route::get('request', [AdminDeliverymanManageController::class, 'vehicleRequest']);
                Route::post('add', [AdminDeliverymanManageController::class, 'storeVehicle']);
                Route::get('details/{id}', [AdminDeliverymanManageController::class, 'showVehicle']);
                Route::post('update', [AdminDeliverymanManageController::class, 'updateVehicle']);
                Route::post('change-status', [AdminDeliverymanManageController::class, 'changeVehicleStatus']);
                Route::post('approve', [AdminDeliverymanManageController::class, 'approveVehicleRequest']);
                Route::delete('remove/{id}', [AdminDeliverymanManageController::class, 'destroyVehicle']);
            });
            // deliveryman review manage
            Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_DELIVERYMAN_MANAGE_REVIEW->value]], function () {
                Route::get('reviews', [AdminDeliverymanReviewManageController::class, 'index']);
            });
        });

        // Support ticket management
        Route::group(['prefix' => 'support-ticket/', 'middleware' => 'permission:' . PermissionKey::ADMIN_SUPPORT_TICKETS_MANAGE->value], function () {
            Route::get('list', [AdminSupportTicketManageController::class, 'index']);
            Route::get('details/{id?}', [AdminSupportTicketManageController::class, 'show']);
            Route::post('change-priority-status', [AdminSupportTicketManageController::class, 'changePriorityStatus']);
            Route::post('resolve', [AdminSupportTicketManageController::class, 'resolve']);
            Route::post('message/reply', [AdminSupportTicketManageController::class, 'replyMessage']);
            Route::get('get-ticket-messages/{ticket_id}', [AdminSupportTicketManageController::class, 'getTicketMessages']);
        });

        // FINANCIAL WITHDRAWALS management
        Route::group(['prefix' => 'financial/'], function () {
            // waller manage
            Route::group(['prefix' => 'wallet/', PermissionKey::ADMIN_WALLET_MANAGE->value], function () {
                Route::match(['get', 'post'], 'settings', [WalletManageAdminController::class, 'depositSettings'])->middleware(['permission:' . PermissionKey::ADMIN_WALLET_SETTINGS->value]);
                Route::get('list', [WalletManageAdminController::class, 'index']);
                Route::post('status/{id?}', [WalletManageAdminController::class, 'status']);
                Route::post('deposit', [WalletManageAdminController::class, 'depositCreateByAdmin']);
                Route::get('transactions', [WalletManageAdminController::class, 'transactionRecords'])->middleware(['permission:' . PermissionKey::ADMIN_WALLET_TRANSACTION->value]);
                Route::post('transactions-status/{id}', [WalletManageAdminController::class, 'transactionStatus']);
            });

            // withdrawals manage
            Route::group(['prefix' => 'withdraw/'], function () {
                // settings
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_SETTINGS->value], function () {
                    Route::match(['get', 'post'], 'settings', [AdminWithdrawSettingsController::class, 'withdrawSettings']);
                });
                // gateway manage
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_WITHDRAW_METHOD_MANAGEMENT->value], function () {
                    Route::get('gateway-list', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayList']);
                    Route::post('gateway-add', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayAdd']);
                    Route::get('gateway-details/{id?}', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayDetails']);
                    Route::post('gateway-update', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayUpdate']);
                    Route::delete('gateway-delete/{id}', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayDelete']);
                    Route::post('gateway-change-status', [AdminWithdrawGatewayManageController::class, 'withdrawGatewayChangeStatus']);
                });

                // all manage
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_HISTORY->value], function () {
                    Route::get('/', [AdminWithdrawManageController::class, 'withdrawAllList']);
                    Route::get('details/{id}', [AdminWithdrawManageController::class, 'withdrawDetails']);
                });
                // request manage
                Route::group(['middleware' => 'permission:' . PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST->value], function () {
                    Route::get('request-list', [AdminWithdrawRequestManageController::class, 'withdrawRequestList']);
                    Route::post('request-approve', [AdminWithdrawRequestManageController::class, 'withdrawRequestApprove']);
                    Route::post('request-reject', [AdminWithdrawRequestManageController::class, 'withdrawRequestReject']);
                });
            });
            // Collect Cash (for cash collection)
            Route::get('cash-collection', [AdminCashCollectionController::class, 'collectCash'])->middleware('permission:' . PermissionKey::ADMIN_FINANCIAL_COLLECT_CASH->value);
        });


        // business-operations
        Route::group(['prefix' => 'business-operations/'], function () {
            // store type
            Route::group(['prefix' => 'store-type/', 'middleware' => 'permission:' . PermissionKey::ADMIN_STORE_TYPE_MANAGE->value], function () {
                Route::get('list', [AdminStoreTypeManageController::class, 'allStoreTypes']);
                Route::get('details/{id}', [AdminStoreTypeManageController::class, 'storeTypeDetails']);
                Route::post('update', [AdminStoreTypeManageController::class, 'updateStoreType']);
                Route::post('change-status', [AdminStoreTypeManageController::class, 'changeStatus']);
            });
            // area setup
            Route::prefix('area/')->middleware(['permission:' . PermissionKey::ADMIN_GEO_AREA_MANAGE->value])->group(function () {
                Route::get('list', [AdminAreaSetupManageController::class, 'index']);
                Route::post('add', [AdminAreaSetupManageController::class, 'store']);
                Route::post('update', [AdminAreaSetupManageController::class, 'update']);
                Route::get('details/{id}', [AdminAreaSetupManageController::class, 'show']);
                Route::post('change-status', [AdminAreaSetupManageController::class, 'changeStatus']);
                Route::delete('remove/{id}', [AdminAreaSetupManageController::class, 'destroy']);
                Route::post('settings/update', [AdminAreaSetupManageController::class, 'updateStoreAreaSetting']);
                Route::get('settings/details/{store_area_id}', [AdminAreaSetupManageController::class, 'storeAreaSettingsDetails']);
            });
            // commission Settings
            Route::prefix('commission')->middleware(['permission:' . PermissionKey::ADMIN_COMMISSION_SETTINGS->value])->group(function () {
                Route::match(['get', 'post'], '/settings', [AdminCommissionManageController::class, 'commissionSettings']);
            });
        });
        // report-analytics
        Route::group(['prefix' => 'report-analytics/'], function () {
            Route::get('reportList', [AdminReportAnalyticsManageController::class, 'reportList'])->middleware('permission:' . PermissionKey::ADMIN_REPORT_ANALYTICS_ORDER->value);
            Route::get('order', [AdminReportAnalyticsManageController::class, 'orderReport'])->middleware('permission:' . PermissionKey::ADMIN_REPORT_ANALYTICS_ORDER->value);
        });

        /*--------------------- System management ----------------------------*/
        Route::group(['prefix' => 'system-management/'], function () {
            Route::match(['get', 'post'], '/general-settings', [SystemManagementController::class, 'generalSettings'])->middleware('permission:' . PermissionKey::GENERAL_SETTINGS->value);
            Route::match(['get', 'post'], '/footer-customization', [SystemManagementController::class, 'footerCustomization'])->middleware('permission:' . PermissionKey::FOOTER_CUSTOMIZATION->value);
            Route::match(['get', 'post'], '/maintenance-settings', [SystemManagementController::class, 'maintenanceSettings'])->middleware('permission:' . PermissionKey::MAINTENANCE_SETTINGS->value);
            Route::match(['get', 'post'], '/seo-settings', [SystemManagementController::class, 'seoSettings'])->middleware('permission:' . PermissionKey::SEO_SETTINGS->value);
            Route::match(['get', 'post'], '/firebase-settings', [SystemManagementController::class, 'firebaseSettings'])->middleware('permission:' . PermissionKey::FIREBASE_SETTINGS->value);
            Route::match(['get', 'post'], '/social-login-settings', [SystemManagementController::class, 'socialLoginSettings'])->middleware('permission:' . PermissionKey::SOCIAL_LOGIN_SETTINGS->value);
            Route::match(['get', 'post'], '/google-map-settings', [SystemManagementController::class, 'googleMapSettings'])->middleware('permission:' . PermissionKey::GOOGLE_MAP_SETTINGS->value);
            // database and cache settings
            Route::post('/cache-management', [SystemManagementController::class, 'cacheManagement'])->middleware('permission:' . PermissionKey::CACHE_MANAGEMENT->value);
            Route::post('/database-update-controls', [SystemManagementController::class, 'DatabaseUpdateControl'])->middleware('permission:' . PermissionKey::DATABASE_UPDATE_CONTROLS->value);
            // email settings
            Route::group(['middleware' => ['permission:' . PermissionKey::SMTP_SETTINGS->value]], function () {
                Route::match(['get', 'post'], '/email-settings/smtp', [EmailSettingsController::class, 'smtpSettings']);
                Route::post('/email-settings/test-mail-send', [EmailSettingsController::class, 'testMailSend']);
            });
            // email settings

            Route::group(['prefix' => 'email-settings/email-template/', 'middleware' => 'permission:' . PermissionKey::EMAIL_TEMPLATES->value], function () {
                Route::get('list', [EmailTemplateManageController::class, 'allEmailTemplate']);
                Route::post('add', [EmailTemplateManageController::class, 'addEmailTemplate']);
                Route::get('details/{id}', [EmailTemplateManageController::class, 'emailTemplateDetails']);
                Route::post('edit', [EmailTemplateManageController::class, 'editEmailTemplate']);
                Route::delete('remove/{id}', [EmailTemplateManageController::class, 'deleteEmailTemplate']);
                Route::post('change-status', [EmailTemplateManageController::class, 'changeStatus']);
            });
        });

        /*--------------------- Roles &  permissions manage ----------------------------*/
        Route::get('permissions', [PermissionController::class, 'index']);
        Route::post('permissions-for-store-owner', [PermissionController::class, 'permissionForStoreOwner']);
        Route::get('module-wise-permissions', [PermissionController::class, 'moduleWisePermissions']);
        Route::get('roles', [RoleController::class, 'index']);
        Route::post('roles', [RoleController::class, 'store']);
        Route::get('roles/{id}', [RoleController::class, 'show']);
        Route::post('roles/change-status', [RoleController::class, 'changeStatus']);
    });
});
