<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use App\Http\Resources\Com\Store\StorePublicDropdownResource;
use App\Http\Resources\Translation\FlashSaleTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFlashSaleDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $translation = $this->related_translations->where('language', $language);
        return [
            "id" => $this->id,
            "products" => $this->products->map(function ($flashSaleProduct) {
                return [
                    'id' => $flashSaleProduct->product->id,
                    'value' => $flashSaleProduct->product->id,
                    'label' => $flashSaleProduct->product->name,
                    'image' => ImageModifier::generateImageUrl($flashSaleProduct->product->image),
                ];
            }),
            "title" => $this->title,
            "description" => $this->description,
            "thumbnail_image" => $this->thumbnail_image,
            "thumbnail_image_url" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "cover_image" => $this->cover_image,
            "cover_image_url" => ImageModifier::generateImageUrl($this->cover_image),
            "discount_type" => $this->discount_type,
            "discount_amount" => $this->discount_amount,
            "special_price" => $this->special_price,
            "purchase_limit" => $this->purchase_limit,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "status" => $this->status,
            "related_translations" => FlashSaleTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
