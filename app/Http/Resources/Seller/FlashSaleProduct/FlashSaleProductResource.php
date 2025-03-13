<?php

namespace App\Http\Resources\Seller\FlashSaleProduct;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class FlashSaleProductResource extends JsonResource
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
            "flash_sale" => $this->flashSale?->title,
            "end_time" => $this->flashSale ? Carbon::parse($this->flashSale->end_time)->diffForHumans() : null,
            "product" => $this->product?->name,
            "product_image" => ImageModifier::generateImageUrl($this->product?->image),
            "store" => $this->store?->name,
        ];
    }
}
