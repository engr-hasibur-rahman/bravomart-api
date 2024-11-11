<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\MenuGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission as ModelsPermission;
use function PHPUnit\Framework\throwException;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {

        $page_list = [

            [
                'module' => MenuGroup::GENERAL->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::GENERAL->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ALL->value,
                        'PermissionTitle' => 'All',
                        'activity_scope' => 'COMMON'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::CENTRAL->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::CENTRAL->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ADMIN_AREA_LIST->value,
                        'PermissionTitle' => 'Area List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_ADD->value,
                        'PermissionTitle' => 'Area Add',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_UPDATE->value,
                        'PermissionTitle' => 'Area Update',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::STORES->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::STORES->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ADMIN_STORE_LIST->value,
                        'PermissionTitle' => 'Store List',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_STORE_ADD->value,
                        'PermissionTitle' => 'Store Add',
                        'activity_scope' => 'system_level'
                    ]
                    ,
                    [
                        'PermissionName' => Permission::STORE_STORE_ADD_UPDATE->value,
                        'PermissionTitle' => 'Store Add/Update',
                        'activity_scope' => 'store_level'
                    ]                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_BRAND->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_BRAND->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_LIST->value,
                        'PermissionTitle' => 'Product Brand List',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_ADD->value,
                        'PermissionTitle' => 'Add Product Brand',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_EDIT->value,
                        'PermissionTitle' => 'Edit Product Brand',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_STATUS->value,
                        'PermissionTitle' => 'Change Brand Status',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_CATEGORY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_CATEGORY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_LIST->value,
                        'PermissionTitle' => 'Product Category List',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_ADD->value,
                        'PermissionTitle' => 'Add Product Category',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_EDIT->value,
                        'PermissionTitle' => 'Edit Product Category',
                        'activity_scope' => 'system_level'
                    ],                    
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_STATUS->value,
                        'PermissionTitle' => 'Change Category Status',
                        'activity_scope' => 'system_level'
                    ]

                ]
            ],
            [
                'module' => MenuGroup::PRODUCT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
                        'PermissionTitle' => 'Add Product',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_EDIT->value,
                        'PermissionTitle' => 'Edit Product',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::USERS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::USERS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::USERS_BAN->value,
                        'PermissionTitle' => 'Ban User',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::USERS_ACTIVE->value,
                        'PermissionTitle' => 'Active User',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ],
            [
                'module' => MenuGroup::OTHERS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::OTHERS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_ADD->value,
                        'PermissionTitle' => 'Product Attribute',
                        'activity_scope' => 'system_level'
                    ],
                    [
                        'PermissionName' => Permission::MANAGE_CONFIGURATIONS->value,
                        'PermissionTitle' => 'Manage Configuration',
                        'activity_scope' => 'system_level'
                    ]
                ]
            ]
        ];


        foreach ($page_list as $x_mod) {
            foreach ($x_mod['permissions'] as $x_page) {
                ModelsPermission::updateOrCreate(
                                ['name' => $x_page['PermissionName'],
                                'perm_title' => $x_page['PermissionTitle'], 
                                'guard_name' => 'api', 
                                'module' => $x_mod['module'],
                                'module_title' => $x_mod['module_tile'],
                                'available_for' => $x_page['activity_scope']
                                ]
                            );
            }
            
        }
    }
}
