<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminQueriesResource extends JsonResource
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
            "product_id" => $this->product_id,
            "customer_id" => $this->customer_id,
            "question" => $this->question,
            "seller_id" => $this->seller_id,
            "reply" => $this->reply,
            "replied_at" => $this->replied_at,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "product" => $this->product->name ?? null,
            "product_image" => $this->product->image ?? null,
            "product_image_url" => ImageModifier::generateImageUrl($this->product->image) ?? null,
            "customer" => $this->customer->getFullNameAttribute() ?? null,
            "seller" => $this->seller->getFullNameAttribute() ?? null,
        ];
    }
}
