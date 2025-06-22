<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequest;
use App\Http\Requests\CityRequest;
use App\Http\Requests\CountryRequest;
use App\Http\Requests\StateRequest;
use App\Http\Resources\Location\AreaResource;
use App\Http\Resources\Location\CityResource;
use App\Http\Resources\Location\CountryResource;
use App\Http\Resources\Location\StateResource;
use App\Interfaces\AreaManageInterface;
use App\Interfaces\CityManageInterface;
use App\Interfaces\CountryManageInterface;
use App\Interfaces\StateManageInterface;
use Illuminate\Http\Request;

class LocationManageController extends Controller
{
    public function __construct(
        protected CountryManageInterface $countryRepo,
        protected StateManageInterface   $stateRepo,
        protected CityManageInterface    $cityRepo,
        protected AreaManageInterface    $areaRepo
    )
    {

    }

    /* ---------------------------------------------------------> Country Manage Start <------------------------------------------------------------------ */
    public function countriesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'code', 'status', 'region', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $countries = $this->countryRepo->getCountries($filters);
        return CountryResource::collection($countries);
    }

    public function storeCountry(CountryRequest $request)
    {
        try {
            $this->countryRepo->setCountry($request->all());
            return $this->success(translate('messages.save_success', ['name' => 'Country']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_success', ['name' => 'Country']));
        }
    }

    public function countryDetails($id)
    {
        try {
            $country = $this->countryRepo->getCountryById($id);
            // For single data can't use collection
            return new CountryResource($country);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateCountry(CountryRequest $request)
    {
        try {
            $this->countryRepo->updateCountryById($request->all());
            return $this->success(translate('messages.update_success', ['name' => 'Country']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_success', ['name' => 'Country']));
        }
    }

    public function destroyCountry($id)
    {
        try {
            $this->countryRepo->deleteCountry($id);
            return $this->success(translate('messages.delete_success', ['name' => 'Country']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.delete_failed', ['name' => 'Country']));
        }
    }
    /* ---------------------------------------------------------> Country Manage End <------------------------------------------------------------------ */

    /* ---------------------------------------------------------> State Manage Start <------------------------------------------------------------------ */
    public function statesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'country_id', 'status', 'timezone', 'sortBy', 'sortOrder', 'perPage']);

        // Get the states from the repository
        $states = $this->stateRepo->getStates($filters);

        // Return the response using a Resource Collection
        return StateResource::collection($states);
    }

    public function storeState(StateRequest $request)
    {
        try {
            $this->stateRepo->setState($request->all());
            return $this->success(translate('messages.save_success', ['name' => 'State']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_success', ['name' => 'State']));
        }
    }

    public function stateDetails($id)
    {
        try {
            $state = $this->stateRepo->getStateById($id);
            // For single data can't use collection
            return new StateResource($state);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateState(StateRequest $request)
    {
        try {
            $this->stateRepo->updateStateById($request->all());
            return $this->success(translate('messages.update_success', ['name' => 'State']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_success', ['name' => 'State']));
        }
    }

    public function destroyState($id)
    {
        try {
            $this->stateRepo->deleteState($id);
            return $this->success(translate('messages.delete_success', ['name' => 'State']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.delete_failed', ['name' => 'State']));
        }
    }
    /* ---------------------------------------------------------> State Manage End <------------------------------------------------------------------ */

    /* ---------------------------------------------------------> City Manage Start <------------------------------------------------------------------ */
    public function citiesList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'status', 'state_id', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $cities = $this->cityRepo->getCities($filters);
        return CityResource::collection($cities);
    }
    public function storeCity(CityRequest $request)
    {
        try {
            $this->cityRepo->setCity($request->all());
            return $this->success(translate('messages.save_success', ['name' => 'City']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_success', ['name' => 'City']));
        }
    }
    public function cityDetails($id)
    {
        try {
            $city = $this->cityRepo->getCityById($id);
            // For single data can't use collection
            return new CountryResource($city);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateCity(CityRequest $request)
    {
        try {
            $this->cityRepo->updateCityById($request->all());
            return $this->success(translate('messages.update_success', ['name' => 'City']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_success', ['name' => 'City']));
        }
    }
    public function destroyCity($id)
    {
        try {
            $this->cityRepo->deleteCity($id);
            return $this->success(translate('messages.delete_success', ['name' => 'City']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.delete_failed', ['name' => 'City']));
        }
    }
    /* ---------------------------------------------------------> City Manage End <------------------------------------------------------------------ */

    /* ---------------------------------------------------------> Area Manage Start <------------------------------------------------------------------ */
    public function areasList(Request $request)
    {
        // Extract filters from the request
        $filters = $request->only(['name', 'city_id', 'status', 'sortBy', 'sortOrder', 'perPage']);

        // Get the countries from the repository
        $areas = $this->areaRepo->getAreas($filters);
        return AreaResource::collection($areas);
    }
    public function storeArea(AreaRequest $request)
    {
        try {
            $this->areaRepo->setArea($request->all());
            return $this->success(translate('messages.save_success', ['name' => 'Area']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_success', ['name' => 'Area']));
        }
    }
    public function areaDetails($id)
    {
        try {
            $area = $this->areaRepo->getAreaById($id);
            // For single data can't use collection
            return new AreaResource($area);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateArea(AreaRequest $request)
    {
        try {
            $this->areaRepo->updateAreaById($request->all());
            return $this->success(translate('messages.update_success', ['name' => 'Area']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_success', ['name' => 'Area']));
        }
    }
    public function destroyArea($id)
    {
        try {
            $this->areaRepo->deleteArea($id);
            return $this->success(translate('messages.delete_success', ['name' => 'Area']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.delete_failed', ['name' => 'Area']));
        }
    }
    /* ---------------------------------------------------------> Area Manage End <------------------------------------------------------------------ */
}
