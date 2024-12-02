<?php

use App\Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

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
}
