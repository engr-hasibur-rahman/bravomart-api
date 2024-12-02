<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Create Admin Menu d
     *
     * @return void
     */
    public function run()
    {
        $admin_main_menu = [
            [
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
                            'PermissionName' => Permission::POS_SALES->value,
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
                            'PermissionName' => Permission::POS_SETTINGS_ADMIN->value,
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
                                    'PermissionName' => Permission::ORDERS_ALL->value,
                                    'PermissionTitle' => 'All Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PENDING->value,
                                    'PermissionTitle' => 'Pending',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Pending',
                                        'ar' => 'قيد الانتظار'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_CONFIRMED->value,
                                    'PermissionTitle' => 'Confirmed',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Confirmed',
                                        'ar' => 'مؤكد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_SCHEDULED->value,
                                    'PermissionTitle' => 'Scheduled',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Scheduled',
                                        'ar' => 'مجدولة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_COOKING->value,
                                    'PermissionTitle' => 'Cooking (For Restaurant)',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cooking',
                                        'ar' => 'طبخ'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_READY_FOR_DELIVERY->value,
                                    'PermissionTitle' => 'Ready For Delivery',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Ready For Delivery',
                                        'ar' => 'جاهز للتسليم'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_PRODUCT_ON_THE_WAY->value,
                                    'PermissionTitle' => 'Item On The Way',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Item On The Way',
                                        'ar' => 'البند في الطريق'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_DELIVERED->value,
                                    'PermissionTitle' => 'Delivered',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Delivered',
                                        'ar' => 'تم التوصيل'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_FITTING_SCHEDULE->value,
                                    'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Fitting Schedule Done',
                                        'ar' => 'تم الانتهاء من جدول التجهيز'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
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
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LIST->value,
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
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
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
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_LOW_STOCK->value,
                                    'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'All Low-Stock/Out of Stock Product',
                                        'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_APPROVAL_REQ->value,
                                    'PermissionTitle' => 'Product Approval Request',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Approval Request',
                                        'ar' => 'طلب الموافقة على المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_TEMPLATE->value,
                                    'PermissionTitle' => 'Product Template',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Product Template',
                                        'ar' => 'قالب المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_EXPORT->value,
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
                            'PermissionName' => Permission::PRODUCT_INVENTORY->value,
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
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_LIST->value,
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
                                    'PermissionName' => Permission::PRODUCT_CATEGORY_ADD->value,
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
                                    'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST->value,
                                    'PermissionTitle' => 'Attribute List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Attribute List',
                                        'ar' => 'قائمة السمات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_ATTRIBUTE_ADD->value,
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
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Brand/Manufacturers/Publications',
                            'activity_scope' => 'system_level',
                            'icon' => 'VectorIcon',
                            'translations' => [
                                'en' => 'Brand/Manufacturers/Publications',
                                'ar' => 'العلامة التجارية/الشركات المصنعة/المنشورات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::PRODUCT_BRAND_LIST->value,
                                    'PermissionTitle' => 'Brand List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete'],
                                    'translations' => [
                                        'en' => 'Brand List',
                                        'ar' => 'قائمة العلامات التجارية للمنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_BRAND_ADD->value,
                                    'PermissionTitle' => 'Add Product Brand',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert'],
                                    'translations' => [
                                        'en' => 'Add Product Brand',
                                        'ar' => 'إضافة العلامة التجارية للمنتج'
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
                                    'PermissionName' => Permission::PRODUCT_WARRANTY_LIST->value,
                                    'PermissionTitle' => 'Warranty List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Warranty List',
                                        'ar' => 'قائمة الضمان'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_WARRANTY_ADD->value,
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
                                    'PermissionName' => Permission::PRODUCT_TAG_LIST->value,
                                    'PermissionTitle' => 'Tag List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Tag List',
                                        'ar' => 'قائمة العلامات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_TAG_ADD->value,
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
                                    'PermissionName' => Permission::PRODUCT_AUTHORS_LIST->value,
                                    'PermissionTitle' => 'Author\'s List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Author\'s List',
                                        'ar' => 'قائمة المؤلفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_AUTHORS_ADD->value,
                                    'PermissionTitle' => 'Add Book Author',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Book Author',
                                        'ar' => 'أضف مؤلف الكتاب'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_AUTHORS_REQUESTED_FROM_STORE->value,
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
                                    'PermissionName' => Permission::PRODUCT_ADDONS_LIST->value,
                                    'PermissionTitle' => 'Manage addons',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Manage addons',
                                        'ar' => 'إدارة الإضافات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_ADDONS_ADD->value,
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
                                    'PermissionName' => Permission::PRODUCT_FAB_COMB_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'إدارة التركيبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PRODUCT_FAB_COMB_ADD->value,
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
                            'PermissionName' => Permission::STORE_APPROVAL->value,
                            'PermissionTitle' => 'Pending Approval/ Rejected',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Pending Approval/ Rejected',
                                'ar' => 'في انتظار الموافقة/الرفض'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::ADMIN_STORE_LIST->value,
                            'PermissionTitle' => 'Store List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store List',
                                'ar' => 'قائمة المتاجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::ADMIN_STORE_ADD->value,
                            'PermissionTitle' => 'Store Add',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Add',
                                'ar' => 'إضافة متجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_RECOMMENDED->value,
                            'PermissionTitle' => 'Recommended Store',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Recommended Store',
                                'ar' => 'المتجر الموصى به'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_STORE_ADD_UPDATE->value,
                            'PermissionTitle' => 'Store Add/Update',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Add/Update',
                                'ar' => 'إضافة/تحديث المتجر'
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
                            'PermissionName' => Permission::DELIVERY_VEHICLE_CATEGORY->value,
                            'PermissionTitle' => 'Vehicles category',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Vehicles category',
                                'ar' => 'فئة المركبات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::DELIVERY_PERSON_ADD->value,
                            'PermissionTitle' => 'Add Delivery Man',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Add Delivery Man',
                                'ar' => 'إضافة رجل التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::DELIVERY_PERSON_LIST->value,
                            'PermissionTitle' => 'Delivery Man List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man List',
                                'ar' => 'قائمة رجال التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::DELIVERY_PERSONS_REVIEW->value,
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
                            'PermissionName' => Permission::CUSTOMER_LIST->value,
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
                                    'PermissionName' => Permission::CUSTOMER_WALLET_ADD_FUND->value,
                                    'PermissionTitle' => 'Add Fund',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Add Fund',
                                        'ar' => 'إضافة صندوق'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::CUSTOMER_WALLET_REPORT->value,
                                    'PermissionTitle' => 'Report',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Report',
                                        'ar' => 'تقرير'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::CUSTOMER_WALLET_BONUS->value,
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
                            'PermissionName' => Permission::CUSTOMER_LOYALTY_POINT->value,
                            'PermissionTitle' => 'Customer Loyalty Point',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Customer Loyalty Point',
                                'ar' => 'نقطة ولاء العملاء'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                            'PermissionTitle' => 'Subscribe Mail List',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Subscribe Mail List',
                                'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::CUSTOMER_CONTACT_MESSAGES->value,
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
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Employee Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
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
                                    'PermissionName' => Permission::USERS_ROLE_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'علاوة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::USERS_ROLE_ADD->value,
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
                                    'PermissionName' => Permission::USERS_LIST_ADMIN->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'علاوة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::USERS_ADD_ADMIN->value,
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
                ]
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
                            'PermissionName' => Permission::FINANCIAL_WITHDRAW_REQUESTS->value,
                            'PermissionTitle' => 'Withdraw Requests',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Withdraw Requests',
                                'ar' => 'طلبات السحب'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_STORE_DISBURSEMENT->value,
                            'PermissionTitle' => 'Store Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store Disbursement',
                                'ar' => 'صرف المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value,
                            'PermissionTitle' => 'Delivery Man Disbursement',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man Disbursement',
                                'ar' => 'صرف رواتب موظف التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_COLLECT_CASH->value,
                            'PermissionTitle' => 'Collect Cash',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Collect Cash',
                                'ar' => 'جمع النقود'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_PAYMENTS->value,
                            'PermissionTitle' => 'Delivery Man Payments',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Delivery Man Payments',
                                'ar' => 'مدفوعات توصيل الطلبات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::FINANCIAL_WITHDRAW_METHOD->value,
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
                            'PermissionName' => Permission::TRANSACTION_REPORT->value,
                            'PermissionTitle' => 'Transaction Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Transaction Report',
                                'ar' => 'تقرير المعاملات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::ITEM_REPORT->value,
                            'PermissionTitle' => 'Item Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Item Report',
                                'ar' => 'تقرير العنصر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::STORE_WISE_REPORT->value,
                            'PermissionTitle' => 'Store-wise Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Store-wise Report',
                                'ar' => 'تقرير حسب المتجر'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::EXPENSE_REPORT->value,
                            'PermissionTitle' => 'Expense Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Expense Report',
                                'ar' => 'تقرير المصروفات'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::DISBURSEMENT_REPORT->value,
                            'PermissionTitle' => 'Disbursement Report',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Disbursement Report',
                                'ar' => 'تقرير الصرف'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::ORDER_REPORT->value,
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
                                    'PermissionName' => Permission::ADMIN_AREA_LIST->value,
                                    'PermissionTitle' => 'Area List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Area List',
                                        'ar' => 'قائمة المناطق'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ADMIN_AREA_ADD->value,
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
                            'PermissionName' => Permission::BUSINESS_SETTINGS->value,
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
                                    'PermissionName' => Permission::SUBSCRIPTION_PACKAGE->value,
                                    'PermissionTitle' => 'Subscription Package',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Subscription Package',
                                        'ar' => 'باقة الاشتراك'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::SUBSCRIBER_LIST->value,
                                    'PermissionTitle' => 'Subscriber List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Subscriber List',
                                        'ar' => 'قائمة المشتركين'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::SUBSCRIPTION_SETTINGS->value,
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
                                    'PermissionName' => Permission::MEDIA_SOCIAL_MEDIA->value,
                                    'PermissionTitle' => 'Social Media',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Social Media',
                                        'ar' => 'وسائل التواصل الاجتماعي'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::MEDIA_ADMIN_LANDING_PAGE->value,
                                    'PermissionTitle' => 'Admin landing page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Admin landing page',
                                        'ar' => 'صفحة هبوط المشرف'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::MEDIA_REACT_LANDING_PAGE->value,
                                    'PermissionTitle' => 'React landing page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'React landing page',
                                        'ar' => 'صفحة الهبوط التفاعلية'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::MEDIA_FLUTTER_LANDING_PAGE->value,
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
                                    'PermissionName' => Permission::PAGE_TERMS_AND_CONDITION->value,
                                    'PermissionTitle' => 'Terms and condition',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Terms and condition',
                                        'ar' => 'الشروط والأحكام'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PAGE_PRIVACY_POLICY->value,
                                    'PermissionTitle' => 'Privacy policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Privacy policy',
                                        'ar' => 'سياسة الخصوصية'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PAGE_ABOUT_US->value,
                                    'PermissionTitle' => 'About us',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'About us',
                                        'ar' => 'معلومات عنا'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PAGE_REFUND_POLICY->value,
                                    'PermissionTitle' => 'Refund Policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Refund Policy',
                                        'ar' => 'سياسة الاسترداد'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PAGE_CANCELLATION_POLICY->value,
                                    'PermissionTitle' => 'Cancellation Policy',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Cancellation Policy',
                                        'ar' => 'سياسة الإلغاء'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::PAGE_SHIPPING_POLICY->value,
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
                            'PermissionName' => Permission::IMAGE_GALLERY->value,
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
                            'PermissionName' => '',
                            'PermissionTitle' => '3rd party & configurations',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view'],
                            'translations' => [
                                'en' => '3rd party & configurations',
                                'ar' => 'الطرف الثالث والتكوينات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => Permission::THIRD_PARTY->value,
                                    'PermissionTitle' => '3rd party',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => '3rd party',
                                        'ar' => 'الطرف الثالث'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::FIREBASE_NOTIFICATION->value,
                                    'PermissionTitle' => 'Firebase notification',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Firebase notification',
                                        'ar' => 'إشعار Firebase'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::OFFLINE_PAYMENT_SETUP->value,
                                    'PermissionTitle' => 'Offline Payment Setup',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Offline Payment Setup',
                                        'ar' => 'إعداد الدفع دون اتصال بالإنترنت'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => Permission::LOGIN_SETUP->value,
                            'PermissionTitle' => 'Login setup',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Login setup',
                                'ar' => 'إعداد تسجيل الدخول'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::REACT_SITE->value,
                            'PermissionTitle' => 'React site',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'React site',
                                'ar' => 'موقع ريآكت'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::EMAIL_TEMPLATE->value,
                            'PermissionTitle' => 'Email template',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Email template',
                                'ar' => 'قالب البريد الإلكتروني'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::APP_SETTINGS->value,
                            'PermissionTitle' => 'App settings',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'App settings',
                                'ar' => 'إعدادات التطبيق'
                            ]
                        ],
                        [
                            'PermissionName' => Permission::NOTIFICATION_CHANNELS->value,
                            'PermissionTitle' => 'Notification Channels',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'translations' => [
                                'en' => 'Notification Channels',
                                'ar' => 'قنوات الإشعارات'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $admin_dispatch_related_menu = [
            [
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
                                    'PermissionName' => Permission::UNSIGNED_ORDERS_GROCERY->value,
                                    'PermissionTitle' => 'Unassigned Orders',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Unassigned Orders',
                                        'ar' => 'الطلبات غير المخصصة'
                                    ]
                                ],
                                [
                                    'PermissionName' => Permission::ONGOING_ORDERS_GROCERY->value,
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
