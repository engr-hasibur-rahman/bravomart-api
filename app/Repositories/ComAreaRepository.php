<?php

namespace App\Repositories;

use App\Models\ComArea;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Eloquent\BaseRepository;
use Shamim\DewanMultilangSlug\Facades\MultilangSlug;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;


/**
 *
 * @package namespace App\Repositories;
 */
class ComAreaRepository extends BaseRepository
{

    public function model()
    {
        return ComArea::class;
    }

    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    public function storeArea($request)
    {
        // Check if an id is present in the request
        $attributeId = $request->input('id');

        $coordinates = $request['coordinates'];
        $location = '';
        $coordinates = json_decode($request['coordinates'], true);
        //$coordinates=json_decode(json_encode($request['coordinates']), true);
        foreach ($coordinates as $index => $loc) {
            //$location=$location.$locations['lat'].$locations['lng'];
            if ($index == 0) {
                $lastLoc = $loc;
            }
            $polygon[] = new Point($loc['lat'], $loc['lng']);
        }
        $polygon[] = new Point($lastLoc['lat'], $lastLoc['lng']);

        //logger($polygon);

        // Prepare data for Attribute
        $data = [
            'name' => $request['name'],
            'code' => $request['code'],
            'coordinates' => new Polygon([new LineString($polygon)]),
        ];

        if ($attributeId) {
            // Update existing Attribute
            $attribute = ComArea::findOrFail($attributeId);
            $attribute->update($data);
        } else {
            // Create new Aattribute
            $attribute = $this->create($data);
        }

        $translations = [];
        $defaultKeys = ['name'];


        // Handle translations
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($defaultKeys as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    // Collect translation data
                    $translations[] = [
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        // Save translations if available
        if (!empty($translations)) {
            // If updating, delete existing translations first
            if ($attributeId) {
                $attribute->translations()->delete();
            }
            $attribute->translations()->createMany($translations);
        }

        return $attribute;
    }
}
