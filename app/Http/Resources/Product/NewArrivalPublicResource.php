<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewArrivalPublicResource extends JsonResource
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
            'store' => $this->store,
            'name' => $this->name,
            'description' => $this->description,
            'variants' => $this->variants,
            'available_status' => $this->variants->where('stock_quantity', '>', 0)->isNotEmpty() ? true : false,
        ];
    }
}
