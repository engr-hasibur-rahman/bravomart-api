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
    public function multipleImageModifier(string|null $multiple_images): ?string
    {
        if (isset($multiple_images)) return null;
        $img_ids = explode(',', $multiple_images);
        $img_urls = [];
        foreach ($img_ids as $img_id) {
            $image_url = com_option_get_id_wise_url($img_id);
           if ($image_url) {
               $img_urls[] = $image_url;
           }
        }

        return $img_urls;
    }
}
