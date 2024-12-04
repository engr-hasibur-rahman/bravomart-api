<?php

use App\Helpers;
use Illuminate\Support\Facades\App;
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
    

}
