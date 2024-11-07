<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\ComOption;

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

    public static function get_com_settings($name)
    {
        $config = null;

        $paymentmethod = ComOption::where('option_name', $name)->first();

        if ($paymentmethod) {
            $config = json_decode($paymentmethod->value, true);
        }

        return $config;
    }

    public static function getDirectory()
    {
        $config = ComHelper::get_com_settings('local_storage');

        return isset($config) ? ($config == 0 ? 's3' : 'public') : 'public';
    }

    public static function upload(string $dir, string $format, $image = null, string $old_image = null)
    {
        try {

            
            if ($old_image != null) {
                // Olde Image To Delete
                $file_path=$dir.'/'.$old_image;
                if (Storage::disk(self::getDirectory())->exists($file_path)) {
                    // Old Image Exists, now delete It
                    Storage::disk(self::getDirectory())->delete($file_path);
                }
            }

            if ($image != null) {
                $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
                if (!Storage::disk(self::getDirectory())->exists($dir)) {
                    Storage::disk(self::getDirectory())->makeDirectory($dir);
                }
                Storage::disk(self::getDirectory())->putFileAs($dir, $image, $imageName);
            } else {
                $imageName = 'noimage.png';
            }
        } catch (\Exception $e) {
        }
        return $imageName;
    }
}
