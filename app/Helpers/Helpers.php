<?php

use App\Helpers;
use App\Models\ProductVariant;
use App\Models\SettingOption;
use App\Models\Coupon;
use App\Models\CouponLine;
use App\Models\Media;
use App\Models\Translation;
use App\Models\UniversalNotification;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


if (!function_exists('remove_invalid_charcaters')) {
    function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '<', '>'], '"', ';', ' ', $str);
    }
}

if (!function_exists('translate')) {
    function translate($key, $replace = [])
    {
        $local = app()->getLocale();
        return trans($key, $replace);

    }

    //=========================================================FAYSAL IBNEA HASAN JESAN==============================================================
    if (!function_exists('safeJsonDecode')){
        function safeJsonDecode($value)
        {
            // Handle case where value is already a clean string
            if (is_null($value) || !is_string($value)) {
                return $value;
            }

            // Try decoding, but fallback if not a valid JSON
            $decoded = json_decode($value, true);

            return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }
    }



    if (!function_exists('createOrUpdateTranslationJson')) {
        function createOrUpdateTranslationJson(Request $request, int|string $refid, string $refPath, array $colNames): bool
        {
            if (empty($request['translations'])) {
                return false;
            }

            $requestedLanguages = array_column($request['translations'], 'language_code');

            // Delete translations for languages not present in the request
            Translation::where('translatable_type', $refPath)
                ->where('translatable_id', $refid)
                ->whereNotIn('language', $requestedLanguages)
                ->delete();

            $translations = [];
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {
                    $translatedValue = $translation[$key] ?? null;

                    if ($translatedValue === null) {
                        continue;
                    }

                    // Check if the translation already exists
                    $trans = Translation::where('translatable_type', $refPath)
                        ->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])
                        ->where('key', $key)
                        ->first();

                    if ($trans) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => json_encode($translatedValue),
                        ];
                    }
                }
            }

            // Bulk insert new translations
            if (!empty($translations)) {
                Translation::insert($translations);
            }

            return true;
        }
    }
    if (!function_exists('createOrUpdateTranslation')) {
        function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
        {
            if (empty($request['translations'])) {
                return false;
            }

            $requestedLanguages = array_column($request['translations'], 'language_code');

            // Delete translations for languages not present in the request
            Translation::where('translatable_type', $refPath)
                ->where('translatable_id', $refid)
                ->whereNotIn('language', $requestedLanguages)
                ->delete();

            $translations = [];
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {
                    $translatedValue = $translation[$key] ?? null;

                    if ($translatedValue === null) {
                        continue;
                    }

                    // Check if the translation already exists
                    $trans = Translation::where('translatable_type', $refPath)
                        ->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])
                        ->where('key', $key)
                        ->first();

                    if ($trans) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => $translatedValue,
                        ];
                    }
                }
            }

            // Bulk insert new translations
            if (!empty($translations)) {
                Translation::insert($translations);
            }

            return true;
        }
    }
    if (!function_exists('jsonImageModifierFormatter')) {
        function jsonImageModifierFormatter(array $data)
        {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    // If the value is an array, recursively process it
                    $data[$key] = jsonImageModifierFormatter($value);
                } elseif (isImageKey($key)) {
                    // If it's an image field, apply ImageModifier
                    $data[$key] = $value;
                    $data[$key . '_url'] = \App\Actions\ImageModifier::generateImageUrl($value);
                }
            }
            return $data;
        }
    }
    function isImageKey(string $key): bool
    {
        $imageKeys = ['image', 'background_image']; // declare the fields that needed to be formatted
        return in_array($key, $imageKeys);
    }

    if (!function_exists('calculateCenterPoint')) {
        function calculateCenterPoint(array $coordinates)
        {
            if (empty($coordinates)) {
                return ['center_latitude' => null, 'center_longitude' => null];
            }

            $totalLat = 0;
            $totalLng = 0;
            $count = count($coordinates);

            foreach ($coordinates as $coordinate) {
                $totalLat += $coordinate['lat'];
                $totalLng += $coordinate['lng'];
            }

            return [
                'center_latitude' => $totalLat / $count,
                'center_longitude' => $totalLng / $count,
            ];
        }
    }
    if (!function_exists('generateRandomCouponCode')) {
        function generateRandomCouponCode()
        {
            // Generate a random 8-character string containing letters and numbers in uppercase
            $couponCode = strtoupper(Str::random(8));

            // Ensure the generated coupon code is unique
            while (\App\Models\CouponLine::where('coupon_code', $couponCode)->exists()) {
                // If the code already exists, generate a new one
                $couponCode = strtoupper(Str::random(8));
            }

            return $couponCode;
        }
    }

    if (!function_exists('generateVariantSlug')) {
        function generateVariantSlug(array $attributes): string
        {
            // Filter attributes to remove empty values
            $filteredAttributes = array_filter($attributes, fn($value) => !empty($value));

            // Sort attributes to ensure consistency in slug generation
            ksort($filteredAttributes);

            // Concatenate attribute values with a hyphen and convert to a slug
            return Str::slug(implode('-', $filteredAttributes));
        }
    }

    if (!function_exists('capitalize_first_letter')) {
        function capitalize_first_letter(string $value): string
        {
            return ucfirst(strtolower($value));
        }
    }
    if (!function_exists('slug_generator')) {
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
        function username_slug_generator($first_name, $last_name = null)
        {
            // Generate the base username slug
            $username = Str::slug(trim(strtolower($first_name)));

            if ($last_name) {
                $slugLastName = Str::slug(trim(strtolower($last_name)));
                $username = "{$username}-{$slugLastName}";
            }

            $originalUsername = $username;
            $counter = 1;

            // Loop until a unique slug is found
            do {
                $exists = User::where('slug', $username)->exists();
                if ($exists) {
                    $username = "{$originalUsername}-{$counter}";
                    $counter++;
                }
            } while ($exists && $counter < 1000);

            // Fallback in case uniqueness is not achieved after many attempts
            if ($exists) {
                $username = "{$originalUsername}-" . Str::random(5);
            }

            return $username;
        }
    }
    if (!function_exists('generateUniqueSku')) {
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
    if (!function_exists('unauthorized_response')) {
        function unauthorized_response(): \Illuminate\Http\JsonResponse
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access. Please log in.',
            ], 401);
        }
    }

    //=========================================================FAYSAL IBNEA HASAN JESAN==============================================================
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    function com_option_update($key, $value)
    {
        $option = SettingOption::updateOrCreate(
            ['option_name' => $key], // Condition: match by option_name
            ['option_value' => $value] // Update or set option_value
        );
        // Clear the cache for the updated option
        Cache::forget($key);
        return $option ? true : false;

    }

    function com_option_get($key, $default = null)
    {
        $option_name = $key;
        $value = \Illuminate\Support\Facades\Cache::remember($option_name, 600, function () use ($option_name) {
            try {
                return SettingOption::where('option_name', $option_name)->first();
            } catch (\Exception $e) {
                return null;
            }
        });
        return $value->option_value ?? $default;
    }

    function com_get_footer_copyright()
    {
        $copyright_text = com_option_get('com_site_footer_copyright');
        $copyright_text = str_replace(array('{copy}', '{year}'), array('&copy;', date('Y')), $copyright_text);
        return $copyright_text;
    }

    function com_option_get_id_wise_url($id, $size = null)
    {
        $return_val = com_get_attachment_by_id($id, $size);
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
            $grid_image_url = asset("storage/uploads/media-uploader/default/" . basename($image_details->path));

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


    function updateEnvValues(array $get_data)
    {
        $env_data_file = app()->environmentFilePath();
        $string_data = file_get_contents($env_data_file);
        if (count($get_data) > 0) {
            foreach ($get_data as $envKey => $envValue) {
                $string_data .= "\n";
                $keyPosition = strpos($string_data, "{$envKey}=");
                $position_end_line = strpos($string_data, "\n", $keyPosition);
                $line_old_value = substr($string_data, $keyPosition, $position_end_line - $keyPosition);
                if (!$keyPosition || !$position_end_line || !$line_old_value) {
                    $string_data .= "{$envKey}={$envValue}\n";
                } else {
                    $string_data = str_replace($line_old_value, "{$envKey}={$envValue}", $string_data);
                }
            }
        }
        $string_data = substr($string_data, 0, -1);
        if (!file_put_contents($env_data_file, $string_data)) return false;
        return true;
    }

    function moduleExists($name)
    {
        $module_status = json_decode(file_get_contents(__DIR__ . '/../../modules_statuses.json'));
        $folderPath = base_path('./Modules' . DIRECTORY_SEPARATOR . $name);
        if (file_exists($folderPath) && is_dir($folderPath)) {
            return property_exists($module_status, $name) ? $module_status->$name : false;
        }
        return false;
    }

    function moduleExistsAndStatus($name)
    {
        $module_status = json_decode(file_get_contents(__DIR__ . '/../../modules_statuses.json'));
        $folderPath = base_path('./Modules' . DIRECTORY_SEPARATOR . $name);
        if (file_exists($folderPath) && is_dir($folderPath)) {
            return property_exists($module_status, $name) ? $module_status->$name : false;
        }
        return false;
    }


    // coupon manage
    function applyCoupon(string $couponCode, float $orderAmount): array
    {
        $coupon = CouponLine::with('coupon')->where('coupon_code', $couponCode)->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'Coupon not found.',
            ];
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return [
                'success' => false,
                'message' => 'Coupon has expired.',
            ];
        }

        if ($coupon->usage_limit == 0) {
            return [
                'success' => false,
                'message' => 'Coupon usage limit reached.',
            ];
        }

        if ($orderAmount < $coupon->min_order_value) {
            return [
                'success' => false,
                'message' => __('messages.coupon_min_order_amount', ['amount' => $coupon->min_order_value]),
            ];
        }

        $discountAmount = 0;

        if ($coupon->discount_type === 'percentage') {
            $discountAmount = $orderAmount * ($coupon->discount / 100);
        } elseif ($coupon->discount_type === 'amount') {
            $discountAmount = $coupon->discount;
        } else {
            return [
                'success' => false,
                'message' => __('messages.something_wrong'),
            ];
        }

        // Apply max discount limit
        $discountAmount = min($discountAmount, $coupon->max_discount ?? $discountAmount);

        // Ensure the discount does not exceed the order total
        $discountAmount = min($discountAmount, $orderAmount);
        $finalOrderAmount = $orderAmount - $discountAmount;

        // Update usage stats (optional, could also be deferred until after order success)
        $coupon->increment('usage_count');
        if ($coupon->usage_limit) {
            $coupon->decrement('usage_limit');
        }

        return [
            'success' => true,
            'discount_amount' => round($discountAmount, 2),
            'final_order_amount' => round($finalOrderAmount, 2),
            'coupon_type' => $coupon->discount_type,
            'discount_rate' => $coupon->discount,
            'coupon_title' => $coupon->coupon->title ?? null,
            'coupon_code' => $coupon->coupon_code,
        ];
    }


    function calculateStoreShareWithDiscount($storeOrderAmount, $totalOrderAmount, $totalDiscount)
    {
        // Calculate the store's share of the total order amount
        $storeShare = ($storeOrderAmount / $totalOrderAmount) * $totalDiscount;
        return $storeShare;
    }

    function notificationCreateForAdmin($title, $message, $data = null)
    {
        UniversalNotification::create([
            'title' => $title,
            'message' => $message,
            'notifiable_type' => 'Admin', // You can use enums or constants for better clarity
            'notifiable_id' => 1, // Assuming Admin ID is 1 or pass it dynamically
            'data' => $data, // Optional additional data, can be an array or JSON
            'is_read' => false, // Default unread status
        ]);
    }

}


if (!function_exists('getOrderStatusMessage')) {
    function getOrderStatusMessage($order, $isNewOrder = false)
    {
        $messages = [
            'admin' => "Order #{$order->id} has been updated.",
            'store' => "Order #{$order->id} status has changed.",
            'customer' => "Your order #{$order->id} has been updated.",
            'deliveryman' => "New update for Order #{$order->id}.",
            'title' => "Order #{$order->id}."
        ];

        // If the order is newly placed
        if ($isNewOrder) {
            $messages['admin'] = "A new order #{$order->id} has been placed.";
            $messages['store'] = "You have received a new order #{$order->id}. Please review it.";
            $messages['customer'] = "Your order #{$order->id} has been placed successfully.";
            $messages['deliveryman'] = "A new order #{$order->id} will be assigned soon.";
            $messages['title'] = "Order Placed Successfully.";

            return $messages;
        }

        // message
        if ($order->status === 'pending') {
            $messages['admin'] = "A new order #{$order->id} is pending confirmation.";
            $messages['store'] = "New order #{$order->id} is waiting for approval.";
            $messages['customer'] = "Your order #{$order->id} is pending confirmation.";
            $messages['deliveryman'] = "Order #{$order->id} is pending, not yet assigned.";
            $messages['title'] = "Order #{$order->id} is pending";
        } elseif ($order->status === 'confirmed') {
            $messages['admin'] = "Order #{$order->id} has been confirmed by the store.";
            $messages['store'] = "You have confirmed order #{$order->id}.";
            $messages['customer'] = "Your order #{$order->id} has been confirmed and is being prepared.";
            $messages['deliveryman'] = "Order #{$order->id} is confirmed and will be assigned soon.";
            $messages['title'] = "Order #{$order->id} is confirmed";
        } elseif ($order->status === 'processing') {
            $messages['admin'] = "Order #{$order->id} is being processed.";
            $messages['store'] = "Order #{$order->id} is being processed.";
            $messages['customer'] = "Your order #{$order->id} is now in processing.";
            $messages['deliveryman'] = "Order #{$order->id} is still in processing state.";
            $messages['title'] = "Order #{$order->id} is processing";
        } elseif ($order->status === 'shipped') {
            $messages['admin'] = "Order #{$order->id} has been shipped.";
            $messages['store'] = "Order #{$order->id} has been shipped to the customer.";
            $messages['customer'] = "Your order #{$order->id} has been shipped.";
            $messages['deliveryman'] = "Order #{$order->id} is now out for delivery.";
            $messages['title'] = "Order #{$order->id} is shipped";
        } elseif ($order->status === 'delivered') {
            $messages['admin'] = "Order #{$order->id} has been successfully delivered.";
            $messages['store'] = "Order #{$order->id} has been delivered to the customer.";
            $messages['customer'] = "Your order #{$order->id} has been delivered. Thank you for shopping with us!";
            $messages['deliveryman'] = "Order #{$order->id} delivery is completed.";
            $messages['title'] = "Order #{$order->id} is delivered";
        } elseif ($order->status === 'cancelled') {
            $messages['admin'] = "Order #{$order->id} has been cancelled.";
            $messages['store'] = "Order #{$order->id} has been cancelled by the customer or admin.";
            $messages['customer'] = "Your order #{$order->id} has been cancelled.";
            $messages['deliveryman'] = "Order #{$order->id} has been cancelled. No delivery required.";
            $messages['title'] = "Order #{$order->id} is cancelled";
        }

        return $messages;
    }


    if (!function_exists('get_currency_symbol')) {
        function get_currency_symbol(bool $asCode = false): string
        {
            // Define a local currency-symbol map
            $currencies = [
                'USD' => '$',
                'EUR' => '€',
                'GBP' => '£',
                'BDT' => '৳',
                'INR' => '₹',
                'JPY' => '¥',
                'CAD' => 'C$',
                'AUD' => 'A$',
                'MYR' => 'RM',
                'BRL' => 'R$',
                'ZAR' => 'R',
                'NGN' => '₦',
                'IDR' => 'Rp',
            ];

            $globalCurrency = com_option_get('com_site_global_currency') ?? '$';
            $symbol = $currencies[$globalCurrency] ?? '$';

            if ($asCode) {
                $symbol = $globalCurrency;
            }

            $addSpace = com_option_get('com_site_space_between_amount_and_symbol') === 'yes';

            return $addSpace ? " {$symbol} " : $symbol;
        }
    }


    if (!function_exists('format_currency')) {
        function amount_with_symbol_format($amount, $text = false)
        {
            $symbol = get_currency_symbol($text);
            $position = com_option_get('com_site_currency_symbol_position');
            $use_comma = com_option_get('com_site_comma_form_adjustment_amount') === 'yes';

            $formatted = number_format((float) $amount, 2, '.', $use_comma ? ',' : '');

            return $position === 'right' ? $formatted . $symbol : $symbol . $formatted;
        }
    }


}

