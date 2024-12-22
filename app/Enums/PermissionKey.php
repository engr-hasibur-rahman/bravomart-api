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
    //                                  POS Management                                          //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case POS_SALES = 'pos-sales';
    case POS_SETTINGS_ADMIN = 'pos-settings-admin';
    case POS_SETTINGS_STORE = 'pos-settings-store';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Area Management                                         //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_AREA_LIST = '/admin/area';
    case ADMIN_AREA_ADD = '/admin/area/add-area';


    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Store Management                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADMIN_STORE_LIST = '/admin/store';
    case ADMIN_STORE_ADD = '/admin/store/add-store';
    case STORE_STORE_ADD_UPDATE = 'store-add-update'; // Add if user have no store added. Update if existis
    case STORE_RECOMMENDED = 'store-recommended';
    case STORE_APPROVAL = 'store-approval';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //               Product Brand/Manufacturers/Publications (For Book Only)                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_BRAND_LIST = '/admin/brand';
    case PRODUCT_BRAND_ADD = '/admin/brand/add-brand';
    case PRODUCT_BRAND_LIST_STORE = '/store/brand';
    case PRODUCT_BRAND_REQUESTED_FROM_STORE = 'brand-req-from-store';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product category Permissions                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_CATEGORY_LIST = '/admin/categories';
    case PRODUCT_CATEGORY_ADD = '/admin/categories/add-category';
    case PRODUCT_CATEGORY_LIST_STORE = '/store/categories';

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
    //                          Product addons (For Food Only)                                   //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_TAG_LIST = 'tag-list';
    case PRODUCT_TAG_ADD = 'tag-add';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_PRODUCT_LIST = '/admin/products';
    case PRODUCT_PRODUCT_ADD = '/admin/products/add-product';
    case PRODUCT_PRODUCT_LOW_STOCK = 'product-low-stock';
    case PRODUCT_PRODUCT_TEMPLATE = 'product-template';
    case PRODUCT_PRODUCT_BULK_IMPORT = 'product-import';
    case PRODUCT_PRODUCT_BULK_EXPORT = 'product-export';
    case PRODUCT_PRODUCT_APPROVAL_REQ = 'product-approval-request';
    case PRODUCT_INVENTORY = 'product-inventory';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Order Permissions                                       //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ORDERS_ALL = 'all-orders';
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
    case FIREBASE_NOTIFICATION = 'firebase-notification';
    case LOGIN_SETUP = 'login-setup';
    case REACT_SITE = 'react-site';
    case EMAIL_TEMPLATE = 'email-template';
    case APP_SETTINGS = 'app-settings';
    case NOTIFICATION_CHANNELS = 'notification-channels';

    case UNSIGNED_ORDERS_GROCERY = 'unsigned-orders-grocery';
    case ONGOING_ORDERS_GROCERY = 'ongoing-orders-grocery';
    case GENERAL_SETTINGS = '/admin/system-management/general-settings';
    case APPEARANCE_SETTINGS = 'appearance_settings';
    case FOOTER_CUSTOMIZATION = '/admin/system-management/footer-customization';
    case MAINTENANCE_SETTINGS = '/admin/system-management/maintenance-settings';
    case SMTP_SETTINGS = '/admin/system-management/email-settings/smtp';
    case EMAIL_TEMPLATES = '/admin/system-management/email-settings/templates';
    case PAYMENT_SETTINGS = '/admin/system-management/payment-settings';
    case SEO_SETTINGS = '/admin/system-management/seo-settings';
    case CACHE_MANAGEMENT = '/admin/system-management/cache-management';
    case DATABASE_UPDATE_CONTROLS  = '/admin/system-management/database-update-controls';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //              Third-Party Integrations                                                        //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case GOOGLE_MAP_SETTINGS = '/admin/system-management/google-map-settings';
    case FIREBASE_SETTINGS = '/admin/system-management/firebase-settings';
    case SOCIAL_LOGIN_SETTINGS = '/admin/system-management/social-login-settings';



    // ############################## Seller PermissionKey Start ################################
       //-----------Store Settings----------
        case STORE_MY_SHOP = '/seller/store/list';
        case STORE_STORE_NOTICE = 'store-notice';
        case STORE_STORE_MESSAGE = 'store-message';
        case STORE_STORE_CONFIG = 'store-config';
        case STORE_BUSINESS_PLAN = 'my-business-plan';
        case STORE_WALLET = 'my-wallet';
        case STORE_DISBURSE_METHOD = 'my-disburse-method';
        case STORE_POS_CONFIG = 'pos-config';


     //-----------Seller Staff Manage----------
      case SELLER_STAFF_LIST = '/seller/staff/list';
      case SELLER_STAFF_BAN= '/seller/staff/ban';
      case SELLER_STAFF_ACTIVE= '/seller/staff/active';
      case SELLER_STAFF_ROLES_STORE = '/seller/staff/role-stores';

    // ######################## Seller PermissionKey End ###########################

}
