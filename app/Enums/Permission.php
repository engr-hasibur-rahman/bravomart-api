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
    //                                  Central Settings     Admin                              //
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
    //                                  Product Brand Permissions                               //
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
    case PRODUCT_BRAND_LIST = 'product-brand-list';
    case ADD_PRODUCT_BRAND = 'product-brand-add';
    case EDIT_PRODUCT_BRAND = 'product-brand-edit';
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
    case PRODUCT_ATTRIBUTE = 'product-attribute';
    case MANAGE_CONFIGURATIONS = 'manage-configurations';
}
