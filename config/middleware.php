<?php

use App\Enums\Permission;

return [

    'brand-list' => [
        Permission::PRODUCT_BRAND_LIST->value,
    ],
    'add-product-brand' => [
        Permission::ADD_PRODUCT_BRAND->value,
    ],
    'edit-product-brand' => [
        Permission::EDIT_PRODUCT_BRAND->value,
    ],
    'product-brand-status' => [
        Permission::PRODUCT_BRAND_STATUS->value,
    ],

    'category-list' => [
        Permission::PRODUCT_CATEGORY_LIST->value,
    ],
    'category-store' => [
        Permission::ADD_PRODUCT_CATEGORY->value,
    ],
    'category-show' => [
        Permission::EDIT_PRODUCT_CATEGORY->value,
    ],
    'category-status' => [
        Permission::PRODUCT_CATEGORY_STATUS->value,
    ],
    'ban-user' => [
        Permission::BAN_USER->value,
    ],
    'active-user' => [
        Permission::ACTIVE_USER->value,
    ],
];