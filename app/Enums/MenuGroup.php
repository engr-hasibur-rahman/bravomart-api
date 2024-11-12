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
    case PRODUCT_ADONS = 'product_adons';
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

    /**
     * moduleTitle
     *
     * @param  mixed $name
     * @return string
     */
    public static function moduleTitle(string $name): string
    {
        switch ($name) {
            case MenuGroup::GENERAL->value:
                return "General";
                break;
            case MenuGroup::PRODUCT_BRAND->value:
                return "Product Brand";
                break;
            case MenuGroup::PRODUCT_CATEGORY->value:
                return "Product Category";
                break;
            case MenuGroup::USERS->value:
                return "Staff/User Management";
                break;
            case MenuGroup::STORES->value:
                return "Store Management";
                break;
            case MenuGroup::CENTRAL->value:
                return "Central Settings";
                break;
            case MenuGroup::OTHERS->value:
                return "Others";
                break;
            case MenuGroup::PRODUCT->value:
                return "Product";
                break;
            case MenuGroup::ORDER_MANAGEMENT->value:
                return "Order management";
                break;
            case MenuGroup::FINANCIAL_MANAGEMENT->value:
                return "Financial management";
                break;
            case MenuGroup::FEEDBACK_MANAGEMENT->value:
                return "Feedback Management";
                break;
            case MenuGroup::PROMOTION_MANAGEMENT->value:
                return "Promotion Management";
                break;
            case MenuGroup::BOOK_AUTHORS->value:
                return "Book Authors";
                break;
            case MenuGroup::PRODUCT_ADONS->value:
                return "Adons (For Food Only)";
                break;
            case MenuGroup::PRODUCT_FAB_COMB->value:
                return "Fabric Combination(For Furniture Only)";
                break;
            case MenuGroup::STORE_SETTINGS->value:
                return "Store Settings";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            case MenuGroup::OTHERS->value:
                return "";
                break;
            default:
                return "";
                break;
        }
    }
}
