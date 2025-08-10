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
    case ADMIN_ORDERS_RETURNED_OR_REFUND_REQUEST = '/admin/orders/refund-request';
    case ADMIN_ORDERS_RETURNED_OR_REFUND_REASON = '/admin/orders/refund-reason/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Admin Product Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCTS_MANAGE = '/admin/product/list';
    case ADMIN_PRODUCTS_TRASH_MANAGEMENT = '/admin/product/trash-list';
    case ADMIN_PRODUCT_PRODUCT_APPROVAL_REQ = '/admin/product/request';
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
    case ADMIN_STORE_TRASH_MANAGEMENT = '/admin/store/trash-list';
    case ADMIN_STORE_RECOMMENDED = '/admin/store/recommended';
    case ADMIN_STORE_APPROVAL = '/admin/store/approval';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                  Promotional Banner Management
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PROMOTIONAL_FLASH_SALE_MANAGE = '/admin/promotional/flash-deals/list';
    case ADMIN_PROMOTIONAL_FLASH_SALE_JOIN_DEALS = '/admin/promotional/flash-deals/join-request';
    case ADMIN_PROMOTIONAL_BANNER_MANAGE = '/admin/promotional/banner/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Area Management                                         //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_AREA_LIST = '/admin/area';
    case ADMIN_AREA_ADD = '/admin/area/add-area';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Brand/Manufacturers/Publications (For Book Only)                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_SLIDER_MANAGE_LIST = '/admin/slider/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               media manage                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_MEDIA_MANAGE = '/admin/media-manage';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Brand/Manufacturers/Publications (For Book Only)                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_BRAND_LIST = '/admin/brand/list';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product category Permissions                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_CATEGORY_LIST = '/admin/categories';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Attribute                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_ATTRIBUTE_ADD = '/admin/attribute';
    case PRODUCT_ATTRIBUTE_LIST = '/admin/attribute/list';
    case PRODUCT_ATTRIBUTE_LIST_STORE = '/store/attributes';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Product Authors (For Book Only)                                 //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_AUTHORS_MANAGE = '/admin/product/author/list';

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
    //                          Product Unit                              //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_PRODUCT_UNIT_LIST = '/admin/unit/list';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Feedback Management                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_FEEDBACK_REVIEWS = '/admin/feedback-control/review';
    case ADMIN_FEEDBACK_QUESTIONS = '/admin/feedback-control/questions';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  User Permissions                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case USERS_ROLE_ADD = '/admin/roles/add';
    case USERS_ROLE_LIST = '/admin/roles/list';
    case USERS_LIST_ADMIN = '/admin/users';
    case USERS_ADD_ADMIN = '/admin/users/add-user';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //           Deliveryman management
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_DELIVERYMAN_VEHICLE_TYPE = '/admin/deliveryman/vehicle-types/list';
    case ADMIN_DELIVERYMAN_MANAGE_LIST = '/admin/deliveryman/list';
    case ADMIN_DELIVERYMAN_TRASH_MANAGEMENT = '/admin/deliveryman/trash-list';
    case ADMIN_DELIVERYMAN_REQUEST = '/admin/deliveryman/request';
    case ADMIN_DELIVERYMAN_MANAGE_REVIEW = '/admin/deliveryman/review';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Customer management                                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_CUSTOMER_MANAGEMENT_LIST = '/admin/customer/list';
    case ADMIN_CUSTOMER_TRASH_MANAGEMENT = '/admin/customer/trash-list';
    case ADMIN_CUSTOMER_SUBSCRIBED_MAIL_LIST = '/admin/customer/subscriber-list';
    case ADMIN_CUSTOMER_CONTACT_MESSAGES = '/admin/customer/contact-messages';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Seller management                                             //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_SELLER_MANAGEMENT = '/admin/seller/list';
    case ADMIN_SELLER_TRASH_MANAGEMENT = '/admin/seller/trash-list';
    case ADMIN_SELLER_REGISTRATION = '/admin/seller/registration';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Financial Activity                                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_FINANCIAL_WITHDRAW_MANAGE_HISTORY = '/admin/financial/withdraw/history';
    case ADMIN_FINANCIAL_WITHDRAW_MANAGE_SETTINGS = '/admin/financial/withdraw/settings';
    case ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST = '/admin/financial/withdraw/request';
    case ADMIN_WITHDRAW_METHOD_MANAGEMENT = '/admin/financial/withdraw/method/list';
    case ADMIN_FINANCIAL_COLLECT_CASH = '/admin/financial/cash-collect';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                          Report and analytics                                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_REPORT_ANALYTICS_ORDER = '/admin/report-analytics/order';
    case ADMIN_REPORT_ANALYTICS_TRANSACTION = '/admin/report-analytics/transaction';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //             Business Operations  Functionality                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_STORE_TYPE_MANAGE = '/admin/business-operations/store-type';
    case ADMIN_GEO_AREA_MANAGE = '/admin/business-operations/area/list';
    case ADMIN_SUBSCRIPTION_PACKAGE_MANAGE = '/admin/business-operations/subscription/package/list';
    case ADMIN_SUBSCRIPTION_STORE_PACKAGE_MANAGE = '/admin/business-operations/subscription/store/list';
    case ADMIN_COMMISSION_SETTINGS = '/admin/business-operations/commission/settings';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              System management                                                           //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case APP_SETTINGS = 'app-settings';
    case NOTIFICATION_CHANNELS = 'notification-channels';
    case UNSIGNED_ORDERS_GROCERY = 'unsigned-orders-grocery';
    case ONGOING_ORDERS_GROCERY = 'ongoing-orders-grocery';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              System-management Settings                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case GENERAL_SETTINGS = '/admin/system-management/general-settings';

    case PAGE_SETTINGS = '/admin/system-management/page-settings';
    case REGISTER_PAGE_SETTINGS = '/admin/system-management/page-settings/register';
    case HOME_PAGE_SETTINGS = '/admin/system-management/page-settings/home';
    case LOGIN_PAGE_SETTINGS = '/admin/system-management/page-settings/login';
    case PRODUCT_DETAILS_PAGE_SETTINGS = '/admin/system-management/page-settings/product-details';
    case BLOG_PAGE_SETTINGS = '/admin/system-management/page-settings/blog-details';
    case ABOUT_PAGE_SETTINGS = '/admin/system-management/page-settings/about';
    case CONTACT_PAGE_SETTINGS = '/admin/system-management/page-settings/contact';
    case BECOME_SELLER_PAGE_SETTINGS = '/admin/system-management/page-settings/become-seller';

    case APPEARANCE_SETTINGS = 'appearance_settings';
    case MENU_CUSTOMIZATION = '/admin/system-management/menu-customization';
    case FOOTER_CUSTOMIZATION = '/admin/system-management/footer-customization';
    case MAINTENANCE_SETTINGS = '/admin/system-management/maintenance-settings';
    case SMTP_SETTINGS = '/admin/system-management/email-settings/smtp';
    case EMAIL_TEMPLATES = '/admin/system-management/email-settings/email-template/list';
    case SEO_SETTINGS = '/admin/system-management/seo-settings';
    case SITEMAP_SETTINGS = '/admin/system-management/sitemap-settings';

    case GDPR_COOKIE_SETTINGS = '/admin/system-management/gdpr-cookie-settings';
    case CACHE_MANAGEMENT = '/admin/system-management/cache-management';
    case LICENSE_SYSTEM = '/admin/system-management/license-system';
    case DATABASE_UPDATE_CONTROLS = '/admin/system-management/database-update-controls';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Third-Party Integrations                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case GOOGLE_MAP_SETTINGS = '/admin/system-management/google-map-settings';
    case FIREBASE_SETTINGS = '/admin/system-management/firebase-settings';
    case SOCIAL_LOGIN_SETTINGS = '/admin/system-management/social-login-settings';
    case RECAPTCHA_SETTINGS = '/admin/system-management/recaptcha-settings';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Blog Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_STAFF_LIST = '/admin/staff/list';
    case ADMIN_STAFF_MANAGE = '/admin/staff/add';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Blog Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_BLOG_CATEGORY_MANAGE = '/admin/blog/category';
    case ADMIN_BLOG_MANAGE = '/admin/blog/posts';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Chat Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_CHAT_SETTINGS = '/admin/chat/settings';
    case ADMIN_CHAT_MANAGE = '/admin/chat/manage';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Sms gateway                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_SMS_GATEWAY_SETTINGS = '/admin/sms-provider/settings';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Support Tickets Management                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_TICKETS_DEPARTMENT = '/admin/ticket/department';
    case ADMIN_SUPPORT_TICKETS_MANAGE = '/admin/support-ticket/list';
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
    case ADMIN_WALLET_TRASH_MANAGEMENT = '/admin/wallet/trash-list';
    case ADMIN_WALLET_TRANSACTION = '/admin/wallet/transactions';
    case ADMIN_WALLET_SETTINGS = '/admin/wallet/settings';
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //  admin notifications
    case ADMIN_NOTIFICATION_MANAGEMENT = '/admin/notifications';
    //  Notice Management
    case ADMIN_NOTICE_MANAGEMENT = '/admin/store-notices';

    // ############################## Admin PermissionKey End ################################

    // ############################## Seller PermissionKey Start ################################
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Admin Dashboard Management                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case SELLER_STORE_DASHBOARD = 'seller/dashboard';
    //-----------Store Settings----------
    case SELLER_STORE_MY_SHOP = '/seller/store/list';
    case SELLER_STORE_BUSINESS_PLAN = '/seller/store/settings/business-plan';
    case SELLER_STORE_STORE_NOTICE = '/seller/store/settings/notices';
    case SELLER_STORE_STORE_CONFIG = '/seller/store/settings/config';
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
    // ----------- Seller Product Attribute
    case SELLER_PRODUCT_ATTRIBUTE_ADD = '/seller/store/attribute/list';

    //-----------Seller Staff Manage----------
    case SELLER_STORE_STAFF_MANAGE = '/seller/store/staff/list';
    case SELLER_STAFF_BAN = '/seller/staff/ban';
    case SELLER_STAFF_ACTIVE = '/seller/staff/active';
    case SELLER_STAFF_ROLES_STORE = '/seller/staff/role-stores';

    //-----------Financial Management----------
    case SELLER_STORE_FINANCIAL_WALLET = '/seller/store/financial/wallet';
    case SELLER_STORE_FINANCIAL_WITHDRAWALS = '/seller/store/financial/withdraw';

    //-----------Feedback Management----------
    case SELLER_STORE_FEEDBACK_CONTROL_REVIEWS = '/seller/store/feedback-control/review';
    case SELLER_STORE_FEEDBACK_CONTROL_QUESTIONS = '/seller/store/feedback-control/questions';

    //----------- Promotional control ----------
    case SELLER_STORE_PROMOTIONAL_FLASH_SALE_ACTIVE_DEALS = '/seller/store/promotional/flash-deals/active-deals';
    case SELLER_STORE_PROMOTIONAL_FLASH_SALE_MY_DEALS = '/seller/store/promotional/flash-deals/my-deals';
    case SELLER_STORE_PROMOTIONAL_FLASH_SALE_JOIN_DEALS = '/seller/store/promotional/flash-deals/join-deals';
    case SELLER_STORE_PROMOTIONAL_BANNER_MANAGE = '/seller/store/promotional/banner';

    //=============== Seller Order Manger ====================
    case SELLER_STORE_ORDER_MANAGE = '/seller/store/orders';
    case SELLER_ORDERS_RETURNED_OR_REFUND_REQUEST = '/seller/store/orders/refund-request';
    case SELLER_ORDERS_REVIEWS_MANAGE = '/seller/orders/reviews';
    //====================== Product Authors (For Book Only)
    // notifications manage
    case SELLER_NOTIFICATION_MANAGEMENT = '/seller/store/notifications';
    case SELLER_STORE_PRODUCT_AUTHORS_MANAGE = '/seller/store/product/author/list';
    //~~~~~~~~~~~~~~~~~Wallet Manage~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //
    //~~~~~~~~~~~~~~~~~Chat ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    case SELLER_CHAT_MANAGE = '/seller/store/chat/list';
    //~~~~~~~~~~~~~~~~~Seller Support Ticket~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    case SELLER_STORE_SUPPORT_TICKETS_MANAGE = '/seller/store/support-ticket/list';
    // ######################## Seller PermissionKey End ###########################

    // deliveryman
    case DELIVERYMAN_FINANCIAL_WITHDRAWALS = '/deliveryman/withdraw-manage';

}
