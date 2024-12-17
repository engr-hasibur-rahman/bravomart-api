<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Http\Resources\Location\AreaPublicResource;
use App\Http\Resources\Location\CityPublicResource;
use App\Http\Resources\Location\CountryPublicResource;
use App\Http\Resources\Location\StatePublicResource;
use App\Http\Resources\Slider\SliderPublicResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\BannerManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\SliderManageInterface;
use App\Interfaces\StateManageInterface;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct(
        protected CountryManageInterface $countryRepo,
        protected StateManageInterface   $stateRepo,
        protected CityManageInterface    $cityRepo,
        protected AreaManageInterface    $areaRepo,
        protected BannerManageInterface   $bannerRepo,
    )
    {

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
