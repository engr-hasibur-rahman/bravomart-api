<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Http\Resources\Location\AreaPublicResource;
use App\Http\Resources\Location\CityPublicResource;
use App\Http\Resources\Location\CountryPublicResource;
use App\Http\Resources\Location\StatePublicResource;
use App\Http\Resources\Product\ProductCategoryPublicResource;
use App\Http\Resources\Product\ProductPublicResource;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\Slider\SliderPublicResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\BannerManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\SliderManageInterface;
use App\Interfaces\StateManageInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
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
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => ProductCategoryPublicResource::collection($categories),
                'pagination' => [
                    'total' => $categories->total(),
                    'per_page' => $categories->perPage(),
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                ],
            ]);
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
            $products = $query->with(['category', 'unit', 'tag', 'attributes', 'shop', 'brand', 'variants'])->paginate($perPage);

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

}
