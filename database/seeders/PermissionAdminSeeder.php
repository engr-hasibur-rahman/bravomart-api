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
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Pos section',
                        'ar' => 'قسم المواضع'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::POS_SALES->value,
                            'PermissionTitle' => 'Instant Sales',
                            'activity_scope' => 'system_level',
                            'icon' => 'BadgeCent',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Instant Sales',
                                'ar' => 'المبيعات الفورية'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::POS_SETTINGS_ADMIN->value,
                            'PermissionTitle' => 'Pos Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'RouteOff',
                            'translations' => [
                                'en' => 'Pos Settings',
                                'ar' => 'إعدادات الموضع'
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
                                    'PermissionName' => PermissionKey::ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_PENDING->value,
                                    'PermissionTitle' => 'Pending',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Pending',
                                        'ar' => 'قيد الانتظار'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_CONFIRMED->value,
                                    'PermissionTitle' => 'Confirmed',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Confirmed',
                                        'ar' => 'مؤكد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_SCHEDULED->value,
                                    'PermissionTitle' => 'Scheduled',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Scheduled',
                                        'ar' => 'مجدولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_COOKING->value,
                                    'PermissionTitle' => 'Cooking (For Restaurant)',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cooking',
                                        'ar' => 'طبخ'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_READY_FOR_DELIVERY->value,
                                    'PermissionTitle' => 'Ready For Delivery',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ready For Delivery',
                                        'ar' => 'جاهز للتسليم'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_PRODUCT_ON_THE_WAY->value,
                                    'PermissionTitle' => 'Item On The Way',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Item On The Way',
                                        'ar' => 'البند في الطريق'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_DELIVERED->value,
                                    'PermissionTitle' => 'Delivered',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Delivered',
                                        'ar' => 'تم التوصيل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_FITTING_SCHEDULE->value,
                                    'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Fitting Schedule Done',
                                        'ar' => 'تم الانتهاء من جدول التجهيز'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ORDERS_RETURNED_OR_REFUND->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'system_level',
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
                // Product Manage
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Product management',
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
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_LIST->value,
                                    'PermissionTitle' => 'Manage Products',
                                    'activity_scope' => 'system_level',
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
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert'],
                                    'translations' => [
                                        'en' => 'Add New Product',
                                        'ar' => 'إضافة منتج جديد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_LOW_STOCK->value,
                                    'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Low-Stock/Out of Stock Product',
                                        'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_APPROVAL_REQ->value,
                                    'PermissionTitle' => 'Product Approval Request',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Approval Request',
                                        'ar' => 'طلب الموافقة على المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PRODUCT_INVENTORY->value,
                            'PermissionTitle' => 'Product Inventory',
                            'activity_scope' => 'system_level',
                            'icon' => 'Cog',
                            'translations' => [
                                'en' => 'Product Inventory',
                                'ar' => 'مخزون المنتج'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Category',
                            'activity_scope' => 'system_level',
                            'icon' => 'Layers3',
                            'translations' => [
                                'en' => 'Category List',
                                'ar' => 'قائمة الفئات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_CATEGORY_LIST->value,
                                    'PermissionTitle' => 'Product Category List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Product Category List',
                                        'ar' => 'قائمة فئات المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_CATEGORY_ADD->value,
                                    'PermissionTitle' => 'Add Product Category',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert'],
                                    'translations' => [
                                        'en' => 'Add Product Category',
                                        'ar' => 'إضافة فئة المنتج'
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
                            'PermissionTitle' => 'Warranty',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Warranty',
                                'ar' => 'ضمان'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_WARRANTY_LIST->value,
                                    'PermissionTitle' => 'Warranty List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Warranty List',
                                        'ar' => 'قائمة الضمان'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_WARRANTY_ADD->value,
                                    'PermissionTitle' => 'Add Warranty',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Warranty',
                                        'ar' => 'إضافة الضمان'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Tags',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Tags',
                                'ar' => 'العلامات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_TAG_LIST->value,
                                    'PermissionTitle' => 'Tag List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Tag List',
                                        'ar' => 'قائمة العلامات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_TAG_ADD->value,
                                    'PermissionTitle' => 'Add Tag',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Tag',
                                        'ar' => 'إضافة علامة'
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
                                    'PermissionName' => PermissionKey::PRODUCT_AUTHORS_ADD->value,
                                    'PermissionTitle' => 'Add Book Author',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Book Author',
                                        'ar' => 'أضف مؤلف الكتاب'
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
                            'PermissionTitle' => 'Manage Combinations(Furniture Only)',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Manage Combinations',
                                'ar' => 'إدارة التركيبات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_FAB_COMB_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'إدارة التركيبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_FAB_COMB_ADD->value,
                                    'PermissionTitle' => 'Add Combinations',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Combinations',
                                        'ar' => 'إضافة مجموعات'
                                    ]
                                ]
                            ]
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
                            'PermissionName' => PermissionKey::STORE_APPROVAL->value,
                            'PermissionTitle' => 'Pending Approval/ Rejected',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Pending Approval/ Rejected',
                                'ar' => 'في انتظار الموافقة/الرفض'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_LIST->value,
                            'PermissionTitle' => 'Store List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
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
                            'translations' => [
                                'en' => 'Store Add',
                                'ar' => 'إضافة متجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_RECOMMENDED->value,
                            'PermissionTitle' => 'Recommended Store',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Recommended Store',
                                'ar' => 'المتجر الموصى به'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_STORE_ADD_UPDATE->value,
                            'PermissionTitle' => 'Store Add/Update',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Add/Update',
                                'ar' => 'إضافة/تحديث المتجر'
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
                ]

            ]
        ];

        $admin_user_related_menu = [
            [
                [
                    'PermissionName' => 'User-Dashboard',
                    'PermissionTitle' => 'User Dashboard',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'User Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],

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
                            'PermissionName' => PermissionKey::DELIVERY_VEHICLE_CATEGORY->value,
                            'PermissionTitle' => 'Vehicles category',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Vehicles category',
                                'ar' => 'فئة المركبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::DELIVERY_PERSON_ADD->value,
                            'PermissionTitle' => 'Add Delivery Man',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Add Delivery Man',
                                'ar' => 'إضافة رجل التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::DELIVERY_PERSON_LIST->value,
                            'PermissionTitle' => 'Delivery Man List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man List',
                                'ar' => 'قائمة رجال التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::DELIVERY_PERSONS_REVIEW->value,
                            'PermissionTitle' => 'Reviews',
                            'activity_scope' => 'system_level',
                            'icon' => '',
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
                            'PermissionName' => PermissionKey::CUSTOMER_LIST->value,
                            'PermissionTitle' => 'Customers',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Customers',
                                'ar' => 'عملاء'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Customer Wallet',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Customer Wallet',
                                'ar' => 'محفظة العميل'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::CUSTOMER_WALLET_ADD_FUND->value,
                                    'PermissionTitle' => 'Add Fund',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Fund',
                                        'ar' => 'إضافة صندوق'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::CUSTOMER_WALLET_REPORT->value,
                                    'PermissionTitle' => 'Report',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Report',
                                        'ar' => 'تقرير'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::CUSTOMER_WALLET_BONUS->value,
                                    'PermissionTitle' => 'Bonus',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bonus',
                                        'ar' => 'علاوة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::CUSTOMER_LOYALTY_POINT->value,
                            'PermissionTitle' => 'Customer Loyalty Point',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Customer Loyalty Point',
                                'ar' => 'نقطة ولاء العملاء'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                            'PermissionTitle' => 'Subscribe Mail List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Subscribe Mail List',
                                'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::CUSTOMER_CONTACT_MESSAGES->value,
                            'PermissionTitle' => 'Contact Messages',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Contact Messages',
                                'ar' => 'رسائل الاتصال'
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
                [
                    'PermissionName' => 'Financial-Dashboard',
                    'PermissionTitle' => 'Financial Dashboard',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Financial Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],
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
                            'PermissionName' => PermissionKey::FINANCIAL_WITHDRAW_REQUESTS->value,
                            'PermissionTitle' => 'Withdraw Requests',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdraw Requests',
                                'ar' => 'طلبات السحب'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_STORE_DISBURSEMENT->value,
                            'PermissionTitle' => 'Store Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Disbursement',
                                'ar' => 'صرف المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value,
                            'PermissionTitle' => 'Delivery Man Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man Disbursement',
                                'ar' => 'صرف رواتب موظف التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_COLLECT_CASH->value,
                            'PermissionTitle' => 'Collect Cash',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Collect Cash',
                                'ar' => 'جمع النقود'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_DELIVERY_MAN_PAYMENTS->value,
                            'PermissionTitle' => 'Delivery Man Payments',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man Payments',
                                'ar' => 'مدفوعات توصيل الطلبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::FINANCIAL_WITHDRAW_METHOD->value,
                            'PermissionTitle' => 'Withdrawal Method',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdrawal Method',
                                'ar' => 'طريقة السحب'
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
                            'PermissionName' => PermissionKey::TRANSACTION_REPORT->value,
                            'PermissionTitle' => 'Transaction Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Transaction Report',
                                'ar' => 'تقرير المعاملات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ITEM_REPORT->value,
                            'PermissionTitle' => 'Item Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Item Report',
                                'ar' => 'تقرير العنصر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::STORE_WISE_REPORT->value,
                            'PermissionTitle' => 'Store-wise Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store-wise Report',
                                'ar' => 'تقرير حسب المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::EXPENSE_REPORT->value,
                            'PermissionTitle' => 'Expense Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Expense Report',
                                'ar' => 'تقرير المصروفات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::DISBURSEMENT_REPORT->value,
                            'PermissionTitle' => 'Disbursement Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Disbursement Report',
                                'ar' => 'تقرير الصرف'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ORDER_REPORT->value,
                            'PermissionTitle' => 'Order Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Order Report',
                                'ar' => 'تقرير الطلب'
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $admin_settings_related_menu = [
            [
                [
                    'PermissionName' => 'Business-Dashboard',
                    'PermissionTitle' => 'Business Dashboard',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Business Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],
                // Business management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Business management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Business management',
                        'ar' => 'إدارة الأعمال'
                    ],
                    'submenu' => [
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
                                    'PermissionName' => PermissionKey::ADMIN_AREA_LIST->value,
                                    'PermissionTitle' => 'Area List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Area List',
                                        'ar' => 'قائمة المناطق'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_AREA_ADD->value,
                                    'PermissionTitle' => 'Area Add',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Area Add',
                                        'ar' => 'إضافة المنطقة'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::BUSINESS_SETTINGS->value,
                            'PermissionTitle' => 'Business Settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Business Settings',
                                'ar' => 'إعدادات الأعمال'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Subscription management',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Subscription management',
                                'ar' => 'إدارة الاشتراكات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::SUBSCRIPTION_PACKAGE->value,
                                    'PermissionTitle' => 'Subscription Package',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Subscription Package',
                                        'ar' => 'باقة الاشتراك'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SUBSCRIBER_LIST->value,
                                    'PermissionTitle' => 'Subscriber List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Subscriber List',
                                        'ar' => 'قائمة المشتركين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::SUBSCRIPTION_SETTINGS->value,
                                    'PermissionTitle' => 'Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Settings',
                                        'ar' => 'إعدادات'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Pages & social media',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Pages & social media',
                                'ar' => 'الصفحات ووسائل التواصل الاجتماعي'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::MEDIA_SOCIAL_MEDIA->value,
                                    'PermissionTitle' => 'Social Media',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Social Media',
                                        'ar' => 'وسائل التواصل الاجتماعي'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::MEDIA_ADMIN_LANDING_PAGE->value,
                                    'PermissionTitle' => 'Admin landing page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Admin landing page',
                                        'ar' => 'صفحة هبوط المشرف'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::MEDIA_REACT_LANDING_PAGE->value,
                                    'PermissionTitle' => 'React landing page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'React landing page',
                                        'ar' => 'صفحة الهبوط التفاعلية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::MEDIA_FLUTTER_LANDING_PAGE->value,
                                    'PermissionTitle' => 'Flutter landing page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Flutter landing page',
                                        'ar' => 'صفحة الهبوط Flutter'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Business pages',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Business pages',
                                'ar' => 'صفحات الأعمال'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::PAGE_TERMS_AND_CONDITION->value,
                                    'PermissionTitle' => 'Terms and condition',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Terms and condition',
                                        'ar' => 'الشروط والأحكام'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PAGE_PRIVACY_POLICY->value,
                                    'PermissionTitle' => 'Privacy policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Privacy policy',
                                        'ar' => 'سياسة الخصوصية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PAGE_ABOUT_US->value,
                                    'PermissionTitle' => 'About us',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'About us',
                                        'ar' => 'معلومات عنا'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PAGE_REFUND_POLICY->value,
                                    'PermissionTitle' => 'Refund Policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Refund Policy',
                                        'ar' => 'سياسة الاسترداد'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PAGE_CANCELLATION_POLICY->value,
                                    'PermissionTitle' => 'Cancellation Policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cancellation Policy',
                                        'ar' => 'سياسة الإلغاء'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PAGE_SHIPPING_POLICY->value,
                                    'PermissionTitle' => 'Shipping Policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Shipping Policy',
                                        'ar' => 'سياسة الشحن'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::IMAGE_GALLERY->value,
                            'PermissionTitle' => 'Gallery',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Gallery',
                                'ar' => 'معرض الصور'
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
