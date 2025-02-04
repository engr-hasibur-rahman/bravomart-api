<?php

use App\Enums\PermissionKey;
use App\Http\Controllers\Api\V1\Product\ProductAttributeController;
use App\Http\Controllers\Api\V1\Product\ProductAuthorController;
use App\Http\Controllers\Api\V1\Product\ProductVariantController;
use App\Http\Controllers\Api\V1\Seller\SellerBannerManageController;
use App\Http\Controllers\Api\V1\Seller\SellerBusinessSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerDeliverymanManageController;
use App\Http\Controllers\Api\V1\Seller\SellerFlashSaleProductManageController;
use App\Http\Controllers\Api\V1\Seller\SellerInventoryManageController;
use App\Http\Controllers\Api\V1\Seller\SellerManageController;
use App\Http\Controllers\Api\V1\Seller\SellerPosSalesController;
use App\Http\Controllers\Api\V1\Seller\SellerPosSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerProductManageController;
use App\Http\Controllers\Api\V1\Seller\SellerReviewController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreDashboardManageController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreManageController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreNoticeController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreOrderController;
use App\Http\Controllers\Api\V1\Seller\SellerStoreSettingsController;
use App\Http\Controllers\Api\V1\Seller\SellerSupportTicketManageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\V1', 'middleware' => ['auth:sanctum', 'no.code.input']], function () {
    Route::group(['prefix' => 'seller/'], function () {
        Route::post('/registration', [UserController::class, 'StoreOwnerRegistration']);
        Route::get('/store-fetch-list', [SellerStoreManageController::class, 'ownerWiseStore']);
        Route::get('attributes/type-wise', [ProductAttributeController::class, 'typeWiseAttributes']);

        // verify email
        Route::post('send-verification-email', [SellerManageController::class, 'sendVerificationEmail']);
        Route::post('verify-email', [SellerManageController::class, 'verifyEmail']);
        Route::post('resend-verification-email', [SellerManageController::class, 'resendVerificationEmail']);

        // profile manage
        Route::group(['prefix' => 'profile/'], function () {
            Route::get('/', [SellerManageController::class, 'getProfile']);
        });

        // Support ticket manage
        Route::group(['prefix' => 'support-ticket/'], function () {
            Route::post('message/reply', [SellerSupportTicketManageController::class, 'replyMessage']);
        });


        // profile manage
        Route::group(['prefix' => 'profile/'], function () {
            Route::get('/', [SellerManageController::class, 'getProfile']);
            Route::post('/update', [SellerManageController::class, 'updateProfile']);
            Route::post('/change-email', [SellerManageController::class, 'updateEmail']);
            Route::get('/deactivate', [SellerManageController::class, 'deactivateAccount']);
            Route::get('/delete', [SellerManageController::class, 'deleteAccount']);
        });

        // Store manage
        Route::group(['prefix' => 'store/'], function () {
            Route::get('dashboard', [SellerStoreDashboardManageController::class, 'dashboard']);
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
            // seller deliveryman manage
            Route::group(['prefix' => 'deliveryman/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::ADMIN_DELIVERYMAN_MANAGE_LIST->value]], function () {
                    Route::get('list', [SellerDeliverymanManageController::class, 'index']);
                    Route::post('add', [SellerDeliverymanManageController::class, 'store']);
                    Route::get('details/{id}', [SellerDeliverymanManageController::class, 'show']);
                    Route::post('update', [SellerDeliverymanManageController::class, 'update']);
                    Route::post('change-status', [SellerDeliverymanManageController::class, 'changeStatus']);
                    Route::delete('remove/{id}', [SellerDeliverymanManageController::class, 'destroy']);
                });
                //vehicle-types
                Route::prefix('vehicle-types/')->middleware(['permission:' . PermissionKey::ADMIN_DELIVERYMAN_VEHICLE_TYPE->value])->group(function () {
                    Route::get('list', [SellerDeliverymanManageController::class, 'indexVehicle']);
                    Route::post('add', [SellerDeliverymanManageController::class, 'storeVehicle']);
                    Route::get('details/{id}', [SellerDeliverymanManageController::class, 'showVehicle']);
                    Route::post('update', [SellerDeliverymanManageController::class, 'updateVehicle']);
                    Route::post('change-status', [SellerDeliverymanManageController::class, 'changeVehicleStatus']);
                    Route::delete('remove/{id}', [SellerDeliverymanManageController::class, 'destroyVehicle']);
                });
            });
            // seller product manage
            Route::group(['prefix' => 'orders/'], function () {
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_ORDER_MANAGE->value]], function () {
                    Route::get('/', [SellerStoreOrderController::class, 'allOrders']);
                });
                Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_ORDERS_RETURNED_OR_REFUND->value]], function () {
                    Route::get('/returned', [SellerStoreOrderController::class, 'returnedOrders']);
                });
            });

            // store manage
            Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_MY_SHOP->value]], function () {
                Route::get('list', [SellerStoreManageController::class, 'index']);
                Route::get('details/{id}', [SellerStoreManageController::class, 'show']);
                Route::post('add', [SellerStoreManageController::class, 'store']); // create store
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
                    Route::get('stock-report', [SellerProductManageController::class, 'lowOrOutOfStockProducts'])->middleware('permission:' . PermissionKey::SELLER_STORE_PRODUCT_STOCK_REPORT->value);
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

            });
            // Review
            Route::group(['prefix' => 'feedback-control/'], function () {
                Route::group(['prefix' => 'review/', 'middleware' => 'permission:' . PermissionKey::SELLER_STORE_FEEDBACK_CONTROL_REVIEWS->value], function () {
                    Route::get('/', [SellerReviewController::class, 'index']);
                });
            });

            // store settings
            Route::group(['prefix' => 'settings/'], function () {
                // business settings
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_BUSINESS_PLAN->value], function () {
                    Route::get('business-plan', [SellerBusinessSettingsController::class, 'businessPlanInfo']);
                    Route::post('business-plan-change', [SellerBusinessSettingsController::class, 'businessPlanChange']);
                });
                // store notice
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_STORE_NOTICE->value], function () {
                    Route::get('notices', [SellerStoreSettingsController::class, 'storeNotice']);
                });
                // store config
                Route::group(['middleware' => 'permission:' . PermissionKey::SELLER_STORE_STORE_CONFIG->value], function () {
                    Route::match(['get', 'put'], 'config', [SellerStoreSettingsController::class, 'storeConfig']);
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
                        Route::post('update-join-deals', [SellerFlashSaleProductManageController::class, 'updateProductToFlashSale']);
                    });
                    Route::group(['middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_ACTIVE_DEALS->value]], function () {
                        Route::get('active-deals', [SellerFlashSaleProductManageController::class, 'getValidFlashSales']);
                    });
                });

                // Banner Management
                Route::group(['prefix' => 'banner/', 'middleware' => ['permission:' . PermissionKey::SELLER_STORE_PROMOTIONAL_BANNER_MANAGE->value]], function () {
                    Route::get('list', [SellerBannerManageController::class, 'index']);
                    Route::post('add', [SellerBannerManageController::class, 'store']);
                    Route::get('details/{id}', [SellerBannerManageController::class, 'show']);
                    Route::post('update', [SellerBannerManageController::class, 'update']);
                    Route::delete('remove/{id}', [SellerBannerManageController::class, 'destroy']);
                });
            });

            // Seller  Product Author manage
            Route::group(['prefix' => 'product/author/', 'middleware' => ['permission:' . PermissionKey::SELLER_PRODUCT_AUTHORS_MANAGE->value]], function () {
                Route::get('list', [ProductAuthorController::class, 'sellerAuthors']);
                Route::post('add', [ProductAuthorController::class, 'authorAddRequest']);
                Route::get('details/{id}', [ProductAuthorController::class, 'show']);
                Route::delete('remove/{id}', [ProductAuthorController::class, 'destroy']);
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
        // Store Notice manage
        Route::group(['prefix' => 'store-notices/'], function () {
            Route::get('list', [SellerStoreNoticeController::class, 'index']); // Get all notices
            Route::get('details/{id}', [SellerStoreNoticeController::class, 'show']); // View a specific notice
        });
    });
});
