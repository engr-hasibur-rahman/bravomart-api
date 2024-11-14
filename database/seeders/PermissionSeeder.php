<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\MenuGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $page_list = [

            [
                'module' => MenuGroup::GENERAL->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::GENERAL->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ALL->value,
                        'PermissionTitle' => 'All',
                        'activity_scope' => 'common'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::CENTRAL->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::CENTRAL->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ADMIN_AREA_LIST->value,
                        'PermissionTitle' => 'Area List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_ADD->value,
                        'PermissionTitle' => 'Area Add',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_UPDATE->value,
                        'PermissionTitle' => 'Area Update',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::STORES->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::STORES->value),
                'permissions' => [

                    [
                        'PermissionName' => Permission::ADMIN_STORE_ADD->value,
                        'PermissionTitle' => 'Store Add',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_STORE_LIST->value,
                        'PermissionTitle' => 'Store List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_RECOMMENDED->value,
                        'PermissionTitle' => 'Recommended Store',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_APPROVAL->value,
                        'PermissionTitle' => 'Pending Approval/ Rejected',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_ADD_UPDATE->value,
                        'PermissionTitle' => 'Store Add/Update',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::POS_SALES->value,
                        'PermissionTitle' => 'Pos Sales',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::POS_SETTINGS_ADMIN->value,
                        'PermissionTitle' => 'Pos Settings',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::POS_SETTINGS_STORE->value,
                        'PermissionTitle' => 'Pos Settings',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_ATTRIBUTE->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_ATTRIBUTE->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST->value,
                        'PermissionTitle' => 'Attribute List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_ADD->value,
                        'PermissionTitle' => 'Add Attribute',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_EDIT->value,
                        'PermissionTitle' => 'Edit Attribute',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_DELETE->value,
                        'PermissionTitle' => 'Delete Attribute',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST_STORE->value,
                        'PermissionTitle' => 'Attributes',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_WARRANTY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_WARRANTY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_LIST->value,
                        'PermissionTitle' => 'Warranty List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_ADD->value,
                        'PermissionTitle' => 'Add Warranty',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_EDIT->value,
                        'PermissionTitle' => 'Edit Warranty',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_LIST_STORE->value,
                        'PermissionTitle' => 'Warranty',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_BRAND->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_BRAND->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_LIST->value,
                        'PermissionTitle' => 'Product Brand List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_ADD->value,
                        'PermissionTitle' => 'Add Product Brand',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_EDIT->value,
                        'PermissionTitle' => 'Edit Product Brand',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_STATUS->value,
                        'PermissionTitle' => 'Change Brand Status',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_LIST_STORE->value,
                        'PermissionTitle' => 'Brand/Manufacturers/Publications',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_REQUESTED_FROM_STORE->value,
                        'PermissionTitle' => 'Approve Brand Request From Store',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::BOOK_AUTHORS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::BOOK_AUTHORS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_LIST->value,
                        'PermissionTitle' => 'Author\'s List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_ADD->value,
                        'PermissionTitle' => 'Add Book Author',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_EDIT->value,
                        'PermissionTitle' => 'Edit Author\'s Name',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_DELETE->value,
                        'PermissionTitle' => 'Delete Author\'s Name ',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_LIST_STORE->value,
                        'PermissionTitle' => 'Author\'s List',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_REQUESTED_FROM_STORE->value,
                        'PermissionTitle' => 'Approve Author Enlist Request From Store',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_CATEGORY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_CATEGORY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_LIST->value,
                        'PermissionTitle' => 'Product Category List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_ADD->value,
                        'PermissionTitle' => 'Add Product Category',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_EDIT->value,
                        'PermissionTitle' => 'Edit Product Category',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_STATUS->value,
                        'PermissionTitle' => 'Change Category Status',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_LIST_STORE->value,
                        'PermissionTitle' => 'Category List',
                        'activity_scope' => 'store_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::PRODUCT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_LIST->value,
                        'PermissionTitle' => 'Manage Products',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
                        'PermissionTitle' => 'Add New Product',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_EDIT->value,
                        'PermissionTitle' => 'Edit Product',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_DELETE->value,
                        'PermissionTitle' => 'Delete Product',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_LOW_STOCK->value,
                        'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_TEMPLATE->value,
                        'PermissionTitle' => 'Product Template',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_IMPORT->value,
                        'PermissionTitle' => 'Bulk Import',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_EXPORT->value,
                        'PermissionTitle' => 'Bulk Export',
                        'activity_scope' => 'common'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_ADDONS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_ADDONS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_LIST->value,
                        'PermissionTitle' => 'Manage addons',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_ADD->value,
                        'PermissionTitle' => 'Add New addon',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_EDIT->value,
                        'PermissionTitle' => 'Edit addon',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_DELETE->value,
                        'PermissionTitle' => 'Delete addon',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_FAB_COMB->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_FAB_COMB->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_LIST->value,
                        'PermissionTitle' => 'Manage Combinations',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_ADD->value,
                        'PermissionTitle' => 'Add Combinations',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_EDIT->value,
                        'PermissionTitle' => 'Edit Combinations',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_DELETE->value,
                        'PermissionTitle' => 'Delete Combinations',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::ORDER_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::ORDER_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ORDERS_ALL->value,
                        'PermissionTitle' => 'All Orders',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_PENDING->value,
                        'PermissionTitle' => 'Pending',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_CONFIRMED->value,
                        'PermissionTitle' => 'Confirmed',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_SCHEDULED->value,
                        'PermissionTitle' => 'Scheduled',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_COOKING->value,
                        'PermissionTitle' => 'Cooking (For Restaurant)',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_READY_FOR_DELIVERY->value,
                        'PermissionTitle' => 'Ready For Delivery',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_PRODUCT_ON_THE_WAY->value,
                        'PermissionTitle' => 'Item On The Way',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_DELIVERED->value,
                        'PermissionTitle' => 'Delivered',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_FITTING_SCHEDULE->value,
                        'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
                        'PermissionTitle' => 'Returned or Refunded',
                        'activity_scope' => 'common'
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
                        'PermissionTitle' => 'Returned or Refunded',
                        'activity_scope' => 'common'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FINANCIAL_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FINANCIAL_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FINANCIAL_TRANSACTIONS->value,
                        'PermissionTitle' => 'Transactions',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAWLS->value,
                        'PermissionTitle' => 'Withdrawals',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_MYINCOME->value,
                        'PermissionTitle' => 'My Income',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FEEDBACK_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FEEDBACK_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FEEDBACK_REVIEWS->value,
                        'PermissionTitle' => 'Reviews',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::FEEDBACK_QUESTIONS->value,
                        'PermissionTitle' => 'Questions/Chat',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::FEEDBACK_QUERIES->value,
                        'PermissionTitle' => 'Product Queries',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::DELIVERYMAN_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::DELIVERYMAN_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::DELIVERY_VEHICLE_CATEGORY->value,
                        'PermissionTitle' => 'Vehicles category',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSON_ADD->value,
                        'PermissionTitle' => 'Add Delivery Man',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSON_LIST->value,
                        'PermissionTitle' => 'Delivery Man List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSONS_REVIEW->value,
                        'PermissionTitle' => 'Reviews',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::CUSTOMER_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::CUSTOMER_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::CUSTOMER_LIST->value,
                        'PermissionTitle' => 'Customers',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_ADD_FUND->value,
                        'PermissionTitle' => 'Add Fund',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_REPORT->value,
                        'PermissionTitle' => 'Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_BONUS->value,
                        'PermissionTitle' => 'Bonus',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_LOYALTY_POINT->value,
                        'PermissionTitle' => 'Customer Loyalty Point',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                        'PermissionTitle' => 'Subscribe Mail List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_CONTACT_MESSAGES->value,
                        'PermissionTitle' => 'Contact Messages',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PROMOTION_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PROMOTION_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FLASH_SALES_ALL_CAMPAIGNS->value,
                        'PermissionTitle' => 'Flash Sales List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_ADD_CAMPAIGN_ADMIN->value,
                        'PermissionTitle' => 'Add Flash Sales',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_APPROVE_CAMPAIGN->value,
                        'PermissionTitle' => 'Flash Sales Request Approve',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_JOIN->value,
                        'PermissionTitle' => 'Available flash deals',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_ADD_CAMPAIGN_STORE->value,
                        'PermissionTitle' => 'Add Flash Sales',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_COUPONS->value,
                        'PermissionTitle' => 'Coupons',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_BANNERS->value,
                        'PermissionTitle' => 'Banners',
                        'activity_scope' => 'store_level'
                    ],[
                        'PermissionName' => Permission::PROMOTION_DEALS_AVAILABLE->value,
                        'PermissionTitle' => 'Available flash deals',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_MY_PRODUCT_IN_DEALS->value,
                        'PermissionTitle' => 'My products in deals',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_ASK_FOR_ENROLL->value,
                        'PermissionTitle' => 'Ask for enrollment',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_BANNERS->value,
                        'PermissionTitle' => 'Banners',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::STORE_SETTINGS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::STORE_SETTINGS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::STORE_STORE_NOTICE->value,
                        'PermissionTitle' => 'Store Notice',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_MESSAGE->value,
                        'PermissionTitle' => 'Message',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_CONFIG->value,
                        'PermissionTitle' => 'STORE CONFIG',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_MY_SHOP->value,
                        'PermissionTitle' => 'MY SHOP',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_BUSINESS_PLAN->value,
                        'PermissionTitle' => 'My Business Plan',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_WALLET->value,
                        'PermissionTitle' => 'My Wallet',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_DISBURSE_METHOD->value,
                        'PermissionTitle' => 'Disbursement Method',
                        'activity_scope' => 'store_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_POS_CONFIG->value,
                        'PermissionTitle' => 'POS Configuration',
                        'activity_scope' => 'store_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FINANCIAL_ACTIVITY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FINANCIAL_ACTIVITY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAW_REQUESTS->value,
                        'PermissionTitle' => 'Withdraw Requests',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_STORE_DISBURSEMENT->value,
                        'PermissionTitle' => 'Store Disbursement',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value,
                        'PermissionTitle' => 'Delivery Man Disbursement',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_COLLECT_CASH->value,
                        'PermissionTitle' => 'Collect Cash',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_PAYMENTS->value,
                        'PermissionTitle' => 'Delivery Man Payments',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAW_METHOD->value,
                        'PermissionTitle' => 'Withdraw Method',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::REPORTS_ANALYTICS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::REPORTS_ANALYTICS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::TRANSACTION_REPORT->value,
                        'PermissionTitle' => 'Transaction Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ITEM_REPORT->value,
                        'PermissionTitle' => 'Item Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::STORE_WISE_REPORT->value,
                        'PermissionTitle' => 'Store-wise Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::EXPENSE_REPORT->value,
                        'PermissionTitle' => 'Expense Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::DISBURSEMENT_REPORT->value,
                        'PermissionTitle' => 'Disbursement Report',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ORDER_REPORT->value,
                        'PermissionTitle' => 'Order Report',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::BUSINESS_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::BUSINESS_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::BUSINESS_SETTINGS->value,
                        'PermissionTitle' => 'Business Settings',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIPTION_PACKAGE->value,
                        'PermissionTitle' => 'Subscription Package',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIBER_LIST->value,
                        'PermissionTitle' => 'Subscriber List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIPTION_SETTINGS->value,
                        'PermissionTitle' => 'Settings',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_SOCIAL_MEDIA->value,
                        'PermissionTitle' => 'Social Media',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_ADMIN_LANDING_PAGE->value,
                        'PermissionTitle' => 'Admin landing page',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_REACT_LANDING_PAGE->value,
                        'PermissionTitle' => 'React landing page',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_FLUTTER_LANDING_PAGE->value,
                        'PermissionTitle' => 'Flutter landing page',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PAGE_TERMS_AND_CONDITION->value,
                        'PermissionTitle' => 'Terms and condition',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PAGE_PRIVACY_POLICY->value,
                        'PermissionTitle' => 'Privacy policy',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PAGE_ABOUT_US->value,
                        'PermissionTitle' => 'About us',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PAGE_REFUND_POLICY->value,
                        'PermissionTitle' => 'Refund Policy',
                        'activity_scope' => 'system_level'
                    ]
                    ,
                    [
                        'PermissionName' => Permission::PAGE_CANCELLATION_POLICY->value,
                        'PermissionTitle' => 'Cancellation Policy',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PAGE_SHIPPING_POLICY->value,
                        'PermissionTitle' => 'Shipping Policy',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::IMAGE_GALLERY->value,
                        'PermissionTitle' => 'Gallery',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::USERS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::USERS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::USERS_BAN->value,
                        'PermissionTitle' => 'Ban User',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::USERS_ACTIVE->value,
                        'PermissionTitle' => 'Active User',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::USERS_ROLES_STORE->value,
                        'PermissionTitle' => 'Staff Roles',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::USERS_STAFF_ADD_STORE->value,
                        'PermissionTitle' => 'Add New',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::USERS_STAFF_LIST_STORE->value,
                        'PermissionTitle' => 'List',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::SYSTEM_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::SYSTEM_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::THIRD_PARTY->value,
                        'PermissionTitle' => '3rd party',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::FIREBASE_NOTIFICATION->value,
                        'PermissionTitle' => 'Firebase notification',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::OFFLINE_PAYMENT_SETUP->value,
                        'PermissionTitle' => 'Offline Payment Setup',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::LOGIN_SETUP->value,
                        'PermissionTitle' => 'Login setup',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::REACT_SITE->value,
                        'PermissionTitle' => 'React site',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::EMAIL_TEMPLATE->value,
                        'PermissionTitle' => 'Email template',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::APP_SETTINGS->value,
                        'PermissionTitle' => 'App settings',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::NOTIFICATION_CHANNELS->value,
                        'PermissionTitle' => 'Notification Channels',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::OTHERS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::OTHERS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::MANAGE_CONFIGURATIONS->value,
                        'PermissionTitle' => 'Manage Configuration',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ]
        ];


        foreach ($page_list as $x_mod) {
            foreach ($x_mod['permissions'] as $x_page) {
                ModelsPermission::updateOrCreate(
                    [
                        'name' => $x_page['PermissionName'],
                        'perm_title' => $x_page['PermissionTitle'],
                        'guard_name' => 'api',
                        'module' => $x_mod['module'],
                        'module_title' => $x_mod['module_tile'],
                        'available_for' => $x_page['activity_scope']
                    ]
                );
            }
        }
    }
}
