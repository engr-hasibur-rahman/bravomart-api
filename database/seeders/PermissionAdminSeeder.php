<?php

namespace Database\Seeders;

use App\Enums\PermissionKey;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Create Admin Menu Automatically
     *
     * @return void
     */
    public function run()
    {
        $admin_main_menu = [
            [
                // Dashboard
                [
                    'PermissionName' => 'dashboard',
                    'PermissionTitle' => 'Dashboard',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],

                // Pos section
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Pos section',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view',],
                    'translations' => [
                        'en' => 'Pos section',
                        'ar' => 'قسم المواضع'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_POS_SALES->value,
                            'PermissionTitle' => 'Instant Sales',
                            'activity_scope' => 'system_level',
                            'icon' => 'BadgeCent',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Instant Sales',
                                'ar' => 'المبيعات الفورية'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_POS_SETTINGS->value,
                            'PermissionTitle' => 'Pos Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'BadgeCent',
                            'options' => ['view','update'],
                            'translations' => [
                                'en' => 'Pos Settings',
                                'ar' => 'المبيعات الفورية'
                            ]
                        ]
                    ]
                ],

                // Orders & Reviews
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Orders & Reviews',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Orders & Reviews',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Orders',
                            'activity_scope' => 'system_level',
                            'icon' => 'BringToFront',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Orders',
                                'ar' => 'قائمة المناطق'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update', 'others'],
                                    'translations' => [
                                        'en' => 'Returned or Refunded',
                                        'ar' => 'تم إرجاعه أو استرداده'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // Product Manage
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Product management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Product management',
                        'ar' => 'قائمة المناطق'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Products',
                            'activity_scope' => 'system_level',
                            'icon' => 'Codesandbox',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Products',
                                'ar' => 'منتجات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCTS_MANAGE->value,
                                    'PermissionTitle' => 'All Products',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_APPROVAL_REQ->value,
                                    'PermissionTitle' => 'Product Approval Request',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Product Approval Request',
                                        'ar' => 'طلب الموافقة على المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_STOCK_REPORT->value,
                                    'PermissionTitle' => 'Product Low & Out Stock',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view'],
                                    'translations' => [
                                        'en' => 'Product Low & Out Stock',
                                        'ar' => 'المنتجات منخفضة المخزون وغير المتوفرة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view','update'],
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ]
                            ]
                        ],

                        // Product Inventory report
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_INVENTORY->value,
                            'PermissionTitle' => 'Product Inventory',
                            'activity_scope' => 'system_level',
                            'icon' => 'Cog',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Product Inventory',
                                'ar' => 'مخزون المنتج'
                            ]
                        ],

                        // category manage
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Category',
                            'activity_scope' => 'system_level',
                            'icon' => 'Layers3',
                            'translations' => [
                                'en' => 'Category',
                                'ar' => 'قائمة الفئات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_CATEGORY_LIST->value,
                                    'PermissionTitle' => 'Category List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Category List',
                                        'ar' => 'قائمة فئات المنتجات'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Attribute',
                            'activity_scope' => 'system_level',
                            'icon' => 'AttributeIcon',
                            'translations' => [
                                'en' => 'Attribute',
                                'ar' => 'قائمة السمات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_ATTRIBUTE_LIST->value,
                                    'PermissionTitle' => 'Attribute List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Attribute List',
                                        'ar' => 'قائمة السمات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_ATTRIBUTE_ADD->value,
                                    'PermissionTitle' => 'Add Attribute',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Attribute',
                                        'ar' => 'إضافة سمة'
                                    ]
                                ]
                            ]
                        ],
                        // Product Brand
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Brand Management',
                            'activity_scope' => 'system_level',
                            'icon' => 'VectorIcon',
                            'translations' => [
                                'en' => 'Brand Management',
                                'ar' => 'المنشورات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_BRAND_LIST->value,
                                    'PermissionTitle' => 'Brand Lists',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Brand Lists',
                                        'ar' => ' للمنتج'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Tags Management',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Tag List',
                                'ar' => 'العلامات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_TAG_LIST->value,
                                    'PermissionTitle' => 'Tag List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Tag List',
                                        'ar' => 'قائمة العلامات'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Authors (For Book Only)',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Authors (For Book Only)',
                                'ar' => 'قائمة المؤلفين'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_AUTHORS_LIST->value,
                                    'PermissionTitle' => 'Author\'s List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Author\'s List',
                                        'ar' => 'قائمة المؤلفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_AUTHORS_REQUESTED_FROM_STORE->value,
                                    'PermissionTitle' => 'Author Add Requested From Store',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Author Add Requested From Store',
                                        'ar' => 'تم طلب إضافة المؤلف من المتجر'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Addons',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Addons',
                                'ar' => 'إدارة التركيبات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_ADDONS_LIST->value,
                                    'PermissionTitle' => 'Manage addons',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Manage addons',
                                        'ar' => 'إدارة الإضافات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_ADDONS_ADD->value,
                                    'PermissionTitle' => 'Add New addon',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add New addon',
                                        'ar' => 'إضافة وظيفة إضافية جديدة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Coupon Management',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Coupon Management',
                                'ar' => 'إدارة التركيبات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COUPON_MANAGE->value,
                                    'PermissionTitle' => 'Coupon list',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Coupon list',
                                        'ar' => 'إدارة التركيبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COUPON_LINE_MANAGE->value,
                                    'PermissionTitle' => 'Coupon line list',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Coupon line list',
                                        'ar' => 'إضافة مجموعات'
                                    ]
                                ]
                            ],


                        ]
                    ]
                ],

                //Store management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Store management',
                    'activity_scope' => 'system_level',
                    'icon' => 'Layers3',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Store management',
                        'ar' => 'إدارة المتجر'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_LIST->value,
                            'PermissionTitle' => 'Store List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Store List',
                                'ar' => 'قائمة المتاجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_ADD->value,
                            'PermissionTitle' => 'Store Add',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Store Add',
                                'ar' => 'إضافة متجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_APPROVAL->value,
                            'PermissionTitle' => 'Store Approval Request',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Store Approval Request',
                                'ar' => 'في انتظار الموافقة/الرفض'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_RECOMMENDED->value,
                            'PermissionTitle' => 'Recommended Store',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view','update'],
                            'translations' => [
                                'en' => 'Recommended Store',
                                'ar' => 'المتجر الموصى به'
                            ]
                        ]
                    ]
                ],

                // Promotional control
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Promotional control',
                    'activity_scope' => 'system_level',
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
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['View'],
                            'translations' => [
                                'en' => 'Flash Sale',
                                'ar' => 'بيع سريع'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_MANAGE->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'منتجاتي في العروض'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_JOIN_DEALS->value,
                                    'PermissionTitle' => 'Join Deals Requests',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'delete', 'update', 'others'],
                                    'translations' => [
                                        'en' => 'Join Deals',
                                        'ar' => 'اطلب التسجيل'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // Blog Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Blog Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Blog Management',
                        'ar' => 'إدارة المدونة'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Blogs',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Blogs',
                                'ar' => ' الموظفين'
                            ],

                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_BLOG_CATEGORY->value,
                                    'PermissionTitle' => 'Category',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Category',
                                        'ar' => ' الموظفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_BLOG_POSTS->value,
                                    'PermissionTitle' => 'Posts',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Posts',
                                        'ar' => 'دعامات'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // Support Ticket Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Support Ticket Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Support Ticket Management',
                        'ar' => 'إدارة المدونة'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Tickets',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Tickets',
                                'ar' => ' الموظفين'
                            ],

                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_TICKETS_DEPARTMENT->value,
                                    'PermissionTitle' => 'Department',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Department',
                                        'ar' => ' الموظفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_ALL_TICKETS->value,
                                    'PermissionTitle' => 'All Tickets',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Tickets',
                                        'ar' => 'دعامات'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // dynamic pages manage
                 [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Pages Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Pages Management',
                        'ar' => 'إدارة الصفحات'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_PAGES_LIST->value,
                            'PermissionTitle' => 'Page Lists',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Page Lists',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ]
                    ]
                ],

                // wallet manage
                 [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Wallet Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Wallet Management',
                        'ar' => 'إدارة الصفحات'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_WALLET_MANAGE->value,
                            'PermissionTitle' => 'Wallet Lists',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Wallet Lists',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ]
                    ]
                ]

            ]
        ];

        // Deliveryman, Customer,Employee
        $admin_user_related_menu = [
            [
                // Deliveryman management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Deliveryman management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Deliveryman management',
                        'ar' => 'إدارة التوصيل'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_VEHICLE_TYPE->value,
                            'PermissionTitle' => 'Vehicle Types',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Vehicle Types',
                                'ar' => 'فئة المركبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_MANAGE_LIST->value,
                            'PermissionTitle' => 'Deliveryman List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Deliveryman List',
                                'ar' => 'قائمة رجال التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_MANAGE_REVIEW->value,
                            'PermissionTitle' => 'Reviews',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Reviews',
                                'ar' => 'المراجعات'
                            ]
                        ]
                    ]
                ],

                // Customer management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Customer management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Customer management',
                        'ar' => 'إدارة العملاء'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_CUSTOMER_MANAGEMENT_LIST->value,
                            'PermissionTitle' => 'Customers',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Customers',
                                'ar' => 'عملاء'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                            'PermissionTitle' => 'Subscriber List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Subscriber List',
                                'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_CUSTOMER_CONTACT_MESSAGES->value,
                            'PermissionTitle' => 'Contact Messages',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Contact Messages',
                                'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                            ]
                        ]
                    ]
                ],

                // Employee Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Employee Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Employee Management',
                        'ar' => 'إدارة الموظفين'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Staff Roles',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Staff Roles',
                                'ar' => 'أدوار الموظفين'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::USERS_ROLE_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'علاوة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::USERS_ROLE_ADD->value,
                                    'PermissionTitle' => 'Add Role',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Role',
                                        'ar' => 'إضافة دور'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'My Staff',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'My Staff',
                                'ar' => 'طاقمي'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::USERS_LIST_ADMIN->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'علاوة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::USERS_ADD_ADMIN->value,
                                    'PermissionTitle' => 'Add Staff',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Staff',
                                        'ar' => 'إضافة الموظفين'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];


        $admin_transaction_related_menu = [
            [
                // Financial Activity
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Financial Activity',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Financial Activity',
                        'ar' => 'النشاط المالي'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_WITHDRAW_METHOD_MANAGEMENT->value,
                            'PermissionTitle' => 'Withdrawal Method',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdrawal Method',
                                'ar' => 'طريقة السحب'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_HISTORY->value,
                            'PermissionTitle' => 'Withdraw History',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Withdraw History',
                                'ar' => 'طلبات السحب'
                            ]
                        ], [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST->value,
                            'PermissionTitle' => 'Withdraw Requests',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Withdraw Requests',
                                'ar' => 'طلبات السحب'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_STORE_DISBURSEMENT->value,
                            'PermissionTitle' => 'Store Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Store Disbursement',
                                'ar' => 'صرف المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value,
                            'PermissionTitle' => 'Delivery Man Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Delivery Man Disbursement',
                                'ar' => 'صرف رواتب موظف التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_COLLECT_CASH->value,
                            'PermissionTitle' => 'Cash Collect',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Cash Collect',
                                'ar' => 'جمع النقود'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_FINANCIAL_DELIVERY_MAN_PAYMENTS->value,
                            'PermissionTitle' => 'Delivery Man Payments',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Delivery Man Payments',
                                'ar' => 'مدفوعات توصيل الطلبات'
                            ]
                        ]
                    ]
                ],

                // Report and analytics
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Report and analytics',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Report and analytics',
                        'ar' => 'التقارير والتحليلات'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_REPORT_ANALYTICS->value,
                            'PermissionTitle' => 'Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Report',
                                'ar' => 'تقرير المعاملات'
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $admin_settings_related_menu = [
            [

                // Notice Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Notice Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Notice Management',
                        'ar' => 'إدارة الأعمال'
                    ],
                    'submenu' => [                       
                        [
                            'PermissionName' => PermissionKey::ADMIN_NOTICE_MANAGEMENT->value,
                            'PermissionTitle' => 'Notices',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Notices',
                                'ar' => 'إعدادات الأعمال'
                            ]
                        ]                                                                
                    ]
                ],


                // Business Operations
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Business Operations',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Business Operations',
                        'ar' => 'عمليات الأعمال'
                    ],
                    'submenu' => [
                        // Area Setup
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Area Setup',
                            'activity_scope' => 'system_level',
                            'icon' => 'Locate',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Area Setup',
                                'ar' => 'إعداد المنطقة'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_GEO_AREA_MANAGE->value,
                                    'PermissionTitle' => 'Area List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Area List',
                                        'ar' => 'قائمة المناطق'
                                    ]
                                ]
                            ]
                        ],

                        // Subscription Management
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Subscription Management',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Subscription Management',
                                'ar' => 'عمليات الأعمال'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SUBSCRIPTION_PACKAGE_TYPE_MANAGE->value,
                                    'PermissionTitle' => 'Subscription Type',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Subscription Type',
                                        'ar' => 'باقة الاشتراك'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SUBSCRIPTION_PACKAGE_MANAGE->value,
                                    'PermissionTitle' => 'Subscription Package',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Subscription Package',
                                        'ar' => 'قائمة المشتركين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SUBSCRIPTION_SELLER_PACKAGE_MANAGE->value,
                                    'PermissionTitle' => 'Seller Subscription',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Seller Subscription',
                                        'ar' => 'قائمة المشتركين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SUBSCRIPTION_SETTINGS->value,
                                    'PermissionTitle' => 'Subscription Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Subscription Settings',
                                        'ar' => 'إعدادات'
                                    ]
                                ]
                            ]
                        ],

                        // Admin Commission System
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Commission System',
                            'activity_scope' => 'system_level',
                            'icon' => 'Money',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Commission System',
                                'ar' => 'نظام عمولة المسؤول'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COMMISSION_SETTINGS->value,
                                    'PermissionTitle' => 'Commission Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update', 'others'],
                                    'translations' => [
                                        'en' => 'Commission Settings',
                                        'ar' => 'إعدادات العمولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COMMISSION_HISTORY->value,
                                    'PermissionTitle' => 'Commission History',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'others'],
                                    'translations' => [
                                        'en' => 'Commission History',
                                        'ar' => 'تاريخ العمولة'
                                    ]
                                ]
                            ]
                        ]


                    ]
                ],

                //Payment settings management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Payment Gateways management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Payment Gateways management',
                        'ar' => 'إدارة بوابات الدفع'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_PAYMENT_SETTINGS->value,
                            'PermissionTitle' => 'Payment Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view','update'],
                            'translations' => [
                                'en' => 'Payment Settings',
                                'ar' => 'إعدادات الدفع'
                            ]
                        ]

                    ]
                ],

                //System management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'System management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'System management',
                        'ar' => 'إدارة النظام'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::GENERAL_SETTINGS->value,
                            'PermissionTitle' => 'General Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'General Settings',
                                'ar' => 'الإعدادات العامة'
                            ]
                        ],
                        [
                            'PermissionName' =>  PermissionKey::APPEARANCE_SETTINGS->value,
                            'PermissionTitle' => 'Appearance Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Appearance Settings',
                                'ar' => 'إعدادات المظهر'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::FOOTER_CUSTOMIZATION->value,
                                    'PermissionTitle' => 'Footer Customization',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Footer Customization',
                                        'ar' => 'تخصيص التذييل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::MAINTENANCE_SETTINGS->value,
                                    'PermissionTitle' => 'Maintenance Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Maintenance Settings',
                                        'ar' => 'إعدادات الصيانة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' =>  '',
                            'PermissionTitle' => 'Email Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Email Settings',
                                'ar' => 'إعدادات البريد الإلكتروني'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::SMTP_SETTINGS->value,
                                    'PermissionTitle' => 'SMTP Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'SMTP Settings',
                                        'ar' => 'تخصيص التذييل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::EMAIL_TEMPLATES->value,
                                    'PermissionTitle' => 'Email Templates',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Email Templates',
                                        'ar' => 'قوالب البريد الإلكتروني'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' =>  PermissionKey::SEO_SETTINGS->value,
                            'PermissionTitle' => 'SEO Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'SEO Settings',
                                'ar' => 'إعدادات تحسين محركات البحث'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Third-Party Integrations',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Third-Party Integrations',
                                'ar' => 'التكاملات مع جهات خارجية'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::GOOGLE_MAP_SETTINGS->value,
                                    'PermissionTitle' => 'Google Map Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Google Map Settings',
                                        'ar' => 'إعدادات خرائط جوجل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::FIREBASE_SETTINGS->value,
                                    'PermissionTitle' => 'Firebase Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Firebase Settings',
                                        'ar' => 'إعدادات Firebase'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SOCIAL_LOGIN_SETTINGS->value,
                                    'PermissionTitle' => 'Social Login Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Social Login Settings',
                                        'ar' =>  'إعدادات تسجيل الدخول الاجتماعية'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::CACHE_MANAGEMENT->value,
                            'PermissionTitle' => 'Cache Management',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Cache Management',
                                'ar' => 'إدارة ذاكرة التخزين المؤقت'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::DATABASE_UPDATE_CONTROLS->value,
                            'PermissionTitle' => 'Database Update Controls',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Database Update Controls',
                                'ar' => 'عناصر التحكم في تحديث قاعدة البيانات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::APP_SETTINGS->value,
                            'PermissionTitle' => 'App settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'App settings',
                                'ar' => 'إعدادات التطبيق'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $admin_dispatch_related_menu = [
            [
                // dispatch-management
                [
                    'PermissionName' => 'dispatch-management',
                    'PermissionTitle' => 'Dispatch management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Dispatch management',
                        'ar' => 'إدارة الإرسال'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Grocery',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Grocery',
                                'ar' => 'خضروات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::UNSIGNED_ORDERS_GROCERY->value,
                                    'PermissionTitle' => 'Unassigned Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Unassigned Orders',
                                        'ar' => 'الطلبات غير المخصصة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ONGOING_ORDERS_GROCERY->value,
                                    'PermissionTitle' => 'Ongoing Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ongoing Orders',
                                        'ar' => 'الطلبات الجارية'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $page_list = array_merge($admin_main_menu, $admin_user_related_menu, $admin_transaction_related_menu, $admin_settings_related_menu, $admin_dispatch_related_menu);


        foreach ($page_list as $x_mod) {
            foreach ($x_mod as $level_1) {

                $trans_level_1 = [];
                $options_l1 = isset($level_1['options']) && is_array($level_1['options']) ? $level_1['options'] : ['view'];

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
                        $options_l2 = isset($level_2['options']) && is_array($level_2['options']) ? $level_2['options'] : ['view'];

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
                                $options_l3 = isset($level_3['options']) && is_array($level_3['options']) ? $level_3['options'] : ['view'];

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
