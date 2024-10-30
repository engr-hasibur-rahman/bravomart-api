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
    case USERS = 'users';
    case STORES = 'stores_management';
    case CENTRAL = 'central_settings';
    case OTHERS = 'others';
    case ORDER_MANAGEMENT = 'order_management';
    case PRODUCT_MANAGEMENT = 'product_management';

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
            case MenuGroup::PRODUCT_MANAGEMENT->value:
                return "Product management";
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
