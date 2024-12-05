<?php

namespace App\Actions;

class ImageModifier
{
    /**
     * Generate the image URL from the given image identifier.
     *
     * @param mixed $image
     * @return string|null
     */
    public function generateImageUrl($image): ?string
    {
        if (!empty($image)) {
            return com_option_get_id_wise_url($image);
        }

        return null;
    }
}
