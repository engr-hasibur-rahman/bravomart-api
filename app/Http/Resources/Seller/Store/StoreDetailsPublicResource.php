<?php

namespace App\Http\Resources\Seller\Store;

use App\Actions\ImageModifier;
use App\Http\Resources\Com\Seller\SellerDetailsPublicResource;
use App\Http\Resources\Product\NewArrivalPublicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetailsPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $translation = $this->related_translations->where('language', $language);
        return [
            'id' => $this->id,
            'area' => $this->area->name ?? null,
            'seller' => new SellerDetailsPublicResource($this->seller),
            'store_type' => $this->store_type,
            'name' => $translation->isNotEmpty()
                ? $translation->where('key', 'name')->first()?->value
                : $this->name,
            'slug' => $translation->isNotEmpty()
                ? $translation->where('key', 'slug')->first()?->value
                : $this->slug,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo' => $this->logo,
            'tax' => $this->tax,
            'delivery_time' => $this->delivery_time,
            'logo_url' => ImageModifier::generateImageUrl($this->logo),
            'banner' => $this->banner,
            'banner_url' => ImageModifier::generateImageUrl($this->banner),
            'address' => $translation->isNotEmpty()
                ? $translation->where('key', 'address')->first()?->value
                : $this->address,
            'is_featured' => $this->is_featured,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'veg_status' => $this->veg_status,
            'off_day' => $this->off_day,
            'total_product' => $this->products()->where('deleted_at', null)->where('status', 'approved')->count(),
            'all_products' => StoreProductListPublicResource::collection($this->products()
                ->where('deleted_at', null)
                ->where('status', 'approved')
                ->with(['variants' => function ($query) {
                    $query->take(1);
                }])
                ->latest()
                ->get()),
            'featured_products' => StoreProductListPublicResource::collection($this->products()
                ->where('deleted_at', null)
                ->where('status', 'approved')
                ->with(['variants' => function ($query) {
                    $query->take(1);
                }])
                ->inRandomOrder()
                ->take(10)
                ->get()),
        ];
    }
}
