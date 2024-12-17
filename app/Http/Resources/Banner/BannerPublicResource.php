<?php

namespace App\Http\Resources\Banner;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerPublicResource extends JsonResource
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
            'store_id' => $this->store_id,
            'title' => $this->title,
            'description' => $this->description,
            'background_image' => $this->background_image,
            'redirect_url' => $this->redirect_url,
            'image_url' => ImageModifier::generateImageUrl($this->background_image),
            'status' => $this->status,
            'priority' => $this->priority,
        ];
    }
}
