<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\MenuGroup;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_main_menu = [];
        $shop_menu = [
            [
                [
                    'PermissionName' => 'dashboard',
                    'PermissionTitle' => 'Dashboard',
                    'activity_scope' => 'system_level',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Pos section',
                    'activity_scope' => 'system_level',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Pos section',
                        'ar' => 'قسم المواضع'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => Permission::POS_SALES->value,
                            'PermissionTitle' => 'Instant Sales',
                            'activity_scope' => 'system_level',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Instant Sales',
                                'ar' => 'المبيعات الفورية'
                            ]
                        ]
                    ]
                ],
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Orders & Reviews',
                    'activity_scope' => 'system_level',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Orders & Reviews',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => MenuGroup::ORDER_MANAGEMENT->value,
                            'PermissionTitle' => 'Orders',
                            'activity_scope' => 'system_level',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PENDING->value,
                                    'PermissionTitle' => 'Pending',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Pending',
                                        'ar' => 'قيد الانتظار'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_CONFIRMED->value,
                                    'PermissionTitle' => 'Confirmed',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Confirmed',
                                        'ar' => 'مؤكد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_SCHEDULED->value,
                                    'PermissionTitle' => 'Scheduled',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Scheduled',
                                        'ar' => 'مجدولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_COOKING->value,
                                    'PermissionTitle' => 'Cooking (For Restaurant)',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Cooking',
                                        'ar' => 'طبخ'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_READY_FOR_DELIVERY->value,
                                    'PermissionTitle' => 'Ready For Delivery',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Ready For Delivery',
                                        'ar' => 'جاهز للتسليم'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PRODUCT_ON_THE_WAY->value,
                                    'PermissionTitle' => 'Item On The Way',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Item On The Way',
                                        'ar' => 'البند في الطريق'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_DELIVERED->value,
                                    'PermissionTitle' => 'Delivered',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Delivered',
                                        'ar' => 'تم التوصيل'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_FITTING_SCHEDULE->value,
                                    'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Fitting Schedule Done',
                                        'ar' => 'تم الانتهاء من جدول التجهيز'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Returned or Refunded',
                                        'ar' => 'تم إرجاعه أو استرداده'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Product management',
                    'activity_scope' => 'system_level',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Orders & Reviews',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Products',
                            'activity_scope' => 'system_level',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Products',
                                'ar' => 'منتجات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LIST->value,
                                    'PermissionTitle' => 'Manage Products',
                                    'activity_scope' => 'system_level',
                                    'options' => ['View', 'Add', 'Edit', 'Delete'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
                                    'PermissionTitle' => 'Add New Product',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Add New Product',
                                        'ar' => 'إضافة منتج جديد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LOW_STOCK->value,
                                    'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'All Low-Stock/Out of Stock Product',
                                        'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_APPROVAL_REQ->value,
                                    'PermissionTitle' => 'Product Approval Request',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Product Approval Request',
                                        'ar' => 'طلب الموافقة على المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Category',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Category List',
                                'ar' => 'قائمة الفئات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_LIST->value,
                                    'PermissionTitle' => 'Product Category List',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Product Category List',
                                        'ar' => 'قائمة فئات المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_ADD->value,
                                    'PermissionTitle' => 'Add Product Category',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Add Product Category',
                                        'ar' => 'إضافة فئة المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_EDIT->value,
                                    'PermissionTitle' => 'Edit Product Category',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Edit Product Category',
                                        'ar' => 'تعديل فئة المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_STATUS->value,
                                    'PermissionTitle' => 'Change Category Status',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Change Category Status',
                                        'ar' => 'تغيير حالة الفئة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Attribute',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Attribute',
                                'ar' => 'قائمة السمات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST->value,
                                    'PermissionTitle' => 'Attribute List',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Attribute List',
                                        'ar' => 'قائمة السمات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_ATTRIBUTE_ADD->value,
                                    'PermissionTitle' => 'Add Attribute',
                                    'activity_scope' => 'system_level',
                                    'translations' => [
                                        'en' => 'Add Attribute',
                                        'ar' => 'إضافة سمة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_BRAND_LIST_STORE->value,
                            'PermissionTitle' => 'Brand/Manufacturers/Publications',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Brand/Manufacturers/Publications',
                                'ar' => 'العلامة التجارية/الشركات المصنعة/المنشورات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_AUTHORS_LIST_STORE->value,
                            'PermissionTitle' => 'Author\'s List',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Author\'s List',
                                'ar' => 'قائمة المؤلفين'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_FAB_COMB_ADD->value,
                            'PermissionTitle' => 'Manage Combinations',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Manage Combinations',
                                'ar' => 'إدارة التركيبات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_ADDONS_ADD->value,
                            'PermissionTitle' => 'Addons',
                            'activity_scope' => 'system_level',
                            'translations' => [
                                'en' => 'Addons',
                                'ar' => 'إدارة التركيبات'
                            ]
                        ]
                    ]
                ]
            ]
        ];


        $page_list = array_merge($admin_main_menu, $shop_menu);


        foreach ($page_list as $x_mod) {
            foreach ($x_mod as $level_1) {

                $trans_level_1 = [];
                $options_l1 = isset($level_1['options']) && is_array($level_1['options']) ? $level_1['options'] : ['View'];

                $permission_l1 = ModelsPermission::updateOrCreate(
                    [
                        'name' => $level_1['PermissionName'] != '' ? $level_1['PermissionName'] : $level_1['PermissionTitle'],
                        'perm_title' => $level_1['PermissionTitle'],
                        'guard_name' => 'api',
                        'available_for' => $level_1['activity_scope'],
                        'options' => json_encode($options_l1)
                    ]
                );
                foreach ($level_1['translations'] as $key => $value) {
                    $trans_level_1[] = [
                        'translatable_type' => 'App\Models\Permissions',
                        'translatable_id' => $permission_l1->id,
                        'language' => $key,
                        'key' => 'perm_title',
                        'value' => $value,
                    ];
                }
                Translation::insert($trans_level_1);

                // Level 2 Menu Insert
                if (isset($level_1['submenu']) && is_array($level_1['submenu'])) {
                    foreach ($level_1['submenu'] as $level_2) {

                        $trans_level_2 = [];
                        $options_l2 = isset($level_2['options']) && is_array($level_2['options']) ? $level_2['options'] : ['View'];

                        $permission_l2 = ModelsPermission::updateOrCreate(
                            [
                                'name' => $level_2['PermissionName'] != '' ? $level_2['PermissionName'] : $level_2['PermissionTitle'],
                                'perm_title' => $level_2['PermissionTitle'],
                                'guard_name' => 'api',
                                'available_for' => $level_2['activity_scope'],
                                'options' => json_encode($options_l2),
                                'parent_id' => $permission_l1->id
                            ]
                        );
                        foreach ($level_2['translations'] as $key_2 => $value_2) {
                            $trans_level_2[] = [
                                'translatable_type' => 'App\Models\Permissions',
                                'translatable_id' => $permission_l2->id,
                                'language' => $key_2,
                                'key' => 'perm_title',
                                'value' => $value_2,
                            ];
                        }
                        Translation::insert($trans_level_2);

                        // Level 3 Menu Insert
                        if (isset($level_2['submenu']) && is_array($level_2['submenu'])) {
                            foreach ($level_2['submenu'] as $level_3) {

                                $trans_level_3 = [];
                                $options_l3 = isset($level_3['options']) && is_array($level_3['options']) ? $level_3['options'] : ['View'];

                                $permission_l3 = ModelsPermission::updateOrCreate(
                                    [
                                        'name' => $level_3['PermissionName'],
                                        'perm_title' => $level_3['PermissionTitle'],
                                        'guard_name' => 'api',
                                        'available_for' => $level_3['activity_scope'],
                                        'options' => json_encode($options_l3),
                                        'parent_id' => $permission_l2->id
                                    ]
                                );
                                foreach ($level_3['translations'] as $key_3 => $value_3) {
                                    $trans_level_3[] = [
                                        'translatable_type' => 'App\Models\Permissions',
                                        'translatable_id' => $permission_l3->id,
                                        'language' => $key_3,
                                        'key' => 'perm_title',
                                        'value' => $value_3,
                                    ];
                                }
                                Translation::insert($trans_level_3);

                            }
                        }
                    }
                }
            }

        }
    }
}
