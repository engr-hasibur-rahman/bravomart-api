<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Behaviour;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminFlashSaleDetailsResource;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Http\Resources\Com\AboutUsPublicResource;
use App\Http\Resources\Com\BecomeSellerPublicResource;
use App\Http\Resources\Com\Blog\BlogCategoryPublicResource;
use App\Http\Resources\Com\Blog\BlogCommentResource;
use App\Http\Resources\Com\Blog\BlogDetailsPublicResource;
use App\Http\Resources\Com\Blog\BlogPublicResource;
use App\Http\Resources\Com\ComAreaListForDropdownResource;
use App\Http\Resources\Com\ContactUsPublicResource;
use App\Http\Resources\Com\Department\DepartmentListForDropdown;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\PrivacyPolicyResource;
use App\Http\Resources\Com\Product\ProductAttributeResource;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryResource;
use App\Http\Resources\Com\Product\ProductUnitPublicResource;
use App\Http\Resources\Com\Store\BehaviourPublicResource;
use App\Http\Resources\Com\Store\StorePublicDropdownResource;
use App\Http\Resources\Com\Store\StorePublicListResource;
use App\Http\Resources\Com\Store\StoreTypeDropdownPublicResource;
use App\Http\Resources\Coupon\CouponPublicResource;
use App\Http\Resources\Customer\CustomerPublicResource;
use App\Http\Resources\Location\AreaPublicResource;
use App\Http\Resources\Location\CityPublicResource;
use App\Http\Resources\Location\CountryPublicResource;
use App\Http\Resources\Location\StatePublicResource;
use App\Http\Resources\Order\OrderRefundReasonResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\Product\BestSellingPublicResource;
use App\Http\Resources\Product\FlashSaleAllProductPublicResource;
use App\Http\Resources\Product\FlashSaleWithProductPublicResource;
use App\Http\Resources\Product\NewArrivalPublicResource;
use App\Http\Resources\Product\PopularProductPublicResource;
use App\Http\Resources\Product\ProductDetailsPublicResource;
use App\Http\Resources\Product\ProductKeywordSuggestionPublicResource;
use App\Http\Resources\Product\ProductPublicResource;
use App\Http\Resources\Product\ProductSuggestionPublicResource;
use App\Http\Resources\Product\RelatedProductPublicResource;
use App\Http\Resources\Product\StoreWiseProductDropdownResource;
use App\Http\Resources\Product\TopDealsPublicResource;
use App\Http\Resources\Product\TopRatedProductPublicResource;
use App\Http\Resources\Product\TrendingProductPublicResource;
use App\Http\Resources\Product\WeekBestProductPublicResource;
use App\Http\Resources\Seller\Store\StoreDetailsPublicResource;
use App\Http\Resources\Slider\SliderPublicResource;
use App\Http\Resources\Tag\TagPublicResource;
use App\Http\Resources\User\PageListResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\BannerManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\OrderRefundInterface;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\StateManageInterface;
use App\Models\AboutSetting;
use App\Models\Banner;
use App\Models\BecomeSellerSetting;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogView;
use App\Models\ContactSetting;
use App\Models\CouponLine;
use App\Models\Customer;
use App\Models\Department;
use App\Models\FlashSaleProduct;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductView;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Store;
use App\Models\StoreArea;
use App\Models\StoreType;
use App\Models\SystemCommission;
use App\Models\Tag;
use App\Models\Unit;
use App\Services\FlashSaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function __construct(
        protected CountryManageInterface $countryRepo,
        protected StateManageInterface   $stateRepo,
        protected CityManageInterface    $cityRepo,
        protected AreaManageInterface    $areaRepo,
        protected BannerManageInterface  $bannerRepo,
        protected ProductManageInterface $productRepo,
        protected FlashSaleService       $flashSaleService,
        protected OrderRefundInterface   $orderRefundRepo
    )
    {

    }


    /* -----------------------------------------------------------> Department List <---------------------------------------------------------- */
    public function departmentList()
    {
        $departments = Department::where('status', 1)->get();
        if ($departments->isNotEmpty()) {
            return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'data' => DepartmentListForDropdown::collection($departments)
                ]
            );
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found')
            ]);
        }
    }

    /* -----------------------------------------------------------> Store List <---------------------------------------------------------- */
    public function getStores(Request $request)
    {
        if (auth('api')->check()) {
            $query = Store::query();
        } else {
            $query = Store::validForCustomerView();
        }

        // Apply store type filter if provided
        if ($request->filled('store_type')) {
            $query->where('store_type', $request->store_type);
        }

        // Apply featured stores filter if provided
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }
        // Order by rating if top_rated requested
        if ($request->filled('top_rated') && $request->top_rated) {
            // Join rating subquery
            $query->addSelect([
                'rating' => Review::selectRaw('ROUND(AVG(rating), 2)')
                    ->whereColumn('store_id', 'stores.id')
                    ->where('reviewable_type', Product::class)
                    ->where('status', 'approved')
            ])->orderByDesc('rating');
            $query->having('rating', '>=', 2); // Set your threshold
        }
        // Pagination
        $perPage = $request->get('per_page', 10);
        $stores = $query
            ->with(['area', 'seller', 'related_translations', 'products'])
            ->where('status', 1)
            ->where('deleted_at', null)
            ->paginate($perPage);
        if (!empty($stores)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => StorePublicListResource::collection($stores),
                'meta' => new PaginationResource($stores)
            ]);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }

    public function getStoresDropdown(Request $request)
    {
        if (auth('api')->check()) {
            $query = Store::where('status', 1)
                ->whereNull('deleted_at');
        } else {
            $query = Store::validForCustomerView()->where('status', 1)
                ->whereNull('deleted_at');
        }

        if ($request->has('store_type') && !empty($request->store_type)) {
            $query->where('store_type', $request->store_type);
        }
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $stores = $query->paginate(500);
        if ($stores->isNotEmpty()) {
            return response()->json([
                'message' => __('messages.data_found'),
                'data' => StorePublicDropdownResource::collection($stores),
                'meta' => new PaginationResource($stores)
            ], 200);
        }
        return response()->json([
            'message' => __('messages.data_not_found'),
        ], 404);
    }

    public function getStoreDetails(Request $request)
    {
        if (auth('api')->check()) {
            $query = Store::query();
        } else {
            $query = Store::validForCustomerView();
        }

        $store = $query->with(['area', 'seller', 'related_translations', 'products.variants'])
            ->where('slug', $request->slug)->first();
        if (!$store && empty($store)) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.data_found'),
            'data' => new StoreDetailsPublicResource($store),
        ]);
    }

    /* -----------------------------------------------------------> Product List <---------------------------------------------------------- */
    public function getKeywordSuggestions(Request $request)
    {
        // Validate the query input
        $query = $request->input('query');
        if (!$query) {
            return response()->json([
                'message' => 'Query parameter is required.',
            ], 422);
        }

        $maxSuggestions = 10; // Limit the number of suggestions

        // Search dynamically based on product title or description
        $keywordSuggestions = Product::query()
            ->where('status', 'approved') // Only active products
            ->where(function ($productQuery) use ($query) {
                $productQuery->where('name', 'like', "{$query}%")
                    ->orWhere('description', 'like', "{$query}%");
            })
            ->distinct() // Avoid duplicate suggestions
            ->limit($maxSuggestions) // Limit results
            ->get();

        return response()->json([
            'success' => true,
            'data' => ProductKeywordSuggestionPublicResource::collection($keywordSuggestions),
        ]);
    }

    public function getSearchSuggestions(Request $request)
    {
        // Validate the query input
        $query = $request->input('query');
        if (!$query) {
            return response()->json([
                'message' => 'Query parameter is required.',
            ], 200);
        }

//        $maxSuggestions = 10;
        $productSuggestions = Product::query()
            ->where('status', 'approved')
            ->where(function ($productQuery) use ($query) {
                $productQuery->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($query) {
                        $tagQuery->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('variants', function ($variantQuery) use ($query) {
                        $variantQuery->where('sku', 'like', "%{$query}%")
                            ->orWhere('attributes', 'like', "%{$query}%");
                    });
            })
            ->with(['variants:id,product_id,sku,price,stock_quantity,special_price', 'store'])
//            ->limit($maxSuggestions)
            ->get();
        return response()->json([
            'data' => ProductSuggestionPublicResource::collection($productSuggestions),
        ], 200);
    }

    public function getPopularProducts(Request $request)
    {
        // If product ID is passed, return a single product with details
        if (isset($request->id)) {
            $product = Product::with(['variants', 'store', 'related_translations'])
                ->where('status', 'approved')
                ->whereNull('deleted_at')
                ->findOrFail($request->id);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection(
                    $product->relatedProductsWithCategoryFallback()
                )
            ]);
        }

        $query = Product::query();

        // Category filter (including child categories)
        if (!empty($request->category_id) && is_array($request->category_id)) {
            $allCategoryIds = [];

            foreach ($request->category_id as $categoryId) {
                $category = ProductCategory::find($categoryId);
                if ($category) {
                    if ($category->parent_id === null) {
                        $childIds = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, $childIds);
                    }
                    $allCategoryIds[] = $category->id;
                }
            }

            if (!empty($allCategoryIds)) {
                $query->whereIn('category_id', $allCategoryIds);
            }
        }

        // Brand filter
        if (!empty($request->brand_id) && is_array($request->brand_id)) {
            $query->whereIn('brand_id', $request->brand_id);
        }

        // Price range filter
        if (isset($request->min_price) && isset($request->max_price)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        // Availability filter
        if (isset($request->availability)) {
            $query->whereHas('variants', fn($q) => $q->where('stock_quantity', $request->availability ? '>' : '=', 0)
            );
        }

        // Type filter
        if (!empty($request->type)) {
            if (is_array($request->type)) {
                $query->whereIn('type', $request->type);
            } else {
                $query->where('type', $request->type);
            }
        }

        // Minimum rating filter
        if (isset($request->min_rating)) {
            $avgRatingSub = DB::table('reviews')
                ->select('reviewable_id', DB::raw('AVG(rating) as average_rating'))
                ->where('reviewable_type', Product::class)
                ->where('status', 'approved')
                ->groupBy('reviewable_id');

            $query->joinSub($avgRatingSub, 'product_ratings', function ($join) {
                $join->on('products.id', '=', 'product_ratings.reviewable_id');
            })->where('product_ratings.average_rating', '>=', $request->min_rating);
        }

        // Sorting logic
        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                case 'price_high_low':
                    $query->addSelect([
                        'variant_price' => DB::table('product_variants')
                            ->selectRaw('MIN(price)')
                            ->whereColumn('product_variants.product_id', 'products.id')
                    ])->orderBy('variant_price', $request->sort === 'price_low_high' ? 'asc' : 'desc');
                    break;

                case 'newest':
                    $query->orderBy('products.created_at', 'desc');
                    break;

                default:
                    $query->latest('products.created_at');
            }
        }

        // Search filter
        if (!empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Featured products
        if (isset($request->is_featured) && $request->is_featured) {
            $query->where('is_featured', true);
        }

        // Base filters
        $query->where('status', 'approved')->whereNull('deleted_at');

        // Order by most viewed
        $query->orderByDesc('views');

        // Pagination
        $perPage = $request->per_page ?? 10;

        $products = $query->with([
            'category', 'unit', 'tags', 'store', 'brand', 'related_translations',
            'variants' => function ($q) use ($request) {
                if ($request->sort === "price_low_high") {
                    $q->orderBy('price', 'asc')->limit(1);
                } elseif ($request->sort === "price_high_low") {
                    $q->orderBy('price', 'desc')->limit(1);
                }
            }
        ])->paginate($perPage);

        $uniqueAttributes = $this->getUniqueAttributesFromVariants($products);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products),
            'filters' => $uniqueAttributes
        ], 200);
    }


    public function getTopDeals(Request $request)
    {
        $query = Product::query();
        // Apply filters
        if ($request->filled('id')) {
            $product = $query
                ->with(['variants', 'store'])
                ->findOrFail($request->id);

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback())
            ], 200);
        }
        $query->select('products.id', 'products.name', 'products.slug', 'products.store_id', 'products.category_id', 'products.image', 'products.description') // Specify only necessary columns
        ->selectRaw('MAX((product_variants.price - product_variants.special_price) / product_variants.price) AS max_discount_percentage')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->whereNotNull('product_variants.special_price')
            ->whereColumn('product_variants.special_price', '<', 'product_variants.price')
            ->whereNull('product_variants.deleted_at')
            ->whereNull('products.deleted_at')
            ->groupBy('products.id', 'products.name', 'products.slug', 'products.store_id', 'products.category_id', 'products.image', 'products.description');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled(['min_price', 'max_price'])) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('availability')) {
            $availability = $request->availability;
            $query->whereHas('variants', function ($q) use ($availability) {
                $q->where('stock_quantity', $availability ? '>' : '=', 0);
            });
        }

        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low_high':
                    $query->orderByHas('variants', fn($q) => $q->orderBy('price', 'asc'));
                    break;

                case 'price_high_low':
                    $query->orderByHas('variants', fn($q) => $q->orderBy('price', 'desc'));
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                default:
                    $query->latest();
            }
        }

        // Apply date filter
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;

                case 'last_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;

                case 'last_month':
                    $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                    break;

                default:
                    $query->latest();
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $products = $query
            ->with([
                'store',
                'brand',
                'variants' => function ($q) {
                    $q->select(
                        'id',
                        'stock_quantity',
                        'product_id',
                        'special_price',
                        'price',
                        'variant_slug',
                        'sku',
                        'pack_quantity',
                        'weight_major',
                        'weight_gross',
                        'weight_net',
                        'attributes',
                        'unit_id',
                        'length',
                        'width',
                        'height',
                        'image',
                        'order_count',
                        'status',
                        DB::raw('ROUND(((price - special_price) / price) * 100, 2) as discount_percentage')
                    )
                        ->whereNotNull('special_price')
                        ->whereColumn('special_price', '<', 'price')
                        ->orderByRaw('discount_percentage DESC');
                },
                'related_translations',
            ])
            ->orderBy('max_discount_percentage', 'desc')
            ->paginate($perPage);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => TopDealsPublicResource::collection($products),
            'meta' => new PaginationResource($products)
        ], 200);

    }

    public function getBestSellingProduct(Request $request)
    {
        // If product ID is passed, return a single product with details
        if (isset($request->id)) {
            $product = Product::with(['variants', 'store', 'related_translations'])
                ->where('status', 'approved')
                ->whereNull('deleted_at')
                ->findOrFail($request->id);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection(
                    $product->relatedProductsWithCategoryFallback()
                )
            ]);
        }

        $query = Product::query();

        // Category filter (including child categories)
        if (!empty($request->category_id) && is_array($request->category_id)) {
            $allCategoryIds = [];

            foreach ($request->category_id as $categoryId) {
                $category = ProductCategory::find($categoryId);
                if ($category) {
                    if ($category->parent_id === null) {
                        $childIds = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, $childIds);
                    }
                    $allCategoryIds[] = $category->id;
                }
            }

            if (!empty($allCategoryIds)) {
                $query->whereIn('category_id', $allCategoryIds);
            }
        }

        // Brand filter
        if (!empty($request->brand_id) && is_array($request->brand_id)) {
            $query->whereIn('brand_id', $request->brand_id);
        }

        // Price range filter
        if (isset($request->min_price) && isset($request->max_price)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        // Availability filter
        if (isset($request->availability)) {
            $query->whereHas('variants', fn($q) => $q->where('stock_quantity', $request->availability ? '>' : '=', 0)
            );
        }

        // Type filter
        if (!empty($request->type)) {
            if (is_array($request->type)) {
                $query->whereIn('type', $request->type);
            } else {
                $query->where('type', $request->type);
            }
        }

        // Minimum rating filter
        if (isset($request->min_rating)) {
            $avgRatingSub = DB::table('reviews')
                ->select('reviewable_id', DB::raw('AVG(rating) as average_rating'))
                ->where('reviewable_type', Product::class)
                ->where('status', 'approved')
                ->groupBy('reviewable_id');

            $query->joinSub($avgRatingSub, 'product_ratings', function ($join) {
                $join->on('products.id', '=', 'product_ratings.reviewable_id');
            })->where('product_ratings.average_rating', '>=', $request->min_rating);
        }

        // Sorting logic
        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                case 'price_high_low':
                    $query->addSelect([
                        'variant_price' => DB::table('product_variants')
                            ->selectRaw('MIN(price)')
                            ->whereColumn('product_variants.product_id', 'products.id')
                    ])->orderBy('variant_price', $request->sort === 'price_low_high' ? 'asc' : 'desc');
                    break;

                case 'newest':
                    $query->orderBy('products.created_at', 'desc');
                    break;

                default:
                    $query->latest('products.created_at');
            }
        }

        // Search filter
        if (!empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Featured products
        if (isset($request->is_featured) && $request->is_featured) {
            $query->where('is_featured', true);
        }

        // Base filters
        $query->where('status', 'approved')->whereNull('deleted_at');

        // Order by best-selling (order_count)
        $query->orderByDesc('order_count');

        // Pagination
        $perPage = $request->per_page ?? 10;

        $products = $query->with([
            'category', 'unit', 'tags', 'store', 'brand', 'related_translations',
            'variants' => function ($q) use ($request) {
                if ($request->sort === "price_low_high") {
                    $q->orderBy('price', 'asc')->limit(1);
                } elseif ($request->sort === "price_high_low") {
                    $q->orderBy('price', 'desc')->limit(1);
                }
            }
        ])->paginate($perPage);

        $uniqueAttributes = $this->getUniqueAttributesFromVariants($products);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products),
            'filters' => $uniqueAttributes
        ], 200);
    }

    public function getFeaturedProduct(Request $request)
    {
        // If product ID is passed, return a single featured product with details
        if (isset($request->id)) {
            $product = Product::with(['variants', 'store', 'related_translations'])
                ->where('status', 'approved')
                ->whereNull('deleted_at')
                ->where('is_featured', true)
                ->findOrFail($request->id);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection(
                    $product->relatedProductsWithCategoryFallback()
                )
            ]);
        }

        $query = Product::query();

        // Category filter (including child categories)
        if (!empty($request->category_id) && is_array($request->category_id)) {
            $allCategoryIds = [];

            foreach ($request->category_id as $categoryId) {
                $category = ProductCategory::find($categoryId);
                if ($category) {
                    if ($category->parent_id === null) {
                        $childIds = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, $childIds);
                    }
                    $allCategoryIds[] = $category->id;
                }
            }

            if (!empty($allCategoryIds)) {
                $query->whereIn('category_id', $allCategoryIds);
            }
        }

        // Brand filter
        if (!empty($request->brand_id) && is_array($request->brand_id)) {
            $query->whereIn('brand_id', $request->brand_id);
        }

        // Price range filter
        if (isset($request->min_price) && isset($request->max_price)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        // Availability filter
        if (isset($request->availability)) {
            $query->whereHas('variants', fn($q) => $q->where('stock_quantity', $request->availability ? '>' : '=', 0));
        }

        // Type filter
        if (!empty($request->type)) {
            if (is_array($request->type)) {
                $query->whereIn('type', $request->type);
            } else {
                $query->where('type', $request->type);
            }
        }

        // Minimum rating filter
        if (isset($request->min_rating)) {
            $avgRatingSub = DB::table('reviews')
                ->select('reviewable_id', DB::raw('AVG(rating) as average_rating'))
                ->where('reviewable_type', Product::class)
                ->where('status', 'approved')
                ->groupBy('reviewable_id');

            $query->joinSub($avgRatingSub, 'product_ratings', function ($join) {
                $join->on('products.id', '=', 'product_ratings.reviewable_id');
            })->where('product_ratings.average_rating', '>=', $request->min_rating);
        }

        // Search filter
        if (!empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting logic
        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                case 'price_high_low':
                    $query->addSelect([
                        'variant_price' => DB::table('product_variants')
                            ->selectRaw('MIN(price)')
                            ->whereColumn('product_variants.product_id', 'products.id')
                    ])->orderBy('variant_price', $request->sort === 'price_low_high' ? 'asc' : 'desc');
                    break;

                case 'newest':
                    $query->orderBy('products.created_at', 'desc');
                    break;

                default:
                    $query->latest('products.created_at');
            }
        }

        // Base conditions
        $query->where('status', 'approved')->whereNull('deleted_at')->where('is_featured', true);

        // Pagination
        $perPage = $request->per_page ?? 10;

        $products = $query->with([
            'category', 'unit', 'tags', 'store', 'brand', 'related_translations',
            'variants' => function ($q) use ($request) {
                if ($request->sort === "price_low_high") {
                    $q->orderBy('price', 'asc')->limit(1);
                } elseif ($request->sort === "price_high_low") {
                    $q->orderBy('price', 'desc')->limit(1);
                }
            }
        ])->latest()->paginate($perPage);

        $uniqueAttributes = $this->getUniqueAttributesFromVariants($products);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products),
            'filters' => $uniqueAttributes
        ]);
    }

    public function getTrendingProducts(Request $request)
    {

        $query = Product::query();

        // If an ID is provided, fetch the specific product
        if (isset($request->id)) {
            $product = $query
                ->with(['variants', 'store'])
                ->findOrFail($request->id); // Throws 404 if product not found

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback())
            ], 200);
        }

        // Fetch trending products with scores
        $trendingProducts = $query
            ->withTrendingScore() // Use the trending score scope
            ->with(['variants', 'store'])
            ->where('status', 'approved')
            ->whereNull('deleted_at')
            ->orderByDesc('trending_score') // Sort by calculated trending score
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => TrendingProductPublicResource::collection($trendingProducts),
            'meta' => new PaginationResource($trendingProducts)
        ], 200);

    }


    public function getWeekBestProducts(Request $request)
    {

        $query = Product::query();
        // If an ID is provided, fetch the specific product
        if (isset($request->id)) {
            $product = $query
                ->with(['variants', 'store'])
                ->findOrFail($request->id); // Throws 404 if product not found

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback())
            ], 200);
        }
        // Filter products created or updated in the last week
        $lastWeek = now()->subWeek();
        // Fetch products with the highest order count or rating in the last week
        $weekBestProducts = $query
            ->with(['variants', 'store'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->where(function ($query) use ($lastWeek) {
                $query->where('created_at', '>=', $lastWeek)
                    ->orWhere('updated_at', '>=', $lastWeek);
            })
            ->orderByDesc('order_count') // Sort by order count (or rating if needed)
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => WeekBestProductPublicResource::collection($weekBestProducts),
            'meta' => new PaginationResource($weekBestProducts)
        ], 200);

    }

    public function flashDeals()
    {
        $flashSaleProducts = $this->flashSaleService->getValidFlashSales();
        return response()->json([
            'message' => __('messages.data_found'),
            'data' => FlashSaleWithProductPublicResource::collection($flashSaleProducts)
        ], 200);

    }

    public function flashDealProducts(Request $request)
    {

        // If a specific flash deal product ID is requested
        if (isset($request->id)) {
            $flashDealProduct = FlashSaleProduct::with(['product.variants', 'product.store', 'product.related_translations', 'flashSale.related_translations'])
                ->where('product_id', $request->product_id)->first();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new FlashSaleAllProductPublicResource($flashDealProduct)
            ]);
        }

        $query = FlashSaleProduct::query()->with([
            'product.category',
            'product.unit',
            'product.tags',
            'product.store',
            'product.brand',
            'product.related_translations',
            'product.variants',
            'flashSale.related_translations'
        ])->whereHas('flashSale', function ($query) {
            $query->where('status', 1);
        });
        // Apply category filter (multiple categories)
        if (!empty($request->category_id) && is_array($request->category_id)) {
            // Fetch all child categories for the given category IDs
            $allCategoryIds = [];

            foreach ($request->category_id as $categoryId) {
                // Check if the category is a parent category
                $category = ProductCategory::where('id', $categoryId)->first();

                if ($category) {
                    if ($category->parent_id === null) {
                        // Fetch all child category IDs of this parent category
                        $childCategoryIds = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, $childCategoryIds);
                    }

                    // Add the original category ID
                    $allCategoryIds[] = $category->id;
                }
            }

            // Apply the category filter
            $query->whereHas('product', function ($q1) use ($allCategoryIds) {
                $q1->whereIn('category_id', $allCategoryIds);
            });
        }

        if (!empty($request->type)) {
            if (is_array($request->type)) {
                $query->whereHas('product', function ($q1) use ($request) {
                    $q1->whereIn('type', $request->type);
                });
            } else {
                $query->whereHas('product', function ($q1) use ($request) {
                    $q1->where('type', $request->type);
                });
            }
        }

        // Store filter
        if (!empty($request->store_id)) {
            $query->where('store_id', $request->store_id);
        }

        // Flash Sale ID filter
        if (filter_var($request->flash_sale_id, FILTER_VALIDATE_INT) && (int)$request->flash_sale_id !== 0) {
            $query->where('flash_sale_id', (int)$request->flash_sale_id);
        }

        // Status filter
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        // Search by product name or SKU
        if (!empty($request->search)) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by minimum rating
        if (isset($request->min_rating)) {
            $avgRatingSub = DB::table('reviews')
                ->select('reviewable_id', DB::raw('AVG(rating) as average_rating'))
                ->where('reviewable_type', Product::class)
                ->where('status', 'approved')
                ->groupBy('reviewable_id');

            $query->whereHas('product', function ($q) use ($avgRatingSub, $request) {
                $q->joinSub($avgRatingSub, 'product_ratings', function ($join) {
                    $join->on('products.id', '=', 'product_ratings.reviewable_id');
                })->where('product_ratings.average_rating', '>=', $request->min_rating);
            });
        }

        // Sort options
        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                case 'price_high_low':
                    $query->with(['product.variants' => function ($q) use ($request) {
                        $q->orderBy('price', $request->sort === 'price_low_high' ? 'asc' : 'desc')->limit(1);
                    }]);
                    break;

                case 'newest':
                    $query->orderByDesc('created_at');
                    break;

                default:
                    $query->latest();
            }
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $flashSaleProducts = $query->paginate($perPage);

        // Collect unique attributes from the variants (if needed)
        $uniqueAttributes = $this->getUniqueAttributesFromVariants($flashSaleProducts->pluck('product'));

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => FlashSaleAllProductPublicResource::collection($flashSaleProducts),
            'meta' => new PaginationResource($flashSaleProducts),
            'filters' => $uniqueAttributes
        ], 200);
    }


    public function productList(Request $request)
    {
        if ($request->popular_products) {
            return $this->getPopularProducts($request);
        }
        if ($request->best_selling) {
            return $this->getBestSellingProduct($request);
        }
        if ($request->flash_sale) {
            return $this->flashDealProducts($request);
        }
        if ($request->is_featured) {
            return $this->getFeaturedProduct($request);
        }
        /* ===========================================================Product================================================= */
        $query = Product::query();
        // Apply category filter (multiple categories)
        if (!empty($request->category_id) && is_array($request->category_id)) {
            // Fetch all child categories for the given category IDs
            $allCategoryIds = [];

            foreach ($request->category_id as $categoryId) {
                // Check if the category is a parent category
                $category = ProductCategory::where('id', $categoryId)->first();

                if ($category) {
                    if ($category->parent_id === null) {
                        // Fetch all child category IDs of this parent category
                        $childCategoryIds = ProductCategory::where('parent_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, $childCategoryIds);
                    }

                    // Add the original category ID
                    $allCategoryIds[] = $category->id;
                }
            }

            // Apply the category filter
            if (!empty($allCategoryIds)) {
                $query->whereIn('category_id', $allCategoryIds);
            }
        }

        if (!empty($request->brand_id) && is_array($request->brand_id)) {
            $query->whereIn('brand_id', $request->brand_id);
        }

        // Apply price range filter
        if (isset($request->min_price) && isset($request->max_price)) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;

            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }

        // Apply availability filter
        if (isset($request->availability)) {
            $availability = $request->availability;

            if ($availability) {
                $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '>', 0));
            } else {
                $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '=', 0));
            }
        }
        if (!empty($request->type)) {
            if (is_array($request->type)) {
                $query->whereIn('type', $request->type);
            } else {
                $query->where('type', $request->type);
            }
        }
        if (isset($request->min_rating)) {
            $minRating = $request->min_rating;

            // Subquery to calculate the average rating for each product
            $averageRatingSubquery = DB::table('reviews')
                ->select('reviewable_id', DB::raw('AVG(rating) as average_rating'))
                ->where('reviewable_type', Product::class)
                ->where('status', 'approved')
                ->groupBy('reviewable_id');

            // Join the subquery with the products table
            $query->joinSub($averageRatingSubquery, 'product_ratings', function ($join) {
                $join->on('products.id', '=', 'product_ratings.reviewable_id');
            })
                ->where('product_ratings.average_rating', '>=', $minRating);
        }

        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                case 'price_high_low':
                    $query->addSelect([
                        'effective_price' => \DB::table('product_variants')
                            ->selectRaw('MIN(LEAST(COALESCE(NULLIF(special_price, 0), price), price))')
                            ->whereColumn('product_variants.product_id', 'products.id')
                    ])->orderBy('effective_price', $request->sort === 'price_low_high' ? 'asc' : 'desc');
                    break;

                case 'newest':
                    $query->orderBy('products.created_at', 'desc');
                    break;

                default:
                    $query->latest('products.created_at');
            }
        }


        if (!empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $products = $query->with(['category', 'unit', 'tags', 'store', 'brand',
            'variants' => function ($query) use ($request) {
                if ($request->sort === "price_low_high") {
                    $query->orderBy('price', 'asc')->limit(1);
                } elseif ($request->sort === "price_high_low") {
                    $query->orderBy('price', 'desc')->limit(1);
                }
            }
            , 'related_translations'])
            ->where('products.status', 'approved')
            ->whereNull('products.deleted_at')
            ->paginate($perPage);
        // Extract unique attributes from variants
        $uniqueAttributes = $this->getUniqueAttributesFromVariants($products);
        return response()->json([
            'messages' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products),
            'filters' => $uniqueAttributes
        ], 200);
    }

    protected function getUniqueAttributesFromVariants($products)
    {
        $attributes = [];

        foreach ($products as $product) {
            foreach ($product->variants as $variant) {
                if (!empty($variant->attributes)) {
                    // Decode the JSON attributes if they are stored as a JSON string
                    $variantAttributes = json_decode($variant->attributes, true);

                    if (is_array($variantAttributes)) {
                        foreach ($variantAttributes as $key => $value) {
                            // Initialize the key if it doesn't exist
                            if (!isset($attributes[$key])) {
                                $attributes[$key] = [];
                            }

                            // Add the value to the key's array if it's not already present
                            if (!in_array($value, $attributes[$key])) {
                                $attributes[$key][] = $value;
                            }
                        }
                    }
                }
            }
        }

        return $attributes;
    }

    public function productDetails(Request $request, $product_slug)
    {
        $product = Product::with([
            'store' => function ($query) {
                $query->withCount(['products' => function ($q) {
                    // Add conditions to filter approved products and those that are not deleted
                    $q->where('status', 'approved')
                        ->whereNull('deleted_at');
                }]);
            },
            'tags',
            'unit',
            'variants',
            'brand',
            'category',
            'related_translations'
        ])
            ->where('status', 'approved')
            ->whereNull('deleted_at')
            ->where('slug', $product_slug)
            ->first();
        if ($product) {
            // Track unique user views
            if (auth('api_customer')->check()) { // If user is logged in
                $user = auth('api_customer')->user();
                // Check if user has already viewed this blog
                $viewExists = ProductView::where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->exists();
                if (!$viewExists) {
                    // Increment view count for this blog
                    $product->increment('views');
                    // Store the view record in the `blog_views` table
                    ProductView::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                // For guests, you can track by IP address
                $ipAddress = $request->ip();
                $viewExists = ProductView::where('product_id', $product->id)
                    ->where('ip_address', $ipAddress)
                    ->exists();
                if (!$viewExists) {
                    // Increment view count for this blog
                    $product->increment('views');
                    // Store the view record with the IP address
                    ProductView::create([
                        'product_id' => $product->id,
                        'ip_address' => $ipAddress,
                    ]);
                }
            }
        }
        return response()->json([
            'messages' => __('messages.data_found'),
            'data' => new ProductDetailsPublicResource($product),
            'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback())
        ], 200);

    }

    public function getNewArrivals(Request $request)
    {
        $query = Product::query();

        if ($request->has('id') && !empty($request->id)) {

            $product = $query->with(['variants', 'store'])->findOrFail($request->id);

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback()),
            ], 200);

        }

        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->min_price) && !empty($request->max_price)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        if (!empty($request->availability)) {
            $availability = $request->availability;
            $query->whereHas('variants', fn($q) => $q->where('stock_quantity', $availability ? '>' : '=', 0));
        }


        $products = $query
            ->with(['variants', 'store'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->latest()
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => NewArrivalPublicResource::collection($products),
            'meta' => new PaginationResource($products),
        ], 200);

    }

    public function getTopRatedProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('id') && !empty($request->id)) {

            $product = $query->with(['variants', 'store'])->findOrFail($request->id);

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback()),
            ], 200);

        }

        // Apply filters
        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->min_price) && !empty($request->max_price)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        if (!empty($request->availability)) {
            $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '>', 0));
        }

        $products = $query
            ->with(['variants', 'store'])
            ->where('products.status', 'approved')
            ->whereNull('products.deleted_at')
            ->leftJoin('reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.reviewable_id')
                    ->where('reviews.reviewable_type', '=', Product::class)
                    ->where('reviews.status', '=', 'approved');
            })
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.image',
                'products.store_id',
                'products.status',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating')
            ])
            ->groupBy([
                'products.id',
                'products.name',
                'products.slug',
                'products.image',
                'products.store_id',
                'products.status'
            ])
            ->orderByDesc('avg_rating')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => TopRatedProductPublicResource::collection($products),
            'meta' => new PaginationResource($products),
        ], 200);

    }

    /* -----------------------------------------------------------> Product Category List <---------------------------------------------------------- */
    public function productCategoryList(Request $request)
    {
        try {
            $per_page = $request->per_page ?? 100;
            $language = $request->language ?? DEFAULT_LANGUAGE;
            $search = $request->search;
            $sort = $request->sort ?? 'asc';
            $sortField = $request->sortField ?? 'id';
            $type = $request->type; // Get the type filter
            $all = $request->all ?? false;
            $categories = ProductCategory::leftJoin('translations', function ($join) use ($language) {
                $join->on('product_category.id', '=', 'translations.translatable_id')
                    ->where('translations.translatable_type', '=', ProductCategory::class)
                    ->where('translations.language', '=', $language)
                    ->where('translations.key', '=', 'category_name');
            })->select('product_category.*', DB::raw('COALESCE(translations.value, product_category.category_name) as category_name'));
            // Apply type filter if type is provided
            if ($type) {
                $categories->where('product_category.type', $type);
            }
            // Apply search filter if search parameter exists
            if ($search) {
                $categories->where(function ($query) use ($search) {
                    $query->where('translations.value', 'like', "%{$search}%")
                        ->orWhere('product_category.category_name', 'like', "%{$search}%");
                });
            }

            // Apply sorting and pagination
            if ($all) {
                $categories = $categories
                    ->where('status', 1)
                    ->orderBy($sortField, $sort)
                    ->paginate($per_page);
                return response()->json([
                    'message' => __('messages.data_found'),
                    'data' => ProductCategoryPublicResource::collection($categories),
                    'meta' => new PaginationResource($categories)
                ], 200);
            }
            $categories = $categories->whereNull('parent_id')
                ->where('status', 1)
                ->orderBy($sortField, $sort)
                ->paginate($per_page);
            return response()->json([
                'message' => __('messages.data_found'),
                'data' => ProductCategoryResource::collection($categories),
                'meta' => new PaginationResource($categories)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function categoryWiseProducts(Request $request)
    {
        try {
            $query = Product::query();
            // Apply category filter
            if (isset($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
            // Apply price range filter
            if (isset($request->min_price) && isset($request->max_price)) {
                $minPrice = $request->min_price;
                $maxPrice = $request->max_price;

                $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween('price', [$minPrice, $maxPrice]);
                });
            }
            // Apply brand filter
            if (isset($request->brand_id)) {
                $query->where('brand_id', $request->brand_id);
            }
            // Apply availability filter
            if (isset($request->availability)) {
                $availability = $request->availability;

                if ($availability) {
                    $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '>', 0));
                } else {
                    $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '=', 0));
                }
            }
            // Apply sorting
            if (isset($request->sort)) {
                switch ($request->sort) {
                    case 'price_low_high':
                        $query->orderByHas('variants', fn($q) => $q->orderBy('price', 'asc'));
                        break;

                    case 'price_high_low':
                        $query->orderByHas('variants', fn($q) => $q->orderBy('price', 'desc'));
                        break;

                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;

                    default:
                        $query->latest();
                }
            }
            // Pagination
            $perPage = $request->per_page ?? 10;
            $products = $query->with(['category', 'unit', 'tags', 'store', 'brand', 'variants', 'related_translations'])->paginate($perPage);

            return response()->json([
                'message' => 'Products fetched successfully',
                'data' => ProductPublicResource::collection($products),
                'meta' => new PaginationResource($products)
            ], 200);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /* -----------------------------------------------------------> Slider List <---------------------------------------------------------- */
    public function allSliders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:web,mobile',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $sliders = Slider::where('status', 1)
            ->where('platform', $request->platform)
            ->orderBy('order', 'asc')
            ->paginate(50);
        // Check if sliders exist
        if ($sliders->isEmpty()) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 204);
        }
        return response()->json([
            'sliders' => SliderPublicResource::collection($sliders->items()),
        ], 200);
    }

    /* -----------------------------------------------------------> Location List <---------------------------------------------------------- */
    public function index(Request $request)
    {
        if (isset($request->language)) {
            $language = $request->language;
            // Define the base query for the Banner model
            $banner = Banner::query()->with(['related_translations' => function ($query) use ($language) {
                $query->where('language', $language)
                    ->whereIn('key', ['title', 'description', 'button_text']);
            }]);
        }
        $banner = $banner->where('status', 1)
            ->where('location', 'home_page')
            ->latest()
            ->get();
        return BannerPublicResource::collection($banner);
    }
    /* -----------------------------------------------------------> Location List <---------------------------------------------------------- */
    // Country
    public function countriesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'code', 'status', 'region', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $countries = $this->countryRepo->getCountries($filters);
        return CountryPublicResource::collection($countries);
    }

    // State
    public function statesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'country_id', 'status', 'timezone', 'sortBy', 'sortOrder', 'perPage']);

        // Get the states from the repository
        $states = $this->stateRepo->getStates($filters);

        // Return the response using a Resource Collection
        return StatePublicResource::collection($states);
    }

    // City
    public function citiesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'status', 'state_id', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $cities = $this->cityRepo->getCities($filters);
        return CityPublicResource::collection($cities);
    }

    // Area
    public function areas(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'city_id', 'status', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $areas = $this->areaRepo->getAreas($filters);
        return AreaPublicResource::collection($areas);
    }

    public function areaList()
    {
        $areas = StoreArea::where('status', 1)->latest()->get();
        return response()->json(ComAreaListForDropdownResource::collection($areas));
    }

    public function tagList()
    {
        $tags = Tag::all();
        return TagPublicResource::collection($tags);
    }

    public function productAttributeList()
    {
        $attributes = ProductAttribute::where('status', 1)->get();
        return response()->json(ProductAttributeResource::collection($attributes));
    }

    public function brandList(Request $request)
    {
        // If request has limit
        $limit = $request->limit ?? 10;
        // If request has language
        $language = $request->language ?? DEFAULT_LANGUAGE;
        //Search parameters
        $search = $request->search;
        // Extract brands table with translations table with condition
        $brands = ProductBrand::leftJoin('translations', function ($join) use ($language) {
            $join->on('product_brand.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductBrand::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'brand_name');
        })
            ->select(
                'product_brand.*',
                DB::raw('COALESCE(translations.value, product_brand.brand_name) as brand_name')
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $brands->where(function ($query) use ($search) {
                $query->where('translations.value', 'like', "%{$search}%")
                    ->orWhere('product_brand.brand_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $brands = $brands->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);

        // Return a collection of ProductBrandResource (including the image)
        return response()->json(ProductBrandPublicResource::collection($brands));
    }

    public function storeTypeList()
    {
        $storeTypes = StoreType::where('status', 1)->get();
        return response()->json(StoreTypeDropdownPublicResource::collection($storeTypes));
    }

    public function behaviourList()
    {
        $behaviours = collect(Behaviour::cases())->map(function ($behaviour) {
            return [
                'value' => $behaviour->value,
                'label' => ucfirst(str_replace('-', ' ', $behaviour->value)),
            ];
        });
        return response()->json(BehaviourPublicResource::collection($behaviours));
    }

    public function unitList()
    {
        $units = Unit::all();
        return response()->json(ProductUnitPublicResource::collection($units));
    }

    public function customerList()
    {
        $customers = Customer::where('status', 1)->get();
        return response()->json(CustomerPublicResource::collection($customers));
    }

    public function allOrderRefundReason(Request $request)
    {
        $filters = [
            'per_page' => $request->per_page,
            'search' => $request->search,
        ];
        $reasons = $this->orderRefundRepo->order_refund_reason_list($filters);
        return response()->json([
            'data' => OrderRefundReasonResource::collection($reasons),
            'meta' => new PaginationResource($reasons)
        ], 200);
    }

    /* ----------------------------------------------------------> Blog <------------------------------------------------------ */
    public function blogs(Request $request)
    {
        $blogsQuery = Blog::with(['category', 'related_translations'])
            ->where(function ($query) {
                $query->where('status', 1)
                    ->where(function ($q) {
                        $q->whereDate('schedule_date', '<=', now())
                            ->orWhereNull('schedule_date');
                    });
            });

        // Check for "most_viewed" filter
        if ($request->has('most_viewed') && $request->most_viewed) {
            $blogsQuery->orderBy('views', 'desc');  // Assuming you have a 'views' column
        }

        if ($request->has('search') && $request->search) {
            $blogsQuery->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Check for sort filter (sort by created_at only)
        if ($request->has('sort') && $request->sort) {
            // Ensure the sort direction is either 'asc' or 'desc'
            $sortDirection = strtolower($request->sort) == 'asc' ? 'asc' : 'desc'; // Default to 'desc' if not 'asc'
            $blogsQuery->orderBy('created_at', $sortDirection);  // Sort only by 'created_at'
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;  // Default to 10 if not provided
        $blogs = $blogsQuery->paginate($perPage);

        return response()->json([
            'data' => BlogPublicResource::collection($blogs),
            'meta' => new PaginationResource($blogs)
        ], 200);
    }

    public function blogDetails(Request $request)
    {
        $blog = Blog::with('category')
            ->where('slug', $request->slug)
            ->first();
        if (!$blog) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        // Track unique user views
        if (auth('api_customer')->check()) { // If user is logged in
            $user = auth('api_customer')->user();
            // Check if user has already viewed this blog
            $viewExists = BlogView::where('blog_id', $blog->id)
                ->where('user_id', $user->id)
                ->exists();
            if (!$viewExists) {
                // Increment view count for this blog
                $blog->increment('views');
                // Store the view record in the `blog_views` table
                BlogView::create([
                    'blog_id' => $blog->id,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            // For guests, you can track by IP address
            $ipAddress = $request->ip();
            $viewExists = BlogView::where('blog_id', $blog->id)
                ->where('ip_address', $ipAddress)
                ->exists();
            if (!$viewExists) {
                // Increment view count for this blog
                $blog->increment('views');
                // Store the view record with the IP address
                BlogView::create([
                    'blog_id' => $blog->id,
                    'ip_address' => $ipAddress,
                ]);
            }
        }


        // Blog categories
        $all_blog_categories = BlogCategory::where('status', 1)
            ->limit(15)
            ->latest()
            ->get();

        // popular posts
        $popular_posts = Blog::with('category')
            ->orderBy('views', 'desc')
            ->where('status', 1)
            ->whereDate('schedule_date', '<=', now())// Only blogs with a schedule date <= today's date
            ->orWhereNull('schedule_date')
            ->limit(5)
            ->get();

        // related posts
        $related_posts = $blog->relatedBlogs()->get();

        // If no related posts found, fetch fallback blogs
        if ($related_posts->isEmpty()) {
            $related_posts = Blog::where('status', 1)
                ->whereDate('schedule_date', '<=', now())
                ->orWhereNull('schedule_date')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        if ($related_posts->isEmpty()) {
            // Try fetching most viewed posts if no related ones are found
            $related_posts = Blog::where('status', 1)
                ->orWhereNull('schedule_date')
                ->orderBy('created_at', 'desc')
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get();
        }

        // If still empty, get random blogs
        if ($related_posts->isEmpty()) {
            $related_posts = Blog::where('status', 1)
                ->orWhereNull('schedule_date')
                ->orderBy('created_at', 'desc')
                ->inRandomOrder()
                ->limit(5)
                ->get();
        }
        $blog_comments = BlogComment::where('blog_id', $blog->id)->with(['user', 'blogCommentReactions'])->orderByLikeDislikeRatio()->get();
        return response()->json([
            'blog_details' => new BlogDetailsPublicResource($blog),
            'all_blog_categories' => BlogCategoryPublicResource::collection($all_blog_categories),
            'popular_posts' => BlogPublicResource::collection($popular_posts),
            'related_posts' => BlogPublicResource::collection($related_posts),
            'blog_comments' => BlogCommentResource::collection($blog_comments),
            'total_comments' => $blog_comments->count()
        ], 200);
    }

    public function couponList(Request $request)
    {
        $query = CouponLine::query();

        // Filter by discount type
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        // Sorting by discount (highest to lowest)
        if ($request->sort_by_discount) {
            $query->orderBy('discount', 'desc');
        }

        // Filter by date range (start_date & end_date)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Filter for coupons expiring soon (default: within 2 days)
        if ($request->filled('expire_soon') && $request->expire_soon) {
            $days = $request->input('expire_soon_days', 2); // Default to 2 days
            $query->whereBetween('end_date', [now(), now()->addDays($days)]);
        }

        // Search by coupon title & description
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->whereHas('coupon', function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            });
        }

        // Sorting by newest (default: descending)
        if ($request->filled('newest') && $request->newest) {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        // Pagination
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
        $today = now()->toDateString();
        if (auth('api_customer')->check()) {
            $coupon = $query->with('coupon.related_translations')
                ->whereHas('coupon', function ($q) {
                    $q->where('status', 1);
                })
                ->where('status', 1)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->whereNull('customer_id')
                ->orWhere('customer_id', auth('api_customer')->user()->id)
                ->paginate($perPage);
        } else {
            $coupon = $query->with('coupon.related_translations')
                ->whereHas('coupon', function ($q) {
                    $q->where('status', 1);
                })
                ->where('status', 1)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->whereNull('customer_id')
                ->paginate($perPage);
        }

        return response()->json([
            'data' => CouponPublicResource::collection($coupon),
            'meta' => new PaginationResource($coupon)
        ], 200);
    }

    public function becomeSeller(Request $request)
    {
        $setting = BecomeSellerSetting::with('related_translations')
            ->where('status', 1)
            ->first();
        if (!$setting) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        $content = jsonImageModifierFormatter($setting->content);
        $setting->content = $content;
        return response()->json(new BecomeSellerPublicResource($setting));
    }

    public function aboutUs(Request $request)
    {
        $setting = AboutSetting::with('related_translations')
            ->where('status', 1)
            ->first();
        if (!$setting) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        $content = jsonImageModifierFormatter($setting->content);
        $setting->content = $content;
        return response()->json(new AboutUsPublicResource($setting));
    }

    public function contactUs(Request $request)
    {
        $setting = ContactSetting::with('related_translations')
            ->where('status', 1)
            ->first();
        if (!$setting) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        $content = jsonImageModifierFormatter($setting->content);
        $setting->content = $content;
        return response()->json(new ContactUsPublicResource($setting));
    }

    public function getPage(Request $request, $slug)
    {
        $page = Page::with('related_translations')
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->first();

        if (!$page) {
            return response()->json([
                'message' => __('Page Not Found')
            ], 404);
        }
        return response()->json(new PrivacyPolicyResource($page));
    }

    public function allPage(Request $request)
    {
        $pages = Page::with('related_translations')
            ->where('status', 'publish')
            ->take(500)->get();

        return response()->json([
            'all_pages' => PageListResource::collection($pages),
        ]);
    }

    public function getStoreWiseProducts(Request $request)
    {
        // Base query
        $query = Product::with('store') // Eager load the store relationship
        ->where('status', 'approved')
            ->whereNull('deleted_at'); // Only fetch non-deleted products

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Apply store filter
        if ($request->has('store_id') && !empty($request->store_id)) {
            $query->where('store_id', $request->store_id);
        }

        // Select specific fields
        $query->select('id', 'name', 'store_id');

        // Paginate results dynamically
        $perPage = $request->per_page ?? 20;
        if ($request->filled('per_page')) {
            $products = $query->paginate($perPage);
            return response()->json([
                'status' => true,
                'data' => StoreWiseProductDropdownResource::collection($products),
                'meta' => new PaginationResource($products),
            ]);
        } else {
            $products = $query->get();
            return response()->json([
                'status' => true,
                'data' => StoreWiseProductDropdownResource::collection($products),
            ]);
        }
    }

    public function getCheckOutPageExtraInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $flashDealProducts = FlashSaleProduct::with(['flashSale', 'product'])
            ->whereIn('product_id', $request->product_ids ?? [])
            ->get();

        $systemCommissionSettings = SystemCommission::first();

        $additionalCharge = [
            'order_additional_charge_enable_disable' => $systemCommissionSettings->order_additional_charge_enable_disable,
            'order_additional_charge_name' => $systemCommissionSettings->order_additional_charge_name,
            'order_additional_charge_amount' => $systemCommissionSettings->order_additional_charge_amount,
        ];

        return response()->json([
            'flash_sale' => $flashDealProducts->map(function ($item) {
                return [
                    'flash_sale_id' => $item->flashSale?->id,
                    'discount_type' => $item->flashSale?->discount_type,
                    'discount_amount' => $item->flashSale?->discount_amount,
                    'purchase_limit' => $item->flashSale?->purchase_limit,
                ];
            })->unique('flash_sale_id') // keep only unique flash sales
            ->values(), // <--- this reindexes the collection,
            'flash_sale_products' => FlashSaleAllProductPublicResource::collection($flashDealProducts),
            'additional_charge' => $additionalCharge,
            'order_include_tax_amount' => $systemCommissionSettings->order_include_tax_amount,
        ]);
    }
}
