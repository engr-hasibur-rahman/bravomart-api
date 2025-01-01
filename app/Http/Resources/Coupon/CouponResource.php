<?php

namespace App\Http\Resources\Coupon;

use App\Http\Resources\Com\Translation\ProductTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created_by' => $this->creator->first_name,
            "translations" => CouponTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
