<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum PermissionKey: string
{
    use InvokableCases;
    use Values;


    case ALL = 'all';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Admin Dashboard Management                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_DASHBOARD = '/admin/dashboard';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  POS Management                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_POS_SALES = '/admin/pos';
    case ADMIN_POS_SETTINGS = '/admin/pos/settings';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                 Admin Order Permissions                                       //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_ORDERS_ALL = '/admin/orders';
    case ADMIN_ORDERS_RETURNED_OR_REFUND = '/admin/orders/refund';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Admin Product Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCTS_MANAGE = '/admin/product/list';
    case ADMIN_PRODUCT_PRODUCT_APPROVAL_REQ = '/admin/product/approval-request';
    case ADMIN_PRODUCT_STOCK_REPORT = '/admin/product/stock-report';
    case ADMIN_PRODUCT_PRODUCT_BULK_IMPORT = '/admin/product/import';
    case ADMIN_PRODUCT_PRODUCT_BULK_EXPORT = '/admin/product/export';
    case ADMIN_PRODUCT_TEMPLATE = '/admin/product/template';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Admin Product Inventory Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_INVENTORY = '/admin/product/inventory';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                 admin  store manage Permissions                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_STORE_LIST = '/admin/store/list';
    case ADMIN_STORE_ADD = '/admin/store/add';
    case ADMIN_STORE_RECOMMENDED = '/admin/store/recommended';
    case ADMIN_STORE_APPROVAL = '/admin/store/approval';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Area Management                                         //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_AREA_LIST = '/admin/area';
    case ADMIN_AREA_ADD = '/admin/area/add-area';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Brand/Manufacturers/Publications (For Book Only)                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_BRAND_LIST = '/admin/product-brands/list';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product category Permissions                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_CATEGORY_LIST = '/admin/categories';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Attribute                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_ATTRIBUTE_LIST = '/admin/attributes';
    case PRODUCT_ATTRIBUTE_ADD = '/admin/attributes/add-attribute';
    case PRODUCT_ATTRIBUTE_LIST_STORE = '/store/attributes';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Warranty                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_WARRANTY_LIST = 'product-warranty';
    case PRODUCT_WARRANTY_ADD = 'product-warranty-add';
    case PRODUCT_WARRANTY_LIST_STORE = 'product-warranty-list';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product Authors (For Book Only)                                 //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_AUTHORS_LIST = 'author-list';
    case PRODUCT_AUTHORS_ADD = 'author-add';
    case PRODUCT_AUTHORS_LIST_STORE = 'author-list-store';
    case PRODUCT_AUTHORS_REQUESTED_FROM_STORE = 'author-req-from-store';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Fabric Combination(For Furniture Only)                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_FAB_COMB_LIST = 'fabcomb-list';
    case PRODUCT_FAB_COMB_ADD = 'fabcomb-add';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product addons (For Food Only)                                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_ADDONS_LIST = 'addons-list';
    case PRODUCT_ADDONS_ADD = 'addons-add';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product Tags                              //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_TAG_LIST = '/admin/tag/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Flash Sales                                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case FLASH_SALES_ALL_CAMPAIGNS = 'flash-sales-list';
    case FLASH_SALES_JOIN = 'flash-sales-join'; // A list of Flash sales to show in Store where and option for store to join that program
    case FLASH_SALES_ADD_CAMPAIGN_ADMIN = 'flash-sales-add-admin';
    case FLASH_SALES_ADD_CAMPAIGN_STORE = 'flash-sales-add-store';
    case FLASH_SALES_APPROVE_CAMPAIGN = 'flash-sales-approve';

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
    case USERS_ROLE_ADD = '/admin/roles/add-role';
    case USERS_ROLE_LIST = '/admin/roles';
    case USERS_LIST_ADMIN = '/admin/users';
    case USERS_ADD_ADMIN = '/admin/users/add-user';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Others Permissions                                      //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case MANAGE_CONFIGURATIONS = 'manage-configurations';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //           User Related Functionality/Deliveryman management                              //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case DELIVERY_VEHICLE_CATEGORY = 'vehicle-category';
    case DELIVERY_PERSON_ADD = 'delivery-person-add';
    case DELIVERY_PERSON_LIST = 'delivery-person-list';
    case DELIVERY_PERSONS_REVIEW = 'delivery-person-review';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Customer management                                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case CUSTOMER_LIST = 'customer-list';
    case CUSTOMER_WALLET_ADD_FUND = 'customer-wallet-add-fund';
    case CUSTOMER_WALLET_REPORT = 'customer-wallet-report';
    case CUSTOMER_WALLET_BONUS = 'customer-wallet-bonus';
    case CUSTOMER_LOYALTY_POINT = 'customer-loyalty-point';
    case CUSTOMER_SUBSCRIBED_MAIL_LIST = 'customer-subscribe-email-list';
    case CUSTOMER_CONTACT_MESSAGES = 'customer-contact-messages';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //       Transacton & Reports Related Functionality                                         //
    //              Financial Activity                                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case FINANCIAL_WITHDRAW_REQUESTS = 'withdraw-requests';
    case FINANCIAL_STORE_DISBURSEMENT = 'store-disbursement';
    case FINANCIAL_DELIVERY_MAN_DISBURSEMENT = 'delivery-man-disbursement';
    case FINANCIAL_COLLECT_CASH = 'collect-cash';
    case FINANCIAL_DELIVERY_MAN_PAYMENTS = 'delivery-man-payments';
    case FINANCIAL_WITHDRAW_METHOD = 'withdraw-method';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Report and analytics                                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case TRANSACTION_REPORT = 'transaction-report';
    case ITEM_REPORT = 'item-report';
    case STORE_WISE_REPORT = 'store-wise-report';
    case EXPENSE_REPORT = 'expense-report';
    case DISBURSEMENT_REPORT = 'disbursement-report';
    case ORDER_REPORT = 'order-report';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //       Ssettings Related Functionality                                        //
    //              Business management                                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case BUSINESS_SETTINGS = 'business-settings';
    case SUBSCRIPTION_PACKAGE = 'subscription-package';
    case SUBSCRIBER_LIST = 'subscriber-list';
    case SUBSCRIPTION_SETTINGS = 'subscription-settings';
    case MEDIA_SOCIAL_MEDIA = 'media-social-media';
    case MEDIA_ADMIN_LANDING_PAGE = 'media-admin-landing-page';
    case MEDIA_REACT_LANDING_PAGE = 'media-react-landing-page';
    case MEDIA_FLUTTER_LANDING_PAGE = 'media-flutter-landing-page';
    case PAGE_TERMS_AND_CONDITION = 'page-terms-and-condition';
    case PAGE_PRIVACY_POLICY = 'page-privacy-policy';
    case PAGE_ABOUT_US = 'page-about-us';
    case PAGE_REFUND_POLICY = 'page-refund-policy';
    case PAGE_CANCELLATION_POLICY = 'page-cancel-policy';
    case PAGE_SHIPPING_POLICY = 'page-shipping-policy';
    case IMAGE_GALLERY = 'image-gallery';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              System management                                                           //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case LOGIN_SETUP = 'login-setup';
    case REACT_SITE = 'react-site';
    case APP_SETTINGS = 'app-settings';
    case NOTIFICATION_CHANNELS = 'notification-channels';
    case UNSIGNED_ORDERS_GROCERY = 'unsigned-orders-grocery';
    case ONGOING_ORDERS_GROCERY = 'ongoing-orders-grocery';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              System-management Settings                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_SYSTEM_MANAGEMENT_SETTINGS = '/admin/system-management/settings';
    case GENERAL_SETTINGS = '/admin/system-management/general-settings';
    case APPEARANCE_SETTINGS = 'appearance_settings';
    case FOOTER_CUSTOMIZATION = '/admin/system-management/footer-customization';
    case MAINTENANCE_SETTINGS = '/admin/system-management/maintenance-settings';
    case SMTP_SETTINGS = '/admin/system-management/email-settings/smtp';
    case EMAIL_TEMPLATES = '/admin/system-management/email-settings/templates';

    case SEO_SETTINGS = '/admin/system-management/seo-settings';
    case CACHE_MANAGEMENT = '/admin/system-management/cache-management';
    case DATABASE_UPDATE_CONTROLS  = '/admin/system-management/database-update-controls';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Third-Party Integrations                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case GOOGLE_MAP_SETTINGS = '/admin/system-management/google-map-settings';
    case FIREBASE_SETTINGS = '/admin/system-management/firebase-settings';
    case SOCIAL_LOGIN_SETTINGS = '/admin/system-management/social-login-settings';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Blog Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_BLOG_CATEGORY = '/admin/blog/category';
    case ADMIN_BLOG_POSTS = '/admin/blog/posts';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Support Tickets Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_TICKETS_DEPARTMENT = '/admin/ticket/department';
    case ADMIN_ALL_TICKETS = '/admin/ticket/all-tickets';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Dynamic Pages Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PAGES_LIST = '/admin/pages/list';
    // ############################## Admin PermissionKey End ################################

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Payment Settings Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
     case ADMIN_PAYMENT_SETTINGS = '/admin/payment-gateways/settings';
     //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Coupon Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
     case ADMIN_COUPON_MANAGE = '/admin/coupon/list';
     case ADMIN_COUPON_LINE_MANAGE = '/admin/coupon-line/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Wallet Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_WALLET_MANAGE = '/admin/wallet/list';
     //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Notice Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_NOTICE_MANAGEMENT = '/admin/store-notices';
      //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              withdraw method Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_WITHDRAW_METHOD_MANAGEMENT = '/admin/withdraw-method';

    // ############################## Admin PermissionKey End ################################


    // ############################## Seller PermissionKey Start ################################
       //-----------Store Settings----------
        case SELLER_STORE_MY_SHOP = '/seller/store/list';
        case SELLER_STORE_STORE_NOTICE = '/seller/store/settings/notices';
        case SELLER_STORE_STORE_CONFIG = '/seller/store/settings/config';
        case SELLER_STORE_BUSINESS_PLAN = '/seller/store/settings/business-plan';
        case SELLER_STORE_POS_CONFIG = '/seller/store/pos-config';
        case SELLER_STORE_POS_SALES = '/seller/store/pos';
       //------------ SELLER Live Chat
        case STORE_STORE_MESSAGE = 'store-message';

        // ----------- Seller Product Manage
        case SELLER_STORE_PRODUCT_LIST = '/seller/store/product/list';
        case SELLER_STORE_PRODUCT_ADD = '/seller/store/product/add';
        case SELLER_STORE_PRODUCT_STOCK_REPORT = '/seller/store/product/stock-report';
        case SELLER_STORE_PRODUCT_BULK_EXPORT = '/seller/store/product/export';
        case SELLER_STORE_PRODUCT_BULK_IMPORT = '/seller/store/product/import';
        // ----------- Seller Product Inventory
        case SELLER_STORE_PRODUCT_INVENTORY = '/seller/store/product/inventory';

     //-----------Seller Staff Manage----------
      case SELLER_STAFF_LIST = '/seller/staff/list';
      case SELLER_STAFF_BAN= '/seller/staff/ban';
      case SELLER_STAFF_ACTIVE= '/seller/staff/active';
      case SELLER_STAFF_ROLES_STORE = '/seller/staff/role-stores';

        //-----------Financial Management----------
        case SELLER_STORE_FINANCIAL_WALLET = '/seller/store/financial/wallet';
        case SELLER_STORE_FINANCIAL_WITHDRAWALS= '/seller/store/financial/withdraw';

        //----------- Promotional control ----------
        case SELLER_STORE_FLASH_SALE_ACTIVE_DEALS = '/seller/store/flash/active-deals';
        case SELLER_STORE_FLASH_SALE_MY_DEALS = '/seller/store/flash/my-deals';
        case SELLER_STORE_FLASH_SALE_JOIN_DEALS = '/seller/store/flash/join-deals';
        case SELLER_STORE_FLASH_BANNER_MANAGE = '/seller/store/banner-manage';

        //=============== Seller Order Manger ====================
     case SELLER_STORE_ORDER_MANAGE = '/seller/store/orders';
     case SELLER_ORDERS_RETURNED_OR_REFUND = '/orders/returned';
     case SELLER_ORDERS_REVIEWS_MANAGE = '/orders/reviews';

        //-------------- Brand add -----------------
        case ADMIN_PRODUCT_BRAND_LIST_STORE = '/store/brand';

    // ######################## Seller PermissionKey End ###########################

}
