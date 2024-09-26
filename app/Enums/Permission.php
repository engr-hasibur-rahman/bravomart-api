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
    //                                  Product Brand Permissions                               //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_BRAND_LIST = 'product-brand-list';
    case ADD_PRODUCT_BRAND = 'add-product-brand';
    case EDIT_PRODUCT_BRAND = 'edit-product-brand';
    case PRODUCT_BRAND_STATUS = 'product-brand-status';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product category Permissions                            //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_CATEGORY_LIST = 'product-category-list';
    case ADD_PRODUCT_CATEGORY = 'add-product-category';
    case EDIT_PRODUCT_CATEGORY = 'edit-product-category';
    case PRODUCT_CATEGORY_STATUS = 'product-category-status';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Product Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case ADD_PRODUCT = 'add-product';
    case EDIT_PRODUCT = 'edit-product';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  User Permissions                                     //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case BAN_USER = 'user-ban';
    case ACTIVE_USER = 'active-ban';

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    //                                  Others Permissions                                      //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case MANAGE_CONFIGURATIONS = 'manage-configurations';
}
