<?php

namespace App\Actions;

class MultipleImageModifier
{
    /**
     * Generate the image URL from the given image identifier.
     *
     * @param mixed $image
     * @return string|null
     */
    public static function multipleImageModifier($multiple_images){
        // Check if $multiple_images is not set or is empty
        if (empty($multiple_images)) {
            return null; // If no images are provided, return null
        }

        // Split the string of image IDs by commas
        $img_ids = explode(',', $multiple_images);

        // Initialize an empty array to hold the image URLs
        $img_urls = [];

        // Iterate over each image ID and generate the URL
        foreach ($img_ids as $img_id) {
            $image_url = com_option_get_id_wise_url($img_id);
            if ($image_url) {
                $img_urls[] = $image_url;
            }
        }

        // Return the URLs as a comma-separated string if there are multiple, or a single string if only one URL
        if (count($img_urls) > 1) {
            return implode(',', $img_urls); // Return as comma-separated string
        } elseif (count($img_urls) === 1) {
            return $img_urls[0]; // Return single image URL as a string
        }

        return null; // In case no valid URLs were found
    }
}
