<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "store_id"=> $this->store->name,
            "type"=> $this->type,
            "behaviour"=> $this->behaviour,
            "name"=> $this->name,
            "slug"=> $this->slug,
            "description"=> $this->description,
            "image"=> ImageModifier::generateImageUrl($this->image),
            "status"=> "pending",
        ];
    }
}
