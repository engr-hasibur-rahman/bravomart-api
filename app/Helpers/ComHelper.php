<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\ComOption;
use App\Models\Media;

class ComHelper
{

    /**
     * remove_invalid_charcaters
     * Remove unaccepteable charecters from the text
     * 
     * 
     * @param  mixed $str
     * @return void
     */
    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }

    /**
     * format_coordiantes
     * Format geometry coordiantes to make it useable for front-end 
     * 
     * @param  mixed $coordinates
     * @return void Coordinte Array
     */
    public static function format_coordiantes($coordinates)
    {
        $data = [];
        foreach ($coordinates as $coord) {
            $data[] = (object)['lat' => $coord[1], 'lng' => $coord[0]];
        }
        return $data;
    }


    /**
     * get_com_settings
     * get settings otpion from database
     *
     * @param  mixed $name Name of the Option
     * @return string Json Decoded string
     */
    public static function get_com_settings($name)
    {
        $config = null;

        $paymentmethod = ComOption::where('option_name', $name)->first();

        if ($paymentmethod) {
            $config = json_decode($paymentmethod->value, true);
        }

        return $config;
    }

    /**
     * getDirectory
     * Get Direcotry Name
     *
     * @return void
     */
    public static function getDirectory()
    {
        $config = ComHelper::get_com_settings('local_storage');

        return isset($config) ? ($config == 0 ? 's3' : 'public') : 'public';
    }

    /**
     * get_image_base_url
     * Get Base Url for image to Show
     * @return void
     */
    public static function get_image_base_url()
    {
        //For Dynamic URL. Like AWS/CloudFront/Local
        return env('APP_URL') . '/storage';
    }


    /**
     * Upload Single document to folder
     *
     * @param  string $dir Direcotry name to Save the File
     * @param  object $file Image Object
     * @param  string $old_image Provide old image name to replaec, if data is updating
     * @param  string $format File format/extension, if you want to change file in different format
     * @return string Image Name only 
     */
    public static function uploadSingle(string $dir, $file, string $old_image = null, string $format = null): string
    {
        try {


            if ($old_image != null) {
                // Olde Image To Delete
                $file_path = $dir . '/' . $old_image;
                //Check if Exists
                if (Storage::disk(self::getDirectory())->exists($file_path)) {
                    // Old Image Exists, now delete It
                    Storage::disk(self::getDirectory())->delete($file_path);
                }
            }

            // Upload File
            if ($file != null) {
                $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $file->extension();
                // Check Folder Exists
                if (!Storage::disk(self::getDirectory())->exists($dir)) {
                    // Folder not found Create It
                    Storage::disk(self::getDirectory())->makeDirectory($dir);
                }
                Storage::disk(self::getDirectory())->putFileAs($dir, $file, $imageName);
            } else {
                $imageName = 'noimage.png';
            }
        } catch (\Exception $e) {
        }
        return $imageName;
    }



    /**
     * Upload Multiple document to folder
     *
     * @param  string $dir Direcotry name to Save the File
     * @param  object $file array of Image Object
     * @param  string $old_image Provide old image name to replaec, if data is updating
     * @param  string $format File format/extension, if you want to change file in different format
     * @return string Image Name Array
     */
    public static function uploadMulti(string $dir, array $files, array $old_images = null, string $format = null): array
    {
        $fileNames = [];
        try {

            //Delete all Existing Image
            foreach ($old_images as $old_image) {

                if ($old_image != null) {
                    // Olde Image To Delete
                    $file_path = $dir . '/' . $old_image;
                    //Check if Exists
                    if (Storage::disk(self::getDirectory())->exists($file_path)) {
                        // Old Image Exists, now delete It
                        Storage::disk(self::getDirectory())->delete($file_path);
                    }
                }
            }

            // Upload files one by One
            foreach ($files as $file) {

                if ($file != null) {
                    $fileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $file->extension();
                    //Check if Exists
                    if (!Storage::disk(self::getDirectory())->exists($dir)) {
                        // Folder not found Create It
                        Storage::disk(self::getDirectory())->makeDirectory($dir);
                    }
                    Storage::disk(self::getDirectory())->putFileAs($dir, $file, $fileName);
                } else {
                    $fileName = 'noimage.png';
                }
                $fileNames[] = $fileName;
            }
        } catch (\Exception $e) {
        }

        return $fileNames;
    }
}
