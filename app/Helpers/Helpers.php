<?php

use App\Helpers;
use App\Models\ComOption;
use App\Models\Media;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


if (! function_exists('remove_invalid_charcaters')) {
    function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }
}

if (! function_exists('translate')) {
    function translate($key, $replace = [])
    {
        $local = app()->getLocale();
        //return $local;

        //if(strpos($key, 'validation.') === 0 || strpos($key, 'passwords.') === 0 || strpos($key, 'pagination.') === 0 || strpos($key, 'order_texts.') === 0) {
        return trans($key, $replace);
        //return __($key, $replace);

        //}


        // $key = strpos($key, 'messages.') === 0?substr($key,9):$key;
        // try {
        //     $lang_array = include(base_path('resources/lang/' . $local . '/PublicMessages.php'));
        //     //$processed_key = ucfirst(str_replace('_', ' ', remove_invalid_charcaters($key)));
        //     $processed_key = $key;

        //     if (!array_key_exists($key, $lang_array)) {
        //         $lang_array[$key] = $processed_key;
        //         $str = "<?php return " . var_export($lang_array, true) . ";";
        //         file_put_contents(base_path('resources/lang/' . $local . '/PublicMessages.php'), $str);
        //         $result = $processed_key;
        //     } else {
        //         $result = trans('messages.' . $key, $replace);
        //     }
        // } catch (\Exception $exception) {
        //     info($exception->getMessage());
        //     $result = trans('messages.' . $key, $replace).$exception;
        // }

        //return $result;
    }
    //=========================================================FAYSAL IBNEA HASAN JESAN==============================================================
    if (! function_exists('slug_generator')) {
        /**
         * Generate a unique slug for a given model and field.
         *
         * @param string $value The value to slugify.
         * @param string $model The model class name (e.g., App\Models\Post::class).
         * @param string $field The field to check for uniqueness (default: 'slug').
         * @param int|null $id Optional: ID of the record being updated to exclude from uniqueness check.
         * @return string
         */
        function slug_generator(string $value, string $model, string $field = 'slug', ?int $id = null): string
        {
            $slug = Str::slug($value); // Generate initial slug
            $originalSlug = $slug;

            $i = 1;
            while ($model::where($field, $slug)->when($id, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })->exists()) {
                $slug = "{$originalSlug}-{$i}";
                $i++;
            }
            return $slug;
        }
    }
    
if (!function_exists('username_slug_generator')) {
    /**
     * Generate a slug from first name and last name.
     *
     * @param string $first_name
     * @param string|null $last_name
     * @return string
     */
    function username_slug_generator($first_name, $last_name = null)
    {
        $username = Str::slug(trim(strtolower($first_name)));

        if ($last_name) {
            $slugLastName = Str::slug(trim(strtolower($last_name)));
            return "{$username}-{$slugLastName}";
        }

        return $username;
    }
}
    if (!function_exists('generateUniqueSku')) {
        /**
         * Generate a unique SKU for a product variant.
         *
         * @param string $prefix Prefix for the SKU (optional)
         * @param int $length Length of the random part of the SKU
         * @return string Unique SKU
         */
        function generateUniqueSku($prefix = '', $length = 8)
        {
            do {
                // Generate a random SKU using a prefix and a random string
                $sku = strtoupper($prefix) . Str::random($length);
    
                // Check if the SKU already exists in the `product_variants` table
                $exists = DB::table('product_variants')->where('sku', $sku)->exists();
            } while ($exists); // Repeat until a unique SKU is found
    
            return $sku;
        }
    }
    //=========================================================FAYSAL IBNEA HASAN JESAN==============================================================
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    function com_option_update($key, $value)
    {
        $option = ComOption::updateOrCreate(
            ['option_name' => $key], // Condition: match by option_name
            ['option_value' => $value] // Update or set option_value
        );
        // Clear the cache for the updated option
        Cache::forget($key);
        return $option ? true : false;

    }

    function com_option_get($key,$default = null)
    {
        $option_name = $key;
        $value = \Illuminate\Support\Facades\Cache::remember($option_name, 600, function () use($option_name) {
            try {
                return ComOption::where('option_name', $option_name)->first();
            }catch (\Exception $e){
                return null;
            }
        });
        return $value->option_value ?? $default;
    }


    function com_option_get_id_wise_url($id,$size=null){
        $return_val =  com_get_attachment_by_id($id,$size);
        return $return_val['img_url'] ?? '';
    }

    function com_get_attachment_by_id($id, $size = null, $default = false)
    {
        $image_details = Media::find($id);
        $return_val = [];
        $image_url = '';

        if ($image_details) {
            // Construct the base path for the images
            $base_path = 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'media-uploader' . DIRECTORY_SEPARATOR . 'default';
            $image_path = $base_path . DIRECTORY_SEPARATOR . $image_details->path;
            $image_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $image_path); // Normalize path separators

            $image_url = asset("storage/{$image_details->path}");
            // Check if the grid version exists (without file_exists, use URL generation)
            $grid_image_url = asset("storage/uploads/media-uploader/default/grid-" . basename($image_details->path));

            // If the grid version URL is valid, use that
            if ($grid_image_url) {
                $image_url = $grid_image_url;
            }

            if (file_exists(public_path($image_path))) {
                $image_url = asset($image_path);
            }

            // Handle image variations based on size
            $size_prefixes = [
                'large' => 'large-',
                'grid' => 'grid-',
                'semi-large' => 'semi-large-',
                'thumb' => 'thumb-',
            ];

            if ($size && array_key_exists($size, $size_prefixes)) {
                $sized_image_path = $base_path . DIRECTORY_SEPARATOR . $size_prefixes[$size] . $image_details->path;
                $sized_image_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $sized_image_path); // Normalize path separators

                if (file_exists(public_path($sized_image_path))) {
                    $image_url = asset($sized_image_path);
                }
            }

            // Set the return values
            $return_val['image_id'] = $image_details->id;
            $return_val['path'] = $image_details->path;
            $return_val['img_url'] = $image_url;
            $return_val['img_alt'] = $image_details->alt;
        } elseif ($default) {
            // Set a default image URL if the image is not found
            $return_val['img_url'] = asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'no-image.png');
        }

        return $return_val;
    }


    function updateEnvValues(array $values)
    {
        $envFile = app()->environmentFilePath();
        $envContent = file_get_contents($envFile);

        if ($envContent === false) {
            return false; // Handle error when reading the .env file
        }

        foreach ($values as $key => $value) {
            $escapedValue = is_string($value) ? '"' . addslashes($value) . '"' : $value;
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $envContent)) {
                // Replace existing key-value pair
                $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
            } else {
                // Append new key-value pair at the end
                $envContent .= "\n{$key}={$escapedValue}";
            }
        }

        // Write the updated content back to the .env file
        return file_put_contents($envFile, $envContent) !== false;
    }


}
