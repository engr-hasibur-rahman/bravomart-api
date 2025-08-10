<?php

namespace Database\Seeders;

use App\Enums\PermissionKey;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;

class PermissionAdminSeeder extends Seeder
{
    /**
     * Create Admin Menu Automatically
     *
     * @return void
     */


    public function run()
    {
        $permissionIds = DB::table('permissions')
            ->where('available_for', 'system_level')
            ->pluck('id')
            ->toArray();

        if (!empty($permissionIds)) {
            // Delete permissions
            DB::table('permissions')->whereIn('id', $permissionIds)->delete();

            // Delete related translations
            DB::table('translations')->whereIn('translatable_id', $permissionIds)
                ->where('translatable_type', 'App\\Models\\Permissions')
                ->delete();
        }
        $admin_main_menu = [
            [
                // Dashboard
                [
                    'PermissionName' => PermissionKey::ADMIN_DASHBOARD->value,
                    'PermissionTitle' => 'Dashboard',
                    'activity_scope' => 'system_level',
                    'icon' => 'LayoutDashboard',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Dashboard',
                        'ar' => 'قائمة المناطق'
                    ]
                ],

                // Orders & Refunds
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Order Management',
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
                            'icon' => 'ListOrdered',
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
                                    'icon' => 'ListOrdered',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'All Orders',
                                        'ar' => 'جميع الطلبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND_REQUEST->value,
                                    'PermissionTitle' => 'Returned or Refunded',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'RotateCcw',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Returned or Refunded',
                                        'ar' => 'تم إرجاعه أو استرداده'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_ORDERS_RETURNED_OR_REFUND_REASON->value,
                                    'PermissionTitle' => 'Refund Reason',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Refund Reason',
                                        'ar' => 'سبب استرداد الأموال'
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
                                    'icon' => 'PackageSearch',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Manage Products',
                                        'ar' => 'إدارة المنتجات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCTS_TRASH_MANAGEMENT->value,
                                    'PermissionTitle' => 'Trash',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Trash',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Trash',
                                        'ar' => 'نفاية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_APPROVAL_REQ->value,
                                    'PermissionTitle' => 'Product Approval Request',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Signature',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Product Approval Request',
                                        'ar' => 'طلب الموافقة على المنتج'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_STOCK_REPORT->value,
                                    'PermissionTitle' => 'Product Low & Out Stock',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Layers',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Product Low & Out Stock',
                                        'ar' => 'المنتجات منخفضة المخزون وغير المتوفرة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_IMPORT->value,
                                    'PermissionTitle' => 'Bulk Import',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'FileUp',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Bulk Import',
                                        'ar' => 'الاستيراد بالجملة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_PRODUCT_BULK_EXPORT->value,
                                    'PermissionTitle' => 'Bulk Export',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Download',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Bulk Export',
                                        'ar' => 'التصدير بالجملة'
                                    ]
                                ],
                                // Product Inventory report
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PRODUCT_INVENTORY->value,
                                    'PermissionTitle' => 'Product Inventory',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'SquareChartGantt',
                                    'options' => ['view'],
                                    'translations' => [
                                        'en' => 'Product Inventory',
                                        'ar' => 'مخزون المنتج'
                                    ]
                                ]
                            ]
                        ],

                        // category manage
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_CATEGORY_LIST->value,
                            'PermissionTitle' => 'Categories',
                            'activity_scope' => 'system_level',
                            'icon' => 'List',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Categories',
                                'ar' => 'قائمة الفئات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PRODUCT_ATTRIBUTE_LIST->value,
                            'PermissionTitle' => 'Attributes',
                            'activity_scope' => 'system_level',
                            'icon' => 'AttributeIcon',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Attributes',
                                'ar' => 'قائمة السمات'
                            ],
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_UNIT_LIST->value,
                            'PermissionTitle' => 'Units',
                            'activity_scope' => 'system_level',
                            'icon' => 'Boxes',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Units',
                                'ar' => 'قائمة السمات'
                            ]
                        ],
                        // Product Brand
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_BRAND_LIST->value,
                            'PermissionTitle' => 'Brands',
                            'activity_scope' => 'system_level',
                            'icon' => 'LayoutList',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Brands',
                                'ar' => 'المنشورات'
                            ],
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_TAG_LIST->value,
                            'PermissionTitle' => 'Tags',
                            'activity_scope' => 'system_level',
                            'icon' => 'Tags',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Tags',
                                'ar' => 'العلامات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_PRODUCT_AUTHORS_MANAGE->value,
                            'PermissionTitle' => 'Authors',
                            'activity_scope' => 'system_level',
                            'icon' => '',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Authors',
                                'ar' => 'قائمة المؤلفين'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Coupon Management',
                            'activity_scope' => 'system_level',
                            'icon' => 'SquarePercent',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Coupon Management',
                                'ar' => 'إدارة التركيبات'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COUPON_MANAGE->value,
                                    'PermissionTitle' => 'Coupons',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Coupons',
                                        'ar' => 'إدارة التركيبات'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_COUPON_LINE_MANAGE->value,
                                    'PermissionTitle' => 'Coupon Lines',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Coupon Lines',
                                        'ar' => 'إضافة مجموعات'
                                    ]
                                ]
                            ],


                        ]
                    ]
                ],

                //Seller & Store
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Sellers & Stores',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Sellers & Stores',
                        'ar' => 'البائع والمتجر'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'All Sellers',
                            'activity_scope' => 'system_level',
                            'icon' => 'UsersRound',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'All Sellers',
                                'ar' => 'إدارة العملاء'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SELLER_MANAGEMENT->value,
                                    'PermissionTitle' => 'Sellers',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Sellers',
                                        'ar' => 'عملاء'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SELLER_TRASH_MANAGEMENT->value,
                                    'PermissionTitle' => 'Trash',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Trash',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Trash',
                                        'ar' => 'نفاية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SELLER_REGISTRATION->value,
                                    'PermissionTitle' => 'Register A Seller',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Subscriber List',
                                        'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'All Stores',
                            'activity_scope' => 'system_level',
                            'icon' => 'Store',
                            'translations' => [
                                'en' => 'All Stores',
                                'ar' => ' ميع المتاج'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_STORE_LIST->value,
                                    'PermissionTitle' => 'Store List',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Store',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Store List',
                                        'ar' => 'قائمة المتاجر'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_STORE_TRASH_MANAGEMENT->value,
                                    'PermissionTitle' => 'Trash',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Trash',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Trash',
                                        'ar' => 'نفاية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_STORE_ADD->value,
                                    'PermissionTitle' => 'Store Add',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                            ]
                        ]
                    ]
                ],


                // Promotional control
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Promotional control',
                    'activity_scope' => 'system_level',
                    'icon' => 'Proportions',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Promotional control',
                        'ar' => 'الرقابة الترويجية'
                    ],
                    'submenu' => [
                        // flash sale
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Flash Sale',
                            'activity_scope' => 'system_level',
                            'icon' => 'Zap',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Flash Sale',
                                'ar' => 'بيع سريع'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_MANAGE->value,
                                    'PermissionTitle' => 'All Campaigns',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'منتجاتي في العروض'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_PROMOTIONAL_FLASH_SALE_JOIN_DEALS->value,
                                    'PermissionTitle' => 'Join Campaign Requests',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'delete', 'update', 'others'],
                                    'translations' => [
                                        'en' => 'Join Deals',
                                        'ar' => 'اطلب التسجيل'
                                    ]
                                ],
                            ]
                        ],

                        // Banner Management
                        [
                            'PermissionName' => PermissionKey::ADMIN_PROMOTIONAL_BANNER_MANAGE->value,
                            'PermissionTitle' => 'Banners',
                            'activity_scope' => 'system_level',
                            'icon' => 'AlignJustify',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Banners',
                                'ar' => 'راية'
                            ],
                        ],
                        // Slider
                        [
                            'PermissionName' => PermissionKey::ADMIN_SLIDER_MANAGE_LIST->value,
                            'PermissionTitle' => 'Slider',
                            'activity_scope' => 'system_level',
                            'icon' => 'SlidersHorizontal',
                            'options' => ['view', 'insert', 'update', 'delete'],
                            'translations' => [
                                'en' => 'Slider',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],
                    ]
                ],

                // Feedback  Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Feedback Management',
                    'activity_scope' => 'system_level',
                    'icon' => 'MessageSquareReply',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Feedback Management',
                        'ar' => 'إدارة المدونة'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_FEEDBACK_REVIEWS->value,
                            'PermissionTitle' => 'Reviews',
                            'activity_scope' => 'system_level',
                            'icon' => 'Star',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Reviews',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],

                        [
                            'PermissionName' => PermissionKey::ADMIN_FEEDBACK_QUESTIONS->value,
                            'PermissionTitle' => 'Questions',
                            'activity_scope' => 'system_level',
                            'icon' => 'CircleHelp',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Questions',
                                'ar' => ' قوائم الصفحات'
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
                            'icon' => 'Rss',
                            'translations' => [
                                'en' => 'Blogs',
                                'ar' => ' الموظفين'
                            ],

                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_BLOG_CATEGORY_MANAGE->value,
                                    'PermissionTitle' => 'Category',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Category',
                                        'ar' => ' الموظفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_BLOG_MANAGE->value,
                                    'PermissionTitle' => 'Posts',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Posts',
                                        'ar' => 'دعامات'
                                    ]
                                ]
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
                            'icon' => 'Wallet',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Wallet Lists',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_WALLET_TRANSACTION->value,
                            'PermissionTitle' => 'Transaction History',
                            'activity_scope' => 'system_level',
                            'icon' => 'History',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Wallet Lists',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_WALLET_SETTINGS->value,
                            'PermissionTitle' => 'Wallet Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'Settings',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                    'PermissionTitle' => 'Deliveryman',
                    'activity_scope' => 'system_level',
                    'icon' => 'UserRoundPen',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Deliveryman',
                        'ar' => 'إدارة التوصيل'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_VEHICLE_TYPE->value,
                            'PermissionTitle' => 'Vehicle Types',
                            'activity_scope' => 'system_level',
                            'icon' => 'Car',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Vehicle Types',
                                'ar' => 'فئة المركبات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_MANAGE_LIST->value,
                            'PermissionTitle' => 'Deliveryman List',
                            'activity_scope' => 'system_level',
                            'icon' => 'UserRoundPen',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Deliveryman List',
                                'ar' => 'قائمة رجال التوصيل'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_TRASH_MANAGEMENT->value,
                            'PermissionTitle' => 'Trash',
                            'activity_scope' => 'system_level',
                            'icon' => 'Trash',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Trash',
                                'ar' => 'نفاية'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_DELIVERYMAN_REQUEST->value,
                            'PermissionTitle' => 'Deliveryman Requests',
                            'activity_scope' => 'system_level',
                            'icon' => 'ListPlus',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Deliveryman Requests',
                                'ar' => 'طلبات مندوب التوصيل'
                            ]
                        ],
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
                            'PermissionName' => '',
                            'PermissionTitle' => 'All Customers',
                            'activity_scope' => 'system_level',
                            'icon' => 'UsersRound',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'All Customers',
                                'ar' => 'إدارة العملاء'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_CUSTOMER_MANAGEMENT_LIST->value,
                                    'PermissionTitle' => 'Customers',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Customers',
                                        'ar' => 'عملاء'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_CUSTOMER_TRASH_MANAGEMENT->value,
                                    'PermissionTitle' => 'Trash',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Trash',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Trash',
                                        'ar' => 'نفاية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_CUSTOMER_SUBSCRIBED_MAIL_LIST->value,
                                    'PermissionTitle' => 'Subscriber List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Contact Messages',
                                        'ar' => 'الاشتراك في قائمة البريد الإلكتروني'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // Staff & Permissions
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Staff & Permissions',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view', 'insert', 'update', 'delete'],
                    'translations' => [
                        'en' => 'Staff & Permissions',
                        'ar' => 'الموظفين والأذونات'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Staff Roles',
                            'activity_scope' => 'system_level',
                            'options' => ['view'],
                            'icon' => 'LockKeyholeOpen',
                            'translations' => [
                                'en' => 'Staff Roles',
                                'ar' => 'أدوار الموظفين'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::USERS_ROLE_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                            'options' => ['view'],
                            'icon' => 'Users',
                            'translations' => [
                                'en' => 'My Staff',
                                'ar' => 'طاقمي'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_STAFF_LIST->value,
                                    'PermissionTitle' => 'List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'List',
                                        'ar' => 'علاوة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_STAFF_MANAGE->value,
                                    'PermissionTitle' => 'Add Staff',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert'],
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
                // Financial Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Financial Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Financial Management',
                        'ar' => 'النشاط المالي'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Financial',
                            'activity_scope' => 'system_level',
                            'options' => ['view'],
                            'icon' => 'BadgeDollarSign',
                            'translations' => [
                                'en' => 'Financial',
                                'ar' => ' الموظفين'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Withdrawal Settings',
                                    'activity_scope' => 'system_level',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'icon' => '',
                                    'translations' => [
                                        'en' => 'Withdrawal Settings',
                                        'ar' => 'طريقة السحب'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_WITHDRAW_METHOD_MANAGEMENT->value,
                                    'PermissionTitle' => 'Withdrawal Method',
                                    'activity_scope' => 'system_level',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_FINANCIAL_WITHDRAW_MANAGE_REQUEST->value,
                                    'PermissionTitle' => 'Withdraw Requests',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Withdraw Requests',
                                        'ar' => 'طلبات السحب'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_FINANCIAL_COLLECT_CASH->value,
                                    'PermissionTitle' => 'Cash Collect',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Cash Collect',
                                        'ar' => 'جمع النقود'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                // Report and analytics
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Report and analytics',
                    'activity_scope' => 'system_level',
                    'icon' => 'Logs',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Report and analytics',
                        'ar' => 'التقارير والتحليلات'
                    ],
                    'submenu' => [
                        [
                            'PermissionName' => PermissionKey::ADMIN_REPORT_ANALYTICS_ORDER->value,
                            'PermissionTitle' => 'Order Report',
                            'activity_scope' => 'system_level',
                            'icon' => 'FileChartColumnIncreasing',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Order Report',
                                'ar' => 'تقرير الطلب'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_REPORT_ANALYTICS_TRANSACTION->value,
                            'PermissionTitle' => 'Transaction Report',
                            'activity_scope' => 'system_level',
                            'icon' => 'ChartNoAxesCombined',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Transaction Report',
                                'ar' => 'تقرير المعاملات'
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $admin_settings_related_menu = [
            [


                // Communication Center
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Communication Center',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Communication Center',
                        'ar' => 'مركز الاتصالات'
                    ],
                    'submenu' => [
                        // chat
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Chat',
                            'activity_scope' => 'system_level',
                            'icon' => 'MessageSquareMore',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Chat',
                                'ar' => 'إعدادات الدردشة'
                            ],

                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_CHAT_SETTINGS->value,
                                    'PermissionTitle' => 'Chat Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Chat Settings',
                                        'ar' => 'إعدادات الدردشة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_CHAT_MANAGE->value,
                                    'PermissionTitle' => 'Chat List',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Chat List',
                                        'ar' => 'قائمة الدردشة'
                                    ]
                                ]
                            ]
                        ],
                        //Tickets
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Tickets',
                            'activity_scope' => 'system_level',
                            'icon' => 'Headphones',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Tickets',
                                'ar' => 'التذاكر'
                            ],

                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::ADMIN_TICKETS_DEPARTMENT->value,
                                    'PermissionTitle' => 'Department',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Department',
                                        'ar' => ' الموظفين'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::ADMIN_SUPPORT_TICKETS_MANAGE->value,
                                    'PermissionTitle' => 'All Tickets',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'All Tickets',
                                        'ar' => 'دعامات'
                                    ]
                                ]
                            ]
                        ],
                        //Notifications
                        [
                            'PermissionName' => PermissionKey::ADMIN_NOTIFICATION_MANAGEMENT->value,
                            'PermissionTitle' => 'Notifications',
                            'activity_scope' => 'system_level',
                            'icon' => 'Bell',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Notifications',
                                'ar' => 'إعدادات الأعمال'
                            ]
                        ],
                        //Notices
                        [
                            'PermissionName' => PermissionKey::ADMIN_NOTICE_MANAGEMENT->value,
                            'PermissionTitle' => 'Notices',
                            'activity_scope' => 'system_level',
                            'icon' => 'MessageSquareWarning',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Notices',
                                'ar' => 'إعدادات الأعمال'
                            ]
                        ],
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
                        // Store Type
                        [
                            'PermissionName' => PermissionKey::ADMIN_STORE_TYPE_MANAGE->value,
                            'PermissionTitle' => 'Store Type',
                            'activity_scope' => 'system_level',
                            'icon' => 'Store',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Store Type',
                                'ar' => 'نوع المتجر'
                            ]
                        ],
                        // Area Setup
                        [
                            'PermissionName' => PermissionKey::ADMIN_GEO_AREA_MANAGE->value,
                            'PermissionTitle' => 'Area Setup',
                            'activity_scope' => 'system_level',
                            'icon' => 'Locate',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Area Setup',
                                'ar' => 'إعداد المنطقة'
                            ]
                        ],

                        // Subscription Management
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Subscription',
                            'activity_scope' => 'system_level',
                            'icon' => 'PackageCheck',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Subscription Management',
                                'ar' => 'عمليات الأعمال'
                            ],
                            'submenu' => [
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
                                    'PermissionName' => PermissionKey::ADMIN_SUBSCRIPTION_STORE_PACKAGE_MANAGE->value,
                                    'PermissionTitle' => 'Store Subscription',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Store Subscription',
                                        'ar' => 'قائمة المشتركين'
                                    ]
                                ]
                            ]
                        ],

                        // Admin Commission System
                        [
                            'PermissionName' => PermissionKey::ADMIN_COMMISSION_SETTINGS->value,
                            'PermissionTitle' => 'Commission Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'BadgePercent',
                            'options' => ['view', 'update', 'others'],
                            'translations' => [
                                'en' => 'Commission Settings',
                                'ar' => 'نظام عمولة المسؤول'
                            ],
                        ]
                    ]
                ],


                //Gateway Management
                [
                    'PermissionName' => '',
                    'PermissionTitle' => 'Gateway Management',
                    'activity_scope' => 'system_level',
                    'icon' => '',
                    'options' => ['view'],
                    'translations' => [
                        'en' => 'Gateway Management',
                        'ar' => 'إدارة البوابة'
                    ],
                    'submenu' => [
                        //Payment settings management
                        [
                            'PermissionName' => PermissionKey::ADMIN_PAYMENT_SETTINGS->value,
                            'PermissionTitle' => 'Payment Gateway',
                            'activity_scope' => 'system_level',
                            'icon' => 'CreditCard',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'Payment Gateway',
                                'ar' => 'إعدادات الدفع'
                            ]
                        ],
                        //SMS settings management
                        [
                            'PermissionName' => PermissionKey::ADMIN_SMS_GATEWAY_SETTINGS->value,
                            'PermissionTitle' => 'SMS Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'CreditCard',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'SMS Gateway Settings',
                                'ar' => 'إعدادات بوابة الرسائل القصيرة'
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
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'icon' => 'Settings',
                            'translations' => [
                                'en' => 'General Settings',
                                'ar' => 'الإعدادات العامة'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::ADMIN_PAGES_LIST->value,
                            'PermissionTitle' => 'Page Lists',
                            'activity_scope' => 'system_level',
                            'icon' => 'List',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Page Lists',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::PAGE_SETTINGS->value,
                            'PermissionTitle' => 'Page Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'FileSliders',
                            'translations' => [
                                'en' => 'Page Settings',
                                'ar' => 'الإعدادات العامة'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::HOME_PAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Home Page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Home Page',
                                        'ar' => 'الصفحة الرئيسية'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::REGISTER_PAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Register Page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Register Page',
                                        'ar' => 'تخصيص التذييل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::LOGIN_PAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Login Page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Login Settings',
                                        'ar' => 'إعدادات الصيانة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::PRODUCT_DETAILS_PAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Product Details Page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Product Details Page',
                                        'ar' => 'إعدادات الصيانة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::BLOG_PAGE_SETTINGS->value,
                                    'PermissionTitle' => 'Blog Page',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Blog Page',
                                        'ar' => 'إعدادات الصيانة'
                                    ]
                                ],
                            ]
                        ],

                        [
                            'PermissionName' => PermissionKey::APPEARANCE_SETTINGS->value,
                            'PermissionTitle' => 'Appearance Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'MonitorCog',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Appearance Settings',
                                'ar' => 'إعدادات المظهر'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::MENU_CUSTOMIZATION->value,
                                    'PermissionTitle' => 'Menu Customization',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
                                    'translations' => [
                                        'en' => 'Menu Manage',
                                        'ar' => 'تخصيص التذييل'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::FOOTER_CUSTOMIZATION->value,
                                    'PermissionTitle' => 'Footer Customization',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Footer Customization',
                                        'ar' => 'تخصيص التذييل'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Email Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'Mails',
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
                                    'options' => ['view', 'update'],
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
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Email Templates',
                                        'ar' => 'قوالب البريد الإلكتروني'
                                    ]
                                ]
                            ]
                        ],

                        [
                            'PermissionName' => PermissionKey::ADMIN_MEDIA_MANAGE->value,
                            'PermissionTitle' => 'Media',
                            'activity_scope' => 'system_level',
                            'icon' => 'Images',
                            'options' => ['view', 'insert', 'update', 'delete', 'others'],
                            'translations' => [
                                'en' => 'Media',
                                'ar' => ' قوائم الصفحات'
                            ]
                        ],

                        [
                            'PermissionName' => PermissionKey::SEO_SETTINGS->value,
                            'PermissionTitle' => 'SEO Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'SearchCheck',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'SEO Settings',
                                'ar' => 'إعدادات تحسين محركات البحث'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::SITEMAP_SETTINGS->value,
                            'PermissionTitle' => 'Sitemap Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'Network',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'Sitemap Settings',
                                'ar' => 'إعدادات خريطة الموقع'
                            ]
                        ],
                        [
                            'PermissionName' => PermissionKey::GDPR_COOKIE_SETTINGS->value,
                            'PermissionTitle' => 'Cookie Settings',
                            'activity_scope' => 'system_level',
                            'icon' => 'Cookie',
                            'options' => ['view', 'update'],
                            'translations' => [
                                'en' => 'Cookie Settings',
                                'ar' => 'إعدادات ملفات تعريف الارتباط'
                            ]
                        ],
                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Third-Party',
                            'activity_scope' => 'system_level',
                            'icon' => 'Blocks',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Third-Party',
                                'ar' => 'طرف ثالث'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::GOOGLE_MAP_SETTINGS->value,
                                    'PermissionTitle' => 'Google Map Settings',
                                    'activity_scope' => 'system_level',
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                                    'options' => ['view', 'insert', 'update', 'delete', 'others'],
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
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Social Login Settings',
                                        'ar' => 'إعدادات تسجيل الدخول الاجتماعي'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::RECAPTCHA_SETTINGS->value,
                                    'PermissionTitle' => 'Recaptcha Settings',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Recaptcha Settings',
                                        'ar' => 'إعدادات ريكابتشا'
                                    ]
                                ]
                            ]
                        ],

                        [
                            'PermissionName' => '',
                            'PermissionTitle' => 'Maintenance Tools',
                            'activity_scope' => 'system_level',
                            'icon' => 'Wrench',
                            'options' => ['view'],
                            'translations' => [
                                'en' => 'Maintenance Tools',
                                'ar' => 'أدوات الصيانة'
                            ],
                            'submenu' => [
                                [
                                    'PermissionName' => PermissionKey::MAINTENANCE_SETTINGS->value,
                                    'PermissionTitle' => 'Maintenance Mode',
                                    'activity_scope' => 'system_level',
                                    'icon' => '',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Maintenance Mode',
                                        'ar' => 'وضع الصيانة'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::CACHE_MANAGEMENT->value,
                                    'PermissionTitle' => 'Cache Management',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'DatabaseZap',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Cache Management',
                                        'ar' => 'إدارة ذاكرة التخزين المؤقت'
                                    ]
                                ],
                                [
                                    'PermissionName' => PermissionKey::DATABASE_UPDATE_CONTROLS->value,
                                    'PermissionTitle' => 'Database Update',
                                    'activity_scope' => 'system_level',
                                    'icon' => 'Database',
                                    'options' => ['view', 'update'],
                                    'translations' => [
                                        'en' => 'Database Update',
                                        'ar' => 'تحديث قاعدة البيانات'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];


        $page_list = array_merge($admin_main_menu, $admin_user_related_menu, $admin_transaction_related_menu, $admin_settings_related_menu);


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

        $user = \App\Models\User::where('activity_scope', 'system_level')->first();

        if ($user && $user->activity_scope == 'system_level') {
            $role = Role::where('available_for', 'system_level')->first();

            if ($role) {
                $permissions = Permission::whereIn('available_for', ['system_level', 'COMMON'])->get();
                $role->givePermissionTo($permissions);
                $user->assignRole($role);

                DB::table('role_has_permissions')->update(['view' => true]);
            }
        }
    }
}
