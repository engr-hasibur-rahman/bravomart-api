<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum MenuGroup: string
{
    use InvokableCases;
    use Values;

    case GENERAL = 'general';
    case PRODUCT_BRAND = 'product_brand';
    case PRODUCT_CATEGORY = 'product_category';
    case PRODUCT = 'product';
    case PRODUCT_ATTRIBUTE = 'product_attribute';
    case PRODUCT_WARRANTY = 'product_warrenty';
    case PRODUCT_ADDONS = 'product_addons';
    case PRODUCT_FAB_COMB = 'fabric_combination';
    case BOOK_AUTHORS = 'authors';
    case USERS = 'users';
    case STORES = 'stores_management';
    case STORE_SETTINGS = 'stores_settings';
    case CENTRAL = 'central_settings';
    case OTHERS = 'others';
    case ORDER_MANAGEMENT = 'order_management';
    case FINANCIAL_MANAGEMENT = 'financial_management';
    case FEEDBACK_MANAGEMENT = 'feedback_management';
    case PROMOTION_MANAGEMENT = 'promotion_management';
    case DELIVERYMAN_MANAGEMENT = 'deliveryman_management';
    case CUSTOMER_MANAGEMENT = 'customer_management';
    case EMPLOYEE_MANAGEMENT = 'employee_management';
    case FINANCIAL_ACTIVITY = 'financial_activity';
    case REPORTS_ANALYTICS = 'reports_analytics';
    case BUSINESS_MANAGEMENT = 'business_management';
    case SYSTEM_MANAGEMENT = 'system_management';
    case DISPATCH_MANAGEMENT = 'dispatch_management';


    /**
     * moduleTitle
     *
     * @param  mixed $name
     * @return string
     */
    public static function moduleTitle(string $name): string
    {
        return match ($name) {
            MenuGroup::GENERAL->value => "General",
            MenuGroup::PRODUCT_BRAND->value => "Product Brand",
            MenuGroup::PRODUCT_CATEGORY->value => "Product Category",
            MenuGroup::USERS->value => "Staff/User Management",
            MenuGroup::STORES->value => "Store Management",
            MenuGroup::CENTRAL->value => "Central Settings",
            MenuGroup::PRODUCT->value => "Product",
            MenuGroup::ORDER_MANAGEMENT->value => "Order management",
            MenuGroup::FINANCIAL_MANAGEMENT->value => "Financial management",
            MenuGroup::FEEDBACK_MANAGEMENT->value => "Feedback Management",
            MenuGroup::PROMOTION_MANAGEMENT->value => "Promotion Management",
            MenuGroup::BOOK_AUTHORS->value => "Book Authors",
            MenuGroup::PRODUCT_ADDONS->value => "addons (For Food Only)",
            MenuGroup::PRODUCT_FAB_COMB->value => "Fabric Combination(For Furniture Only)",
            MenuGroup::STORE_SETTINGS->value => "Store Settings",
            MenuGroup::PRODUCT_ATTRIBUTE->value => "Product Attribute",
            MenuGroup::PRODUCT_WARRANTY->value => "Product Warranty",
            MenuGroup::DELIVERYMAN_MANAGEMENT->value => "Deliveryman management",
            MenuGroup::CUSTOMER_MANAGEMENT->value => "Customer management",
            MenuGroup::EMPLOYEE_MANAGEMENT->value => "Employee Management",
            MenuGroup::FINANCIAL_ACTIVITY->value => "Financial Activity",
            MenuGroup::REPORTS_ANALYTICS->value => "Report and analytics",
            MenuGroup::BUSINESS_MANAGEMENT->value => "Business management",
            MenuGroup::SYSTEM_MANAGEMENT->value => "System management",
            MenuGroup::DISPATCH_MANAGEMENT->value => "Dispatch management",
            MenuGroup::OTHERS->value => "Others",
            default => "",
        };
    }
}
