<?php

namespace App\Services;

use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;


class AreaService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function OrganizeData(Object $request): array
    {
        $value = $request['coordinates'];


        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
            if($index == 0)
            {
                $lastCord = explode(',',$single_array);
            }
            $coords = explode(',',$single_array);

            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastCord[0], $lastCord[1]);
        return [
            'name' => $request->name,
            'code' => $request->code,
            'coordinates' => new Polygon([new LineString($polygon)]),
        ];
    }
}
