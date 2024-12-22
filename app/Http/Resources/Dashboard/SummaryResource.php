<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'store' => [
                'icon' => 'store-icon',
                'title' => 'Total Store',
                'count' => $this->storeCount
            ],
            'store_owner' => [
                'icon' => 'user-icon',
                'title' => 'Total Store Admin',
                'count' => $this->storeOwnerCount
            ],
            'product' => [
                'icon' => 'product-icon',
                'title' => 'Total Product',
                'count' => $this->productCount
            ],
            'order'=>[
                'icon' => 'order-icon',
                'title' => 'Total Order',
                'count' => $this->orderCount
            ]
        ];
    }
}
