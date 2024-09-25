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
];