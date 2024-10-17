<?php

namespace App\Helpers;


class CommonHelper
{

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }
}
