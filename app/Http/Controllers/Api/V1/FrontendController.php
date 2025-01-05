<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Behaviour;
use App\Enums\StoreType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\Product\ProductAttributeResource;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryResource;
use App\Http\Resources\Com\Product\ProductUnitPublicResource;
use App\Http\Resources\Com\Store\BehaviourPublicResource;
use App\Http\Resources\Com\Store\StoreTypePublicResource;
use App\Http\Resources\Customer\CustomerPublicResource;
use App\Http\Resources\Location\AreaPublicResource;
use App\Http\Resources\Location\CityPublicResource;
use App\Http\Resources\Location\CountryPublicResource;
use App\Http\Resources\Location\StatePublicResource;
use App\Http\Resources\Product\BestSellingPublicResource;
use App\Http\Resources\Product\NewArrivalPublicResource;
use App\Http\Resources\Product\ProductDetailsPublicResource;
use App\Http\Resources\Product\ProductPublicResource;
use App\Http\Resources\Product\TopDealsPublicResource;
use App\Http\Resources\Slider\SliderPublicResource;
use App\Http\Resources\Tag\TagPublicResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\BannerManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\StateManageInterface;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function __construct(
        protected CountryManageInterface $countryRepo,
        protected StateManageInterface   $stateRepo,
        protected CityManageInterface    $cityRepo,
        protected AreaManageInterface    $areaRepo,
        protected BannerManageInterface  $bannerRepo,
        protected ProductManageInterface $productRepo
    )
    {

    }

    /* -----------------------------------------------------------> Product List <---------------------------------------------------------- */
    public function getTopDeals(Request $request)
    {
        try {
            $query = Product::query();
            // Apply filters
            if ($request->filled('id')) {
                $product = $query
                    ->with(['variants', 'store'])
                    ->findOrFail($request->id);

                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.data_found'),
                    'data' => new ProductDetailsPublicResource($product)
                ]);
            }
            $query->select('products.id', 'products.name', 'products.slug', 'products.store_id', 'products.category_id') // Specify only necessary columns
            ->selectRaw('MAX((product_variants.price - product_variants.special_price) / product_variants.price) AS max_discount_percentage')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->whereNotNull('product_variants.special_price')
                ->whereColumn('product_variants.special_price', '<', 'product_variants.price')
                ->whereNull('product_variants.deleted_at')
                ->whereNull('products.deleted_at')
                ->groupBy('products.id', 'products.name', 'products.slug', 'products.store_id', 'products.category_id');

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
                            'product_id',
                            'special_price',
                            'price',
                            DB::raw('((price - special_price) / price) * 100 as discount_percentage')
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
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => TopDealsPublicResource::collection($products),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getBestSellingProduct(Request $request)
    {
        try {
            $query = Product::query();
            // If an ID is provided, fetch the specific product
            if (isset($request->id)) {
                $product = $query
                    ->with(['variants', 'store'])
                    ->findOrFail($request->id); // Throws 404 if product not found

                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.data_found'),
                    'data' => new ProductDetailsPublicResource($product)
                ]);
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
                ->limit($request->limit ?? 10)
                ->get();
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => BestSellingPublicResource::collection($bestSellingProducts),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
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
        $products = $query->with(['category', 'unit', 'tags', 'store', 'brand', 'variants', 'related_translations'])
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'messages' => __('messages.data_found'),
            'data' => ProductPublicResource::collection($products),
            'meta' => new PaginationResource($products)
        ]);

    }

    public function productDetails($product_slug)
    {
        $product = Product::with([
            'store',
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
            'status' => true,
            'status_code' => 200,
            'messages' => __('messages.data_found'),
            'data' => new ProductDetailsPublicResource($product)
        ]);

    }

    public function getNewArrivals(Request $request)
    {
        try {
            $query = Product::query();
            // If an ID is provided, fetch the specific product
            if (isset($request->id)) {
                $product = $query
                    ->with(['variants', 'store'])
                    ->findOrFail($request->id); // Throws 404 if product not found

                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.data_found'),
                    'data' => new ProductDetailsPublicResource($product)
                ]);
            }
            // Add filters for sorting new arrivals based on categories, prices, or availability
            if (isset($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }

            if (isset($request->min_price) && isset($request->max_price)) {
                // Filter by price from the related variants
                $query->whereHas('variants', function ($q) use ($request) {
                    $q->whereBetween('price', [$request->min_price, $request->max_price]);
                });
            }
            if (isset($request->availability)) {
                $availability = $request->availability;

                if ($availability) {
                    $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '>', 0));
                } else {
                    $query->whereHas('variants', fn($q) => $q->where('stock_quantity', '=', 0));
                }
            }
            // Include product details and sort by created_at to get new arrivals
            $products = $query
                ->with(['variants', 'store'])
                ->where('status', 'approved')
                ->where('deleted_at', null)
                ->latest()
                ->paginate($request->per_page ?? 10);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => NewArrivalPublicResource::collection($products)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
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

            // Return a collection of ProductBrandResource (including the image)
            if (!auth('api')->check() || auth('api_customer')->check()) {
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.data_found'),
                    'data' => ProductCategoryPublicResource::collection($categories),
                    'meta' => new PaginationResource($categories)
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.data_found'),
                    'data' => ProductCategoryResource::collection($categories),
                    'meta' => new PaginationResource($categories)
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage(),
            ]);
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
                'status' => true,
                'status_code' => 200,
                'message' => 'Products fetched successfully',
                'data' => ProductPublicResource::collection($products),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'total_pages' => $products->lastPage(),
                    'total_items' => $products->total(),
                ],
            ]);

        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.error'),
                'error' => $e->getMessage(),
            ]);
        }
    }


    /* -----------------------------------------------------------> Slider List <---------------------------------------------------------- */
    public function allSliders()
    {
        $sliders = Slider::where('status', 1)->latest()->paginate(10);
        // Check if sliders exist
        if ($sliders->isEmpty()) {
            return response()->json([
                'message' => 'No sliders found.',
                'sliders' => [],
            ]);
        }
        return response()->json([
            'message' => 'Sliders fetched successfully.',
            'sliders' => SliderPublicResource::collection($sliders->items()),
        ]);
    }

    /* -----------------------------------------------------------> Location List <---------------------------------------------------------- */
    public function index(Request $request)
    {
        $banner = $this->bannerRepo->getPaginatedBanner(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
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
    public function areasList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'city_id', 'status', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $areas = $this->areaRepo->getAreas($filters);
        return AreaPublicResource::collection($areas);
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
        $storeTypes = collect(StoreType::cases())->map(function ($storeType) {
            return [
                'value' => $storeType->value,
                'label' => ucfirst(str_replace('-', ' ', $storeType->value)),
            ];
        });
        return response()->json(StoreTypePublicResource::collection($storeTypes));
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
}
