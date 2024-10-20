<?php
use App\Helpers;
use Illuminate\Support\Facades\App;

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

        if(strpos($key, 'validation.') === 0 || strpos($key, 'passwords.') === 0 || strpos($key, 'pagination.') === 0 || strpos($key, 'order_texts.') === 0) {
            return trans($key, $replace);
        }


        $key = strpos($key, 'notification.') === 0?substr($key,9):$key;
        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/PublicMessages.php'));
            //$processed_key = ucfirst(str_replace('_', ' ', remove_invalid_charcaters($key)));
            $processed_key = $key;

            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/PublicMessages.php'), $str);
                $result = $processed_key;
            } else {
                $result = trans('messages.' . $key, $replace);
            }
        } catch (\Exception $exception) {
            info($exception->getMessage());
            $result = trans('messages.' . $key, $replace).$exception;
        }

        return $result;
    }
}

