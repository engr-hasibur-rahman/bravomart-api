<?php

namespace App\Http\Resources\Store;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetailsForOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "phone" => $this->phone,
            "email" => $this->email,
            "store_type" => $this->store_type,
            "logo" => ImageModifier::generateImageUrl($this->logo),
            "tax" => $this->tax,
            "delivery_time" => $this->delivery_time
        ];
    }
}
