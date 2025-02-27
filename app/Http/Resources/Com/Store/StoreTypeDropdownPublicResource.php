<?php

namespace App\Http\Resources\Com\Store;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreTypeDropdownPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'value' => $this->type,
            'label' => $this->type,
            'image_url' => ImageModifier::generateImageUrl($this->image),
        ];
    }
}
