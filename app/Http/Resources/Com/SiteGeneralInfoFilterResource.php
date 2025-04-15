<?php

namespace App\Http\Resources\Com;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteGeneralInfoFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [];

        foreach ($this->resource as $key => $value) {
            $result[$key] = ImageModifier::generateImageUrl($value);
        }

        return $result;
    }
}
