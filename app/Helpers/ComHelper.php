<?php

namespace App\Helpers;


class ComHelper
{

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }

    public static function format_coordiantes($coordinates)
    {
        $data = [];
        foreach ($coordinates as $coord) {
            $data[] = (object)['lat' => $coord[1], 'lng' => $coord[0]];
        }
        return $data;
    }
}
