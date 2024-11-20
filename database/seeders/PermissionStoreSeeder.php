<?php

namespace Database\Seeders;

use App\Enums\Permission;
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
                            'icon' => '',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'store_level',
                                    'icon' => '<Component size={20}/>',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PENDING->value,
                                    'PermissionTitle' => 'Pending',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Pending',
                                        'ar' => 'قيد الانتظار'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_CONFIRMED->value,
                                    'PermissionTitle' => 'Confirmed',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Confirmed',
                                        'ar' => 'مؤكد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_SCHEDULED->value,
                                    'PermissionTitle' => 'Scheduled',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Scheduled',
                                        'ar' => 'مجدولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_COOKING->value,
                                    'PermissionTitle' => 'Cooking (For Restaurant)',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cooking',
                                        'ar' => 'طبخ'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_READY_FOR_DELIVERY->value,
                                    'PermissionTitle' => 'Ready For Delivery',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ready For Delivery',
                                        'ar' => 'جاهز للتسليم'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PRODUCT_ON_THE_WAY->value,
                                    'PermissionTitle' => 'Item On The Way',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Item On The Way',
                                        'ar' => 'البند في الطريق'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_DELIVERED->value,
                                    'PermissionTitle' => 'Delivered',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Delivered',
                                        'ar' => 'تم التوصيل'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_FITTING_SCHEDULE->value,
                                    'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Fitting Schedule Done',
                                        'ar' => 'تم الانتهاء من جدول التجهيز'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
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
                            'PermissionTitle' => 'Products',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Products',
                                'ar' => 'منتجات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LIST->value,
                                    'PermissionTitle' => 'Manage Products',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['View', 'Add', 'Edit', 'Delete'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
                                    'PermissionTitle' => 'Add New Product',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add New Product',
                                        'ar' => 'إضافة منتج جديد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LOW_STOCK->value,
                                    'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Low-Stock/Out of Stock Product',
                                        'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_CATEGORY_LIST_STORE->value,
                            'PermissionTitle' => 'Category List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Category List',
                                'ar' => 'قائمة الفئات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST->value,
                            'PermissionTitle' => 'Attribute List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Attribute List',
                                'ar' => 'قائمة السمات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_BRAND_LIST_STORE->value,
                            'PermissionTitle' => 'Brand/Manufacturers/Publications',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Brand/Manufacturers/Publications',
                                'ar' => 'العلامة التجارية/الشركات المصنعة/المنشورات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_AUTHORS_LIST_STORE->value,
                            'PermissionTitle' => 'Author\'s List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Author\'s List',
                                'ar' => 'قائمة المؤلفين'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_FAB_COMB_ADD->value,
                            'PermissionTitle' => 'Manage Combinations',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Manage Combinations',
                                'ar' => 'إدارة التركيبات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PRODUCT_ADDONS_ADD->value,
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
                            'PermissionName' => Permission::FINANCIAL_TRANSACTIONS->value,
                            'PermissionTitle' => 'Transactions',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Transactions',
                                'ar' => 'المعاملات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_WITHDRAWLS->value,
                            'PermissionTitle' => 'Withdrawals',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdrawals',
                                'ar' => 'السحوبات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_MYINCOME->value,
                            'PermissionTitle' => 'My Income',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Income',
                                'ar' => 'دخلي'
                            ]
                        ]
                    ]
                ],
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
                            'PermissionName' => Permission::FEEDBACK_REVIEWS->value,
                            'PermissionTitle' => 'Reviews',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Reviews',
                                'ar' => 'المراجعات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FEEDBACK_QUESTIONS->value,
                            'PermissionTitle' => 'Questions/Chat',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Questions/Chat',
                                'ar' => 'الأسئلة/الدردشة'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FEEDBACK_QUERIES->value,
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
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'User control',
                    'activity_scope' => 'store_level',
                    'icon' => '',
                    'options' => ['View'],
                    'translations' => [
                        'en' => 'User control',
                        'ar' => 'التحكم بالمستخدم'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => Permission::USERS_BAN->value,
                            'PermissionTitle' => 'Ban User',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Ban User',
                                'ar' => 'حظر المستخدم'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::USERS_ACTIVE->value,
                            'PermissionTitle' => 'Active User',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Active User',
                                'ar' => 'المستخدم النشط'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::USERS_ROLES_STORE->value,
                            'PermissionTitle' => 'Staff Roles',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Staff Roles',
                                'ar' => 'أدوار الموظفين'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::USERS_STAFF_ADD_STORE->value,
                            'PermissionTitle' => 'Add New',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Add New',
                                'ar' => 'إضافة جديد'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::USERS_STAFF_LIST_STORE->value,
                            'PermissionTitle' => 'List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'List',
                                'ar' => 'قائمة'
                            ]
                        ]
                    ]
                ],
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
                                    'PermissionName' => Permission::PROMOTION_DEALS_AVAILABLE->value,
                                    'PermissionTitle' => 'Available flash deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Available flash deals',
                                        'ar' => 'عروض فلاش متاحة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PROMOTION_MY_PRODUCT_IN_DEALS->value,
                                    'PermissionTitle' => 'My products in deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'My products in deals',
                                        'ar' => 'منتجاتي في العروض'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PROMOTION_ASK_FOR_ENROLL->value,
                                    'PermissionTitle' => 'Ask for enrollment',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ask for enrollment',
                                        'ar' => 'اطلب التسجيل'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PROMOTION_COUPONS->value,
                            'PermissionTitle' => 'Coupons',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Coupons',
                                'ar' => 'كوبونات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::PROMOTION_BANNERS->value,
                            'PermissionTitle' => 'Banners',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Banners',
                                'ar' => 'لافتات'
                            ]
                        ]
                    ]
                ],
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
                            'PermissionName' => Permission::STORE_STORE_NOTICE->value,
                            'PermissionTitle' => 'Store Notice',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Notice',
                                'ar' => 'إشعار المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_STORE_MESSAGE->value,
                            'PermissionTitle' => 'Message',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Message',
                                'ar' => 'رسالة'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_STORE_CONFIG->value,
                            'PermissionTitle' => 'Store Config',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Config',
                                'ar' => 'تكوين المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_MY_SHOP->value,
                            'PermissionTitle' => 'My Stores',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Stores',
                                'ar' => 'متاجري'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_BUSINESS_PLAN->value,
                            'PermissionTitle' => 'My Business Plan',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Business Plan',
                                'ar' => 'خطة عملي'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_WALLET->value,
                            'PermissionTitle' => 'My Wallet',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Wallet',
                                'ar' => 'محفظتي'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_DISBURSE_METHOD->value,
                            'PermissionTitle' => 'Disbursement Method',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Disbursement Method',
                                'ar' => 'طريقة الصرف'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_POS_CONFIG->value,
                            'PermissionTitle' => 'POS Configuration',
                            'activity_scope' => 'store_level',
                            'icon' => '',
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
