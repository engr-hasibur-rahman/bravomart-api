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
        return [
            'id' => $this->id,
            'area' => $this->area->name ?? null,
            'merchant' => new SellerDetailsPublicResource($this->merchant),
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
