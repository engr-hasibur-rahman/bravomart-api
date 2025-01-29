<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFlashSaleResource extends JsonResource
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
            "title" => $this->title,
            "thumbnail_image" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "discount_type" => $this->discount_type,
            "discount_price" => $this->discount_price,
            "special_price" => $this->special_price,
            "purchase_limit" => $this->purchase_limit,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "status" => $this->status,
        ];
    }
}
