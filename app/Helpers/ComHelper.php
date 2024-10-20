<?php

namespace App\Helpers;


class ComHelper
{

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }
}
