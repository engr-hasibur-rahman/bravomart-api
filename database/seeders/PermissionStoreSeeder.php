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
                            'icon' => 'BringToFront',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_PENDING->value,
                                    'PermissionTitle' => 'Pending',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Pending',
                                        'ar' => 'قيد الانتظار'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_CONFIRMED->value,
                                    'PermissionTitle' => 'Confirmed',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Confirmed',
                                        'ar' => 'مؤكد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_SCHEDULED->value,
                                    'PermissionTitle' => 'Scheduled',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Scheduled',
                                        'ar' => 'مجدولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_COOKING->value,
                                    'PermissionTitle' => 'Cooking (For Restaurant)',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cooking',
                                        'ar' => 'طبخ'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_READY_FOR_DELIVERY->value,
                                    'PermissionTitle' => 'Ready For Delivery',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ready For Delivery',
                                        'ar' => 'جاهز للتسليم'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_PRODUCT_ON_THE_WAY->value,
                                    'PermissionTitle' => 'Item On The Way',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Item On The Way',
                                        'ar' => 'البند في الطريق'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_DELIVERED->value,
                                    'PermissionTitle' => 'Delivered',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Delivered',
                                        'ar' => 'تم التوصيل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_FITTING_SCHEDULE->value,
                                    'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Fitting Schedule Done',
                                        'ar' => 'تم الانتهاء من جدول التجهيز'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_RETURNED_OR_REFUND->value,
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
                            'icon' => 'Codesandbox',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Products',
                                'ar' => 'منتجات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_LIST->value,
                                    'PermissionTitle' => 'Manage Products',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_ADD->value,
                                    'PermissionTitle' => 'Add New Product',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add New Product',
                                        'ar' => 'إضافة منتج جديد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_LOW_STOCK->value,
                                    'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Low-Stock/Out of Stock Product',
                                        'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_BULK_EXPORT->value,
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
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_BRAND_LIST_STORE->value,
                            'PermissionTitle' => 'Brand/Manufacturers/Publications',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Brand/Manufacturers/Publications',
                                'ar' => 'العلامة التجارية/الشركات المصنعة/المنشورات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PRODUCT_AUTHORS_LIST_STORE->value,
                            'PermissionTitle' => 'Author\'s List',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Author\'s List',
                                'ar' => 'قائمة المؤلفين'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PRODUCT_FAB_COMB_ADD->value,
                            'PermissionTitle' => 'Manage Combinations',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Manage Combinations',
                                'ar' => 'إدارة التركيبات'
                            ]
                        ],
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
                            'PermissionName' => PermissionKey::FINANCIAL_TRANSACTIONS->value,
                            'PermissionTitle' => 'Transactions',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Transactions',
                                'ar' => 'المعاملات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_WITHDRAWLS->value,
                            'PermissionTitle' => 'Withdrawals',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdrawals',
                                'ar' => 'السحوبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_MYINCOME->value,
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
                            'PermissionName' => PermissionKey::FEEDBACK_REVIEWS->value,
                            'PermissionTitle' => 'Reviews',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Reviews',
                                'ar' => 'المراجعات'
                            ]
                        ],
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
                                    'PermissionName' => PermissionKey::PROMOTION_DEALS_AVAILABLE->value,
                                    'PermissionTitle' => 'Available flash deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Available flash deals',
                                        'ar' => 'عروض فلاش متاحة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PROMOTION_MY_PRODUCT_IN_DEALS->value,
                                    'PermissionTitle' => 'My products in deals',
                                    'activity_scope' => 'store_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'My products in deals',
                                        'ar' => 'منتجاتي في العروض'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PROMOTION_ASK_FOR_ENROLL->value,
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
                            'PermissionName' => PermissionKey::PROMOTION_COUPONS->value,
                            'PermissionTitle' => 'Coupons',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Coupons',
                                'ar' => 'كوبونات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PROMOTION_BANNERS->value,
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
                            'PermissionName' => PermissionKey::STORE_STORE_NOTICE->value,
                            'PermissionTitle' => 'Store Notice',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Notice',
                                'ar' => 'إشعار المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_STORE_MESSAGE->value,
                            'PermissionTitle' => 'Message',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Message',
                                'ar' => 'رسالة'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_STORE_CONFIG->value,
                            'PermissionTitle' => 'Store Config',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Config',
                                'ar' => 'تكوين المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_MY_SHOP->value,
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
                            'PermissionName' => PermissionKey::STORE_BUSINESS_PLAN->value,
                            'PermissionTitle' => 'My Business Plan',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Business Plan',
                                'ar' => 'خطة عملي'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_WALLET->value,
                            'PermissionTitle' => 'My Wallet',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Wallet',
                                'ar' => 'محفظتي'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_DISBURSE_METHOD->value,
                            'PermissionTitle' => 'Disbursement Method',
                            'activity_scope' => 'store_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Disbursement Method',
                                'ar' => 'طريقة الصرف'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_POS_CONFIG->value,
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
