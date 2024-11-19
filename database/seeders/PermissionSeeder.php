<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\MenuGroup;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
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
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'All',
                            'ar' => 'الجميع'
                        ]
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
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Area List',
                            'ar' => 'قائمة المناطق'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_ADD->value,
                        'PermissionTitle' => 'Area Add',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Area Add',
                            'ar' => 'إضافة المنطقة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_AREA_UPDATE->value,
                        'PermissionTitle' => 'Area Update',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Area Update',
                            'ar' => 'تحديث المنطقة'
                        ]
                    ]

                ]
            ],
            [
                'module' => MenuGroup::STORES->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::STORES->value),
                'permissions' => [

                    [
                        'PermissionName' => Permission::ADMIN_STORE_ADD->value,
                        'PermissionTitle' => 'Store Add',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Store Add',
                            'ar' => 'إضافة متجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ADMIN_STORE_LIST->value,
                        'PermissionTitle' => 'Store List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Store List',
                            'ar' => 'قائمة المتاجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_RECOMMENDED->value,
                        'PermissionTitle' => 'Recommended Store',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Recommended Store',
                            'ar' => 'المتجر الموصى به'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_APPROVAL->value,
                        'PermissionTitle' => 'Pending Approval/ Rejected',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Pending Approval/ Rejected',
                            'ar' => 'في انتظار الموافقة/الرفض'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_ADD_UPDATE->value,
                        'PermissionTitle' => 'Store Add/Update',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Store Add/Update',
                            'ar' => 'إضافة/تحديث المتجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::POS_SALES->value,
                        'PermissionTitle' => 'Pos Sales',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Pos Sales',
                            'ar' => 'نقاط البيع'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::POS_SETTINGS_ADMIN->value,
                        'PermissionTitle' => 'Pos Settings',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Pos Settings',
                            'ar' => 'إعدادات الموضع'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::POS_SETTINGS_STORE->value,
                        'PermissionTitle' => 'Pos Settings',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Pos Settings',
                            'ar' => 'إعدادات الموضع'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_ATTRIBUTE->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_ATTRIBUTE->value),
                'permissions' => [
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
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_EDIT->value,
                        'PermissionTitle' => 'Edit Attribute',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Edit Attribute',
                            'ar' => 'تعديل السمة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_DELETE->value,
                        'PermissionTitle' => 'Delete Attribute',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Delete Attribute',
                            'ar' => 'حذف السمة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ATTRIBUTE_LIST_STORE->value,
                        'PermissionTitle' => 'Attributes',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Attributes',
                            'ar' => 'صفات'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_WARRANTY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_WARRANTY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_LIST->value,
                        'PermissionTitle' => 'Warranty List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Warranty List',
                            'ar' => 'قائمة الضمان'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_ADD->value,
                        'PermissionTitle' => 'Add Warranty',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Warranty',
                            'ar' => 'إضافة الضمان'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_EDIT->value,
                        'PermissionTitle' => 'Edit Warranty',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Edit Warranty',
                            'ar' => 'تعديل الضمان'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_WARRANTY_LIST_STORE->value,
                        'PermissionTitle' => 'Warranty',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Warranty',
                            'ar' => 'ضمان'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_BRAND->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_BRAND->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_LIST->value,
                        'PermissionTitle' => 'Product Brand List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Product Brand List',
                            'ar' => 'قائمة العلامات التجارية للمنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_ADD->value,
                        'PermissionTitle' => 'Add Product Brand',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Product Brand',
                            'ar' => 'إضافة العلامة التجارية للمنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_EDIT->value,
                        'PermissionTitle' => 'Edit Product Brand',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Edit Product Brand',
                            'ar' => 'تعديل العلامة التجارية للمنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_STATUS->value,
                        'PermissionTitle' => 'Change Brand Status',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Change Brand Status',
                            'ar' => 'تغيير حالة العلامة التجارية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_LIST_STORE->value,
                        'PermissionTitle' => 'Brand/Manufacturers/Publications',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Brand/Manufacturers/Publications',
                            'ar' => 'العلامة التجارية/الشركات المصنعة/المنشورات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_BRAND_REQUESTED_FROM_STORE->value,
                        'PermissionTitle' => 'Approve Brand Request From Store',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Approve Brand Request From Store',
                            'ar' => 'الموافقة على طلب العلامة التجارية من المتجر'
                        ]
                    ]

                ]
            ],
            [
                'module' => MenuGroup::BOOK_AUTHORS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::BOOK_AUTHORS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_LIST->value,
                        'PermissionTitle' => 'Author\'s List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Author\'s List',
                            'ar' => 'قائمة المؤلفين'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_ADD->value,
                        'PermissionTitle' => 'Add Book Author',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Book Author',
                            'ar' => 'أضف مؤلف الكتاب'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_EDIT->value,
                        'PermissionTitle' => 'Edit Author\'s Name',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Edit Author\'s Name',
                            'ar' => 'تعديل اسم المؤلف'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_DELETE->value,
                        'PermissionTitle' => 'Delete Author\'s Name',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Delete Author\'s Name',
                            'ar' => 'حذف اسم المؤلف'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_LIST_STORE->value,
                        'PermissionTitle' => 'Author\'s List',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Author\'s List',
                            'ar' => 'قائمة المؤلفين'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_AUTHORS_REQUESTED_FROM_STORE->value,
                        'PermissionTitle' => 'Approve Author Enlist Request From Store',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Approve Author Enlist Request From Store',
                            'ar' => 'الموافقة على طلب إدراج المؤلف من المتجر'
                        ]
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
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_CATEGORY_LIST_STORE->value,
                        'PermissionTitle' => 'Category List',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Category List',
                            'ar' => 'قائمة الفئات'
                        ]
                    ]

                ]
            ],
            [
                'module' => MenuGroup::PRODUCT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_LIST->value,
                        'PermissionTitle' => 'Manage Products',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Manage Products',
                            'ar' => 'إدارة المنتجات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_ADD->value,
                        'PermissionTitle' => 'Add New Product',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Add New Product',
                            'ar' => 'إضافة منتج جديد'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_EDIT->value,
                        'PermissionTitle' => 'Edit Product',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Edit Product',
                            'ar' => 'تعديل المنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_DELETE->value,
                        'PermissionTitle' => 'Delete Product',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Delete Product',
                            'ar' => 'حذف المنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_LOW_STOCK->value,
                        'PermissionTitle' => 'All Low-Stock/Out of Stock Product',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'All Low-Stock/Out of Stock Product',
                            'ar' => 'جميع المنتجات منخفضة المخزون/غير متوفرة بالمخزون'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_TEMPLATE->value,
                        'PermissionTitle' => 'Product Template',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Product Template',
                            'ar' => 'قالب المنتج'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_IMPORT->value,
                        'PermissionTitle' => 'Bulk Import',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Bulk Import',
                            'ar' => 'الاستيراد بالجملة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_PRODUCT_BULK_EXPORT->value,
                        'PermissionTitle' => 'Bulk Export',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Bulk Export',
                            'ar' => 'التصدير بالجملة'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_ADDONS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_ADDONS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_LIST->value,
                        'PermissionTitle' => 'Manage addons',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Manage addons',
                            'ar' => 'إدارة الإضافات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_ADD->value,
                        'PermissionTitle' => 'Add New addon',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Add New addon',
                            'ar' => 'إضافة وظيفة إضافية جديدة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_EDIT->value,
                        'PermissionTitle' => 'Edit addon',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Edit addon',
                            'ar' => 'تعديل الوظيفة الإضافية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_ADDONS_DELETE->value,
                        'PermissionTitle' => 'Delete addon',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Delete addon',
                            'ar' => 'حذف الوظيفة الإضافية'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PRODUCT_FAB_COMB->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PRODUCT_FAB_COMB->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_LIST->value,
                        'PermissionTitle' => 'Manage Combinations',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Manage Combinations',
                            'ar' => 'إدارة التركيبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_ADD->value,
                        'PermissionTitle' => 'Add Combinations',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Add Combinations',
                            'ar' => 'إضافة مجموعات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_EDIT->value,
                        'PermissionTitle' => 'Edit Combinations',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Edit Combinations',
                            'ar' => 'تحرير التركيبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PRODUCT_FAB_COMB_DELETE->value,
                        'PermissionTitle' => 'Delete Combinations',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Delete Combinations',
                            'ar' => 'حذف التركيبات'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::ORDER_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::ORDER_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::ORDERS_ALL->value,
                        'PermissionTitle' => 'All Orders',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'All Orders',
                            'ar' => 'جميع الطلبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_PENDING->value,
                        'PermissionTitle' => 'Pending',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Pending',
                            'ar' => 'قيد الانتظار'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_CONFIRMED->value,
                        'PermissionTitle' => 'Confirmed',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Confirmed',
                            'ar' => 'مؤكد'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_SCHEDULED->value,
                        'PermissionTitle' => 'Scheduled',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Scheduled',
                            'ar' => 'مجدولة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_COOKING->value,
                        'PermissionTitle' => 'Cooking (For Restaurant)',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Cooking',
                            'ar' => 'طبخ'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_READY_FOR_DELIVERY->value,
                        'PermissionTitle' => 'Ready For Delivery',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Ready For Delivery',
                            'ar' => 'جاهز للتسليم'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_PRODUCT_ON_THE_WAY->value,
                        'PermissionTitle' => 'Item On The Way',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Item On The Way',
                            'ar' => 'البند في الطريق'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_DELIVERED->value,
                        'PermissionTitle' => 'Delivered',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Delivered',
                            'ar' => 'تم التوصيل'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_FITTING_SCHEDULE->value,
                        'PermissionTitle' => 'Fitting Schedule Done(Furniture)',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Fitting Schedule Done',
                            'ar' => 'تم الانتهاء من جدول التجهيز'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDERS_RETURNED_OR_REFUND->value,
                        'PermissionTitle' => 'Returned or Refunded',
                        'activity_scope' => 'common',
                        'translations' => [
                            'en' => 'Returned or Refunded',
                            'ar' => 'تم إرجاعه أو استرداده'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FINANCIAL_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FINANCIAL_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FINANCIAL_TRANSACTIONS->value,
                        'PermissionTitle' => 'Transactions',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Transactions',
                            'ar' => 'المعاملات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAWLS->value,
                        'PermissionTitle' => 'Withdrawals',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Withdrawals',
                            'ar' => 'السحوبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_MYINCOME->value,
                        'PermissionTitle' => 'My Income',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'My Income',
                            'ar' => 'دخلي'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FEEDBACK_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FEEDBACK_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FEEDBACK_REVIEWS->value,
                        'PermissionTitle' => 'Reviews',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Reviews',
                            'ar' => 'المراجعات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FEEDBACK_QUESTIONS->value,
                        'PermissionTitle' => 'Questions/Chat',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Questions/Chat',
                            'ar' => 'الأسئلة/الدردشة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FEEDBACK_QUERIES->value,
                        'PermissionTitle' => 'Product Queries',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Product Queries',
                            'ar' => 'استعلامات المنتج'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::DELIVERYMAN_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::DELIVERYMAN_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::DELIVERY_VEHICLE_CATEGORY->value,
                        'PermissionTitle' => 'Vehicles category',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Vehicles category',
                            'ar' => 'فئة المركبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSON_ADD->value,
                        'PermissionTitle' => 'Add Delivery Man',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Delivery Man',
                            'ar' => 'إضافة رجل التوصيل'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSON_LIST->value,
                        'PermissionTitle' => 'Delivery Man List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Delivery Man List',
                            'ar' => 'قائمة رجال التوصيل'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::DELIVERY_PERSONS_REVIEW->value,
                        'PermissionTitle' => 'Reviews',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Reviews',
                            'ar' => 'المراجعات'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::CUSTOMER_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::CUSTOMER_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::CUSTOMER_LIST->value,
                        'PermissionTitle' => 'Customers',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Customers',
                            'ar' => 'عملاء'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_ADD_FUND->value,
                        'PermissionTitle' => 'Add Fund',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Fund',
                            'ar' => 'إضافة صندوق'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_REPORT->value,
                        'PermissionTitle' => 'Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Report',
                            'ar' => 'تقرير'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_WALLET_BONUS->value,
                        'PermissionTitle' => 'Bonus',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Bonus',
                            'ar' => 'علاوة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_LOYALTY_POINT->value,
                        'PermissionTitle' => 'Customer Loyalty Point',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Customer Loyalty Point',
                            'ar' => 'نقطة ولاء العملاء'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                        'PermissionTitle' => 'Subscribe Mail List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Subscribe Mail List',
                            'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::CUSTOMER_CONTACT_MESSAGES->value,
                        'PermissionTitle' => 'Contact Messages',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Contact Messages',
                            'ar' => 'رسائل الاتصال'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::PROMOTION_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::PROMOTION_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FLASH_SALES_ALL_CAMPAIGNS->value,
                        'PermissionTitle' => 'Flash Sales List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Flash Sales List',
                            'ar' => 'قائمة المبيعات الفورية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_ADD_CAMPAIGN_ADMIN->value,
                        'PermissionTitle' => 'Add Flash Sales',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add Flash Sales',
                            'ar' => 'إضافة مبيعات فلاشية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_APPROVE_CAMPAIGN->value,
                        'PermissionTitle' => 'Flash Sales Request Approve',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Flash Sales Request Approve',
                            'ar' => 'الموافقة على طلب مبيعات الفلاش'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_JOIN->value,
                        'PermissionTitle' => 'Available flash deals',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Available flash deals',
                            'ar' => 'عروض فلاش متاحة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FLASH_SALES_ADD_CAMPAIGN_STORE->value,
                        'PermissionTitle' => 'Add Flash Sales',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Add Flash Sales',
                            'ar' => 'إضافة مبيعات فلاشية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_COUPONS->value,
                        'PermissionTitle' => 'Coupons',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Coupons',
                            'ar' => 'كوبونات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_BANNERS->value,
                        'PermissionTitle' => 'Banners',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Banners',
                            'ar' => 'لافتات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_DEALS_AVAILABLE->value,
                        'PermissionTitle' => 'Available flash deals',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Available flash deals',
                            'ar' => 'عروض فلاش متاحة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_MY_PRODUCT_IN_DEALS->value,
                        'PermissionTitle' => 'My products in deals',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'My products in deals',
                            'ar' => 'منتجاتي في العروض'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_ASK_FOR_ENROLL->value,
                        'PermissionTitle' => 'Ask for enrollment',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Ask for enrollment',
                            'ar' => 'اطلب التسجيل'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PROMOTION_BANNERS->value,
                        'PermissionTitle' => 'Banners',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Banners',
                            'ar' => 'لافتات'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::STORE_SETTINGS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::STORE_SETTINGS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::STORE_STORE_NOTICE->value,
                        'PermissionTitle' => 'Store Notice',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Store Notice',
                            'ar' => 'إشعار المتجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_MESSAGE->value,
                        'PermissionTitle' => 'Message',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Message',
                            'ar' => 'رسالة'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_STORE_CONFIG->value,
                        'PermissionTitle' => 'Store Config',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Store Config',
                            'ar' => 'تكوين المتجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_MY_SHOP->value,
                        'PermissionTitle' => 'My Stores',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'My Stores',
                            'ar' => 'متاجري'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_BUSINESS_PLAN->value,
                        'PermissionTitle' => 'My Business Plan',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'My Business Plan',
                            'ar' => 'خطة عملي'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_WALLET->value,
                        'PermissionTitle' => 'My Wallet',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'My Wallet',
                            'ar' => 'محفظتي'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_DISBURSE_METHOD->value,
                        'PermissionTitle' => 'Disbursement Method',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'Disbursement Method',
                            'ar' => 'طريقة الصرف'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_POS_CONFIG->value,
                        'PermissionTitle' => 'POS Configuration',
                        'activity_scope' => 'store_level',
                        'translations' => [
                            'en' => 'POS Configuration',
                            'ar' => 'تكوين نقاط البيع'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::FINANCIAL_ACTIVITY->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::FINANCIAL_ACTIVITY->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAW_REQUESTS->value,
                        'PermissionTitle' => 'Withdraw Requests',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Withdraw Requests',
                            'ar' => 'طلبات السحب'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_STORE_DISBURSEMENT->value,
                        'PermissionTitle' => 'Store Disbursement',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Store Disbursement',
                            'ar' => 'صرف المتجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_DISBURSEMENT->value,
                        'PermissionTitle' => 'Delivery Man Disbursement',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Delivery Man Disbursement',
                            'ar' => 'صرف رواتب موظف التوصيل'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_COLLECT_CASH->value,
                        'PermissionTitle' => 'Collect Cash',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Collect Cash',
                            'ar' => 'جمع النقود'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_DELIVERY_MAN_PAYMENTS->value,
                        'PermissionTitle' => 'Delivery Man Payments',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Delivery Man Payments',
                            'ar' => 'مدفوعات توصيل الطلبات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FINANCIAL_WITHDRAW_METHOD->value,
                        'PermissionTitle' => 'Withdrawal Method',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Withdrawal Method',
                            'ar' => 'طريقة السحب'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::REPORTS_ANALYTICS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::REPORTS_ANALYTICS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::TRANSACTION_REPORT->value,
                        'PermissionTitle' => 'Transaction Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Transaction Report',
                            'ar' => 'تقرير المعاملات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ITEM_REPORT->value,
                        'PermissionTitle' => 'Item Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Item Report',
                            'ar' => 'تقرير العنصر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::STORE_WISE_REPORT->value,
                        'PermissionTitle' => 'Store-wise Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Store-wise Report',
                            'ar' => 'تقرير حسب المتجر'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::EXPENSE_REPORT->value,
                        'PermissionTitle' => 'Expense Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Expense Report',
                            'ar' => 'تقرير المصروفات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::DISBURSEMENT_REPORT->value,
                        'PermissionTitle' => 'Disbursement Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Disbursement Report',
                            'ar' => 'تقرير الصرف'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::ORDER_REPORT->value,
                        'PermissionTitle' => 'Order Report',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Order Report',
                            'ar' => 'تقرير الطلب'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::BUSINESS_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::BUSINESS_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::BUSINESS_SETTINGS->value,
                        'PermissionTitle' => 'Business Settings',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Business Settings',
                            'ar' => 'إعدادات الأعمال'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIPTION_PACKAGE->value,
                        'PermissionTitle' => 'Subscription Package',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Subscription Package',
                            'ar' => 'باقة الاشتراك'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIBER_LIST->value,
                        'PermissionTitle' => 'Subscriber List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Subscriber List',
                            'ar' => 'قائمة المشتركين'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::SUBSCRIPTION_SETTINGS->value,
                        'PermissionTitle' => 'Settings',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Settings',
                            'ar' => 'إعدادات'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_SOCIAL_MEDIA->value,
                        'PermissionTitle' => 'Social Media',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Social Media',
                            'ar' => 'وسائل التواصل الاجتماعي'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_ADMIN_LANDING_PAGE->value,
                        'PermissionTitle' => 'Admin landing page',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Admin landing page',
                            'ar' => 'صفحة هبوط المشرف'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_REACT_LANDING_PAGE->value,
                        'PermissionTitle' => 'React landing page',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'React landing page',
                            'ar' => 'صفحة الهبوط التفاعلية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::MEDIA_FLUTTER_LANDING_PAGE->value,
                        'PermissionTitle' => 'Flutter landing page',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Flutter landing page',
                            'ar' => 'صفحة الهبوط Flutter'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_TERMS_AND_CONDITION->value,
                        'PermissionTitle' => 'Terms and condition',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Terms and condition',
                            'ar' => 'الشروط والأحكام'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_PRIVACY_POLICY->value,
                        'PermissionTitle' => 'Privacy policy',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Privacy policy',
                            'ar' => 'سياسة الخصوصية'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_ABOUT_US->value,
                        'PermissionTitle' => 'About us',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'About us',
                            'ar' => 'معلومات عنا'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_REFUND_POLICY->value,
                        'PermissionTitle' => 'Refund Policy',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Refund Policy',
                            'ar' => 'سياسة الاسترداد'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_CANCELLATION_POLICY->value,
                        'PermissionTitle' => 'Cancellation Policy',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Cancellation Policy',
                            'ar' => 'سياسة الإلغاء'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::PAGE_SHIPPING_POLICY->value,
                        'PermissionTitle' => 'Shipping Policy',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Shipping Policy',
                            'ar' => 'سياسة الشحن'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::IMAGE_GALLERY->value,
                        'PermissionTitle' => 'Gallery',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Gallery',
                            'ar' => 'معرض الصور'
                        ]
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
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Ban User',
                            'ar' => 'حظر المستخدم'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::USERS_ACTIVE->value,
                        'PermissionTitle' => 'Active User',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Active User',
                            'ar' => 'المستخدم النشط'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::USERS_ROLES_STORE->value,
                        'PermissionTitle' => 'Staff Roles',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Staff Roles',
                            'ar' => 'أدوار الموظفين'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::USERS_STAFF_ADD_STORE->value,
                        'PermissionTitle' => 'Add New',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Add New',
                            'ar' => 'إضافة جديد'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::USERS_STAFF_LIST_STORE->value,
                        'PermissionTitle' => 'List',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'List',
                            'ar' => 'قائمة'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::SYSTEM_MANAGEMENT->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::SYSTEM_MANAGEMENT->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::THIRD_PARTY->value,
                        'PermissionTitle' => '3rd party',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => '3rd party',
                            'ar' => 'الطرف الثالث'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::FIREBASE_NOTIFICATION->value,
                        'PermissionTitle' => 'Firebase notification',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Firebase notification',
                            'ar' => 'إشعار Firebase'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::OFFLINE_PAYMENT_SETUP->value,
                        'PermissionTitle' => 'Offline Payment Setup',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Offline Payment Setup',
                            'ar' => 'إعداد الدفع دون اتصال بالإنترنت'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::LOGIN_SETUP->value,
                        'PermissionTitle' => 'Login setup',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Login setup',
                            'ar' => 'إعداد تسجيل الدخول'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::REACT_SITE->value,
                        'PermissionTitle' => 'React site',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'React site',
                            'ar' => 'موقع ريآكت'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::EMAIL_TEMPLATE->value,
                        'PermissionTitle' => 'Email template',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Email template',
                            'ar' => 'قالب البريد الإلكتروني'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::APP_SETTINGS->value,
                        'PermissionTitle' => 'App settings',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'App settings',
                            'ar' => 'إعدادات التطبيق'
                        ]
                    ],
                    [
                        'PermissionName' => Permission::NOTIFICATION_CHANNELS->value,
                        'PermissionTitle' => 'Notification Channels',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Notification Channels',
                            'ar' => 'قنوات الإشعارات'
                        ]
                    ]
                ]
            ],
            [
                'module' => MenuGroup::OTHERS->value,
                'module_tile' => MenuGroup::moduleTitle(MenuGroup::OTHERS->value),
                'permissions' => [
                    [
                        'PermissionName' => Permission::MANAGE_CONFIGURATIONS->value,
                        'PermissionTitle' => 'Manage Configuration',
                        'activity_scope' => 'system_level',
                        'translations' => [
                            'en' => 'Manage Configuration',
                            'ar' => 'إدارة التكوين'
                        ]
                    ]
                ]
            ]
        ];


        foreach ($page_list as $x_mod) {
            foreach ($x_mod['permissions'] as $x_page) {
                $translations = [];
                $permission = ModelsPermission::updateOrCreate(
                    [
                        'name' => $x_page['PermissionName'],
                        'perm_title' => $x_page['PermissionTitle'],
                        'guard_name' => 'api',
                        'module' => $x_mod['module'],
                        'module_title' => $x_mod['module_tile'],
                        'available_for' => $x_page['activity_scope']
                    ]
                );
                foreach ($x_page['translations'] as $key => $value) {
                    $translations[] = [
                        'translatable_type' => 'App\Models\Permissions',
                        'translatable_id' => $permission->id,
                        'language' => $key,
                        'key' => 'perm_title',
                        'value' => $value,
                    ];
                }
                Translation::insert($translations);
            }
        }
    }
}
