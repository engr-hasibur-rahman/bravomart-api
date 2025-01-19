<?php

namespace App\Http\Resources\Com\Store;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorePublicListResource extends JsonResource
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
            'area' => $this->area->name ?? null,
            'merchant' => $this->merchant->first_name . '' . $this->merchant->last_name,
            'store_type' => $this->store_type,
            'name' => $this->name,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo' => $this->logo,
            'logo_url' => ImageModifier::generateImageUrl($this->logo),
            'banner' => $this->banner,
            'banner_url' => ImageModifier::generateImageUrl($this->banner),
            'address' => $this->address,
            'is_featured' => $this->is_featured,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'veg_status' => $this->veg_status,
            'off_day' => $this->off_day,
        ];
    }
}
