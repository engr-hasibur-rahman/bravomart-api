<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Permission: string
{
    use InvokableCases;
    use Values;


    case ALL = 'all';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  POS Management                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case POS_SALES = 'pos-sales';
    case POS_SETTINGS_ADMIN = 'pos-settings-admin';
    case POS_SETTINGS_STORE = 'pos-settings-store';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Area Management                                         //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_AREA_LIST = 'area-list';
    case ADMIN_AREA_ADD = 'add-area';
    case ADMIN_AREA_UPDATE = 'update-area';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Store Management                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_STORE_LIST = 'store-list';
    case ADMIN_STORE_ADD = 'store-add';
    case STORE_STORE_ADD_UPDATE = 'store-add-update'; // Add if user have no store added. Update if existis 

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Store Settings                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case STORE_STORE_NOTICE = 'store-notice';
    case STORE_STORE_MESSAGE = 'store-message';
    case STORE_STORE_CONFIG = 'store-config';
    case STORE_MY_SHOP = 'my-store-list';
    case STORE_BUSINESS_PLAN = 'my-business-plan';
    case STORE_WALLET = 'my-wallet';
    case STORE_DISBURSE_METHOD = 'my-disburse-method';
    case STORE_POS_CONFIG = 'pos-config';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Brand/Manufacturers/Publications (For Book Only)                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_BRAND_LIST = 'product-brand-list';
    case PRODUCT_BRAND_ADD = 'product-brand-add';
    case PRODUCT_BRAND_EDIT = 'product-brand-edit';
    case PRODUCT_BRAND_STATUS = 'product-brand-status';
    case PRODUCT_BRAND_LIST_STORE = 'brand-list-store';
    case PRODUCT_BRAND_REQUESTED_FROM_STORE = 'brand-req-from-store';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product category Permissions                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_CATEGORY_LIST = 'product-category-list';
    case PRODUCT_CATEGORY_ADD = 'add-product-category';
    case PRODUCT_CATEGORY_EDIT = 'edit-product-category';
    case PRODUCT_CATEGORY_STATUS = 'product-category-status';
    case PRODUCT_CATEGORY_LIST_STORE = 'product-category-list-store';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Attribute                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_ATTRIBUTE_LIST = 'attributes';
    case PRODUCT_ATTRIBUTE_ADD = 'product-attribute-add';   
    case PRODUCT_ATTRIBUTE_EDIT = 'product-attribute-edit';
    case PRODUCT_ATTRIBUTE_DELETE = 'product-attribute-delete';
    case PRODUCT_ATTRIBUTE_LIST_STORE = 'attribute-list';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product Authors (For Book Only)                                 //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_AUTHORS_LIST = 'author-list';
    case PRODUCT_AUTHORS_ADD = 'author-add';
    case PRODUCT_AUTHORS_EDIT = 'author-edit';
    case PRODUCT_AUTHORS_DELETE = 'author-delete';
    case PRODUCT_AUTHORS_LIST_STORE = 'author-list-store';
    case PRODUCT_AUTHORS_REQUESTED_FROM_STORE = 'author-req-from-store';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Fabric Combination(For Furniture Only)                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_FAB_COMB_LIST = 'fabcomb-list';
    case PRODUCT_FAB_COMB_ADD = 'fabcomb-add';
    case PRODUCT_FAB_COMB_EDIT = 'fabcomb-edit';
    case PRODUCT_FAB_COMB_DELETE = 'fabcomb-delete';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product Adons (For Food Only)                                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_ADONS_LIST = 'adons-list';
    case PRODUCT_ADONS_ADD = 'adons-add';
    case PRODUCT_ADONS_EDIT = 'adons-edit';
    case PRODUCT_ADONS_DELETE = 'adons-delete';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_PRODUCT_LIST = 'product-list';
    case PRODUCT_PRODUCT_ADD = 'product-add';
    case PRODUCT_PRODUCT_EDIT = 'product-edit';
    case PRODUCT_PRODUCT_DELETE = 'product-delete';
    case PRODUCT_PRODUCT_LOW_STOCK = 'product-low-stock';
    case PRODUCT_PRODUCT_TEMPLATE = 'product-template';
    case PRODUCT_PRODUCT_BULK_IMPORT = 'product-import';
    case PRODUCT_PRODUCT_BULK_EXPORT = 'product-export';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Order Permissions                                       //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ORDERS_ALL = 'order-all';
    case ORDERS_PENDING = 'order-pending';
    case ORDERS_CONFIRMED = 'order-confirmed';
    case ORDERS_SCHEDULED = 'order-scheduled';
    case ORDERS_COOKING = 'order-cooking';
    case ORDERS_READY_FOR_DELIVERY = 'order-ready';
    case ORDERS_PRODUCT_ON_THE_WAY = 'order-onthe-way';
    case ORDERS_DELIVERED = 'order-delivered';
    case ORDERS_FITTING_SCHEDULE = 'order-fitting-schedule';
    case ORDERS_RETURNED_OR_REFUND = 'order-refund';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Flash Sales                                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case FLASH_SALES_ALL_CAMPAIGNS = 'flash-ales-list';
    case FLASH_SALES_JOIN = 'flash-ales-join'; // A list of Flash sales to show in Store where and option for store to join that program
    case FLASH_SALES_ADD_CAMPAIGN_ADMIN = 'flash-ales-add-admin';
    case FLASH_SALES_ADD_CAMPAIGN_STORE = 'flash-ales-add-store';
    case FLASH_SALES_APPROVE_CAMPAIGN = 'flash-ales-approve';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Financial Management                                    //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case FINANCIAL_TRANSACTIONS = 'my-transactions';
    case FINANCIAL_WITHDRAWLS = 'my-withdrawals';
    case FINANCIAL_MYINCOME = 'my-income';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Feedback Management                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case FEEDBACK_REVIEWS = 'reviews';
    case FEEDBACK_QUESTIONS = 'questions-Chat';
    case FEEDBACK_QUERIES = 'product-queries';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Promotion Management                                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PROMOTION_DEALS_AVAILABLE = 'deals-available';
    case PROMOTION_MY_PRODUCT_IN_DEALS = 'myproduct-in-deals';
    case PROMOTION_ASK_FOR_ENROLL = 'product-deal-enrollment';
    case PROMOTION_COUPONS = 'coupon-list';
    case PROMOTION_BANNERS = 'banner-list';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  User Permissions                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case USERS_BAN = 'user-ban';
    case USERS_ACTIVE = 'active-ban';
    case USERS_ROLES_STORE = 'store-staff-role';
    case USERS_STAFF_ADD_STORE = 'store-staff-add';
    case USERS_STAFF_LIST_STORE = 'store-staff-list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Others Permissions                                      //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case MANAGE_CONFIGURATIONS = 'manage-configurations';

}
