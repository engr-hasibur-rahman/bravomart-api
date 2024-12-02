<?php

namespace App\Services;

use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;


class AreaService
{

    public function prepareAddData(Object $request): array
    {
        //logger($request);
        $coordinates = $request['coordinates'];
        $location = '';
        //$coordinates = json_decode($request['coordinates'], true);
        $coordinates = $request['coordinates'];
        foreach ($coordinates as $index => $loc) {
            if ($index == 0) {
                $lastLoc = $loc;
            }
            $polygon[] = new Point($loc['lat'], $loc['lng']);
        }
        $polygon[] = new Point($lastLoc['lat'], $lastLoc['lng']);
        

        return [
            'name' => $request->name,
            'code' => $request->code,
            'coordinates' => new Polygon([new LineString($polygon)]),
        ];
    }
}
