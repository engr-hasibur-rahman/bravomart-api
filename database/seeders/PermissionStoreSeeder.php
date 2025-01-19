<?php

namespace Database\Seeders;

use App\Enums\PermissionKey;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionStoreSeeder extends Seeder
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
                // Dashboard
                [
                    'PermissionName' => 'dashboard',
                    'PermissionTitle' => 'Dashboard',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],

                // Pos management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'POS Management',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'POS Management',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_POS_SALES->value,
                            'PermissionTitle' => 'POS Manager',
                            'activity_scope' => 'store_level',
                            'icon' => 'BringToFront',
                            'options' => ['View', 'insert', 'update', 'Delete', 'others'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ]
                        ]
                    ]
                ],

                // order manage
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Orders & Reviews',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Orders & Reviews',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Orders',
                            'activity_scope' => 'store_level',
                            'icon' => 'BringToFront',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_ORDER_MANAGE->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_ORDERS_RETURNED_OR_REFUND->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Returned or Refunded',
                                        'ar' => 'تم إرجاعه أو استرداده'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_ORDERS_REVIEWS_MANAGE->value,
                                    'PermissionTitle' => 'Reviews',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Reviews',
                                        'ar' => 'المراجعات'
                                    ]
                                ],
                            ]
                        ]
                    ]
                ],

                // product manage
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Product management',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Product management',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Products',
                            'activity_scope' => 'store_level',
                            'icon' => 'Codesandbox',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Products',
                                'ar' => 'منتجات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_LIST->value,
                                    'PermissionTitle' => 'Manage Products',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_ADD->value,
                                    'PermissionTitle' => 'Add New Product',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Add New Product',
                                        'ar' => 'إضافة منتج جديد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_STOCK_REPORT->value,
                                    'PermissionTitle' => 'Product Low & Out Stock',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view'],
                                    'translations' => [
                                        'en' => 'Product Low & Out Stock',
                                        'ar' => ' المنتجات منخفضة المخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update'],
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update'],
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PRODUCT_ATTRIBUTE_LIST_STORE->value,
                            'PermissionTitle' => 'Attribute List',
                            'activity_scope' => 'store_level',
                            'icon' => 'Ratio',
                            'translations' => [
                                'en' => 'Attribute List',
                                'ar' => 'قائمة السمات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_PRODUCT_AUTHORS_MANAGE->value,
                            'PermissionTitle' => 'Author List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['View', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Author List',
                                'ar' => 'قائمة المؤلفين'
                            ]
                        ],

                        // for food product
                        [
                            'PermissionName' => PermissionKey::PRODUCT_ADDONS_ADD->value,
                            'PermissionTitle' => 'Addons',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Addons',
                                'ar' => 'إدارة التركيبات'
                            ]
                        ]
                    ]
                ],

                // Inventory Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Inventory Management',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Inventory Management',
                        'ar' => 'الإدارة المالية'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_PRODUCT_INVENTORY->value,
                            'PermissionTitle' => 'Inventory',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Inventory',
                                'ar' => 'السحوبات'
                            ]
                        ]
                    ]
                ],

                // Promotional control
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Promotional control',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Promotional control',
                        'ar' => 'الرقابة الترويجية'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Flash Sale',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Flash Sale',
                                'ar' => 'بيع سريع'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_ACTIVE_DEALS->value,
                                    'PermissionTitle' => 'Active Deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view'],
                                    'translations' => [
                                        'en' => 'Active Deals',
                                        'ar' => 'عروض فلاش متاحة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_MY_DEALS->value,
                                    'PermissionTitle' => 'My Deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view'],
                                    'translations' => [
                                        'en' => 'My Deals',
                                        'ar' => 'منتجاتي في العروض'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SELLER_STORE_PROMOTIONAL_FLASH_SALE_JOIN_DEALS->value,
                                    'PermissionTitle' => 'Join Deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'delete'],
                                    'translations' => [
                                        'en' => 'Join Deals',
                                        'ar' => 'اطلب التسجيل'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_PROMOTIONAL_BANNER_MANAGE->value,
                            'PermissionTitle' => 'Banners',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Banners',
                                'ar' => 'لافتات'
                            ]
                        ]
                    ]
                ],
                // Financial Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Financial Management',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Financial Management',
                        'ar' => 'الإدارة المالية'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS->value,
                            'PermissionTitle' => 'Withdrawals',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'insert'],
                            'translations' => [
                                'en' => 'Withdrawals',
                                'ar' => 'السحوبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_FINANCIAL_WALLET->value,
                            'PermissionTitle' => 'My Wallet',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Wallet',
                                'ar' => 'محفظتي'
                            ]
                        ]
                    ]
                ],

                //Feedback control
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Feedback control',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Feedback control',
                        'ar' => 'التحكم في ردود الفعل'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::FEEDBACK_QUESTIONS->value,
                            'PermissionTitle' => 'Questions/Chat',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Questions/Chat',
                                'ar' => 'الأسئلة/الدردشة'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FEEDBACK_QUERIES->value,
                            'PermissionTitle' => 'Product Queries',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Product Queries',
                                'ar' => 'استعلامات المنتج'
                            ]
                        ]
                    ]
                ],

                // Staff control
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Staff control',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Staff control',
                        'ar' => 'التحكم بالمستخدم'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::SELLER_STAFF_LIST->value,
                            'PermissionTitle' => 'Staff List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Staff List',
                                'ar' => 'قائمة'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STAFF_ROLES_STORE->value,
                            'PermissionTitle' => 'Staff Roles',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Staff Roles',
                                'ar' => 'أدوار الموظفين'
                            ]
                        ],

                    ]
                ],

                // Message Settings
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Message',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Message',
                        'ar' => 'إعدادات المتجر'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::STORE_STORE_MESSAGE->value,
                            'PermissionTitle' => 'Message',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Message',
                                'ar' => 'رسالة'
                            ]
                        ]
                    ]
                ],

                // Store Settings
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Store Settings',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'Store Settings',
                        'ar' => 'إعدادات المتجر'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_BUSINESS_PLAN->value,
                            'PermissionTitle' => 'Business Plan',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Business Plan',
                                'ar' => 'إشعار المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_STORE_NOTICE->value,
                            'PermissionTitle' => 'Store Notice',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Store Notice',
                                'ar' => 'إشعار المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_STORE_CONFIG->value,
                            'PermissionTitle' => 'Store Config',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'Store Config',
                                'ar' => 'تكوين المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_MY_SHOP->value,
                            'PermissionTitle' => 'My Stores',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'My Stores',
                                'ar' => 'متاجري'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SELLER_STORE_POS_CONFIG->value,
                            'PermissionTitle' => 'POS Configuration',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'POS Configuration',
                                'ar' => 'تكوين نقاط البيع'
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
                        'icon' => $level_1['icon'],
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
                                'icon' => $level_2['icon'],
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
                                        'icon' => $level_3['icon'],
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
