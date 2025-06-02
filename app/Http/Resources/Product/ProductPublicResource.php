<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Product\ProductUnitPublicResource;
use App\Http\Resources\Com\Translation\ProductTranslationResource;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
use App\Http\Resources\Tag\TagPublicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        // Filter variants by price range in the resource
//        $filteredVariants = $this->variants->filter(function ($variant) use ($request) {
//            // Apply the price range filter
//            return (!$request->min_price || $variant->price >= $request->min_price) &&
//                (!$request->max_price || $variant->price <= $request->max_price);
//        });
//
//        // Get the first filtered variant, or null if no variants match the price range
//        $firstVariant = $filteredVariants->first();
        $firstVariant = $this->variants->first();

        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $translation = $this->related_translations->where('language', $language);

        return [
            'id' => $this->id,
            'store' => new StoreDetailsForOrderResource($this->whenLoaded('store')),
            'store_id' => $this->store->id ?? null,
            'name' => !empty($translation) && $translation->where('key', 'name')->first()
                ? $translation->where('key', 'name')->first()->value
                : $this->name, // If language is empty or not provided attribute
            'slug' => $this->slug,
            'description' => !empty($translation) && $translation->where('key', 'description')->first()
                ? $translation->where('key', 'description')->first()->value
                : $this->description, // If language is empty or not provided attribute
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
            'rating' => number_format((float)$this->rating, 2, '.', ''),
            'review_count' => $this->review_count,
            'stock' => $this->variants->isNotEmpty() ? $this->variants->sum('stock_quantity') : null,
            'attributes' => $this->variants->pluck('attributes')->map(function ($attribute) {
                return json_decode($attribute, true);
            })->toArray(),
            'effective_price' => optional($firstVariant)->effective_price
                ?? (
                optional($firstVariant)->special_price && optional($firstVariant)->special_price < optional($firstVariant)->price
                    ? optional($firstVariant)->special_price
                    : optional($firstVariant)->price
                ),
            'price' => optional($firstVariant)->price,
            'special_price' => optional($firstVariant)->special_price,
//            'singleVariant' => $filteredVariants->count() === 1 ? [$firstVariant] : [],
            'singleVariant' => $this->variants->count() === 1 ? [$firstVariant] : [],
            'discount_percentage' => $firstVariant && $firstVariant->price > 0 && $firstVariant->special_price > 0
                ? round((($firstVariant->price - $firstVariant->special_price) / $firstVariant->price) * 100, 2)
                : 0,
            'flash_sale' => $this->isInFlashDeal(),
            'is_featured' => (bool)$this->is_featured

        ];
    }
}
