<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\Location\CountryResource;
use App\Interfaces\CountryManageInterface;
use Illuminate\Http\Request;

class LocationManageController extends Controller
{
    public function __construct(protected CountryManageInterface $countryRepo)
    {

    }

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
}
