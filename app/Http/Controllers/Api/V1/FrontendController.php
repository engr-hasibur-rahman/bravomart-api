<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Behaviour;
use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Http\Resources\Com\ComAreaListForDropdownResource;
use App\Http\Resources\Com\Department\DepartmentListForDropdown;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\Product\ProductAttributeResource;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Product\ProductUnitPublicResource;
use App\Http\Resources\Com\Store\BehaviourPublicResource;
use App\Http\Resources\Com\Store\StorePublicDropdownResource;
use App\Http\Resources\Com\Store\StorePublicListResource;
use App\Http\Resources\Com\Store\StoreTypeDropdownPublicResource;
use App\Http\Resources\Com\Store\StoreTypePublicResource;
use App\Http\Resources\Customer\CustomerPublicResource;
use App\Http\Resources\Location\AreaPublicResource;
use App\Http\Resources\Location\CityPublicResource;
use App\Http\Resources\Location\CountryPublicResource;
use App\Http\Resources\Location\StatePublicResource;
use App\Http\Resources\Order\OrderRefundReasonResource;
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
use App\Http\Resources\Product\TopDealsPublicResource;
use App\Http\Resources\Product\TopRatedProductPublicResource;
use App\Http\Resources\Product\TrendingProductPublicResource;
use App\Http\Resources\Product\WeekBestProductPublicResource;
use App\Http\Resources\Seller\Store\StoreDetailsPublicResource;
use App\Http\Resources\Slider\SliderPublicResource;
use App\Http\Resources\Tag\TagPublicResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\BannerManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\OrderRefundInterface;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\StateManageInterface;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\CouponLine;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Store;
use App\Models\StoreArea;
use App\Models\StoreType;
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
        $query = Store::query();

        // Apply store type filter if provided
        if ($request->filled('store_type')) {
            $query->where('store_type', $request->store_type);
        }

        // Apply featured stores filter if provided
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
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
        $query = Store::where('status', 1)
            ->whereNull('deleted_at');
        if ($request->has('store_type') && !empty($request->store_type)) {
            $query->where('store_type', $request->store_type);
        }
        $stores = $query->paginate(50);
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
        $query = Store::query();

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
            ->with(['variants:id,product_id,sku,price,stock_quantity'])
//            ->limit($maxSuggestions)
            ->get();
        return response()->json([
            'data' => ProductSuggestionPublicResource::collection($productSuggestions),
        ], 200);
    }

    public function getPopularProducts(Request $request)
    {
        $query = Product::query();

        // If an ID is provided, fetch the specific product
        if (isset($request->id)) {
            $product = $query
                ->with(['variants', 'store', 'related_translations'])
                ->findOrFail($request->id); // Throws 404 if product not found

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new ProductDetailsPublicResource($product),
                'related_products' => RelatedProductPublicResource::collection($product->relatedProductsWithCategoryFallback())
            ]);
        }
        // Include optional filters for customization
        if (isset($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        if (isset($request->brand_id)) {
            $query->where('brand_id', $request->brand_id);
        }
        // Fetch popular products, sorting by views_count
        $popularProducts = $query
            ->with(['variants', 'store'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->orderByDesc('views') // Sort by views count
            ->paginate($request->per_page ?? 10);
        return response()->json([
            'message' => __('messages.data_found'),
            'data' => PopularProductPublicResource::collection($popularProducts),
            'meta' => new PaginationResource($popularProducts)
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
        // Include filters for customization if needed
        if (isset($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        if (isset($request->brand_id)) {
            $query->where('brand_id', $request->brand_id);
        }
        // Sort by order count or rating (add rating logic later if needed)
        $bestSellingProducts = $query
            ->with(['variants', 'store'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->orderByDesc('order_count')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => BestSellingPublicResource::collection($bestSellingProducts),
            'meta' => new PaginationResource($bestSellingProducts)
        ], 200);
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
        $filters = [
            "store_id" => $request->store_id,
            "flash_sale_id" => $request->flash_sale_id,
            "status" => $request->status,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "per_page" => $request->per_page,
        ];
        $flashSaleProducts = $this->flashSaleService->getAllFlashSaleProducts($filters);
        return response()->json([
            'message' => __('messages.data_found'),
            'data' => FlashSaleAllProductPublicResource::collection($flashSaleProducts),
            'meta' => new PaginationResource($flashSaleProducts)
        ], 200);


    }

    public function productList(Request $request)
    {
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
        if (isset($request->type)) {
            $query->where('type', $request->type);
        }

        // Apply sorting
        if (isset($request->sort)) {
            switch ($request->sort) {
                case 'price_low_high':
                    $query->whereHas('variants', fn($q) => $q->orderBy('price', 'asc'));
                    break;

                case 'price_high_low':
                    $query->whereHas('variants', fn($q) => $q->orderBy('price', 'desc'));
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                default:
                    $query->latest();
            }
        }
        if (!empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $products = $query->with(['category', 'unit', 'tags', 'store', 'brand', 'variants', 'related_translations'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->paginate($perPage);

        return response()->json([
            'messages' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products)
        ], 200);
    }

    public function productDetails($product_slug)
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
            ->where('slug', $product_slug)
            ->first();
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
            $limit = $request->limit ?? 10;
            $language = $request->language ?? DEFAULT_LANGUAGE;
            $search = $request->search;
            $sort = $request->sort ?? 'asc';
            $sortField = $request->sortField ?? 'id';
            $categories = ProductCategory::leftJoin('translations', function ($join) use ($language) {
                $join->on('product_category.id', '=', 'translations.translatable_id')
                    ->where('translations.translatable_type', '=', ProductCategory::class)
                    ->where('translations.language', '=', $language)
                    ->where('translations.key', '=', 'category_name');
            })->select('product_category.*', DB::raw('COALESCE(translations.value, product_category.category_name) as category_name'));

            // Apply search filter if search parameter exists
            if ($search) {
                $categories->where(function ($query) use ($search) {
                    $query->where('translations.value', 'like', "%{$search}%")
                        ->orWhere('product_category.category_name', 'like', "%{$search}%");
                });
            }

            // Apply sorting and pagination
            $categories = $categories->whereNull('parent_id')
                ->orderBy($sortField, $sort)
                ->paginate($limit);

            return response()->json([
                'message' => __('messages.data_found'),
                'data' => ProductCategoryPublicResource::collection($categories),
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
    public function allSliders()
    {
        $sliders = Slider::where('status', 1)->latest()->paginate(10);
        // Check if sliders exist
        if ($sliders->isEmpty()) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 204);
        }
        return response()->json([
            'message' => 'Sliders fetched successfully.',
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
        $storeTypes = StoreType::get();
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
        $filters = [
            "most_viewed" => $request->most_viewed,
            "search" => $request->search
        ];
        $blogs = Blog::with('category')
            ->where('status', 1)
            ->whereDate('schedule_date', '<=', now())  // Only blogs with a schedule date <= today's date
            ->latest()
            ->paginate(10);
        return response()->json();
    }
}
