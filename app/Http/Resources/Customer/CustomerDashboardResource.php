<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'wishlist_count' => $this['wishlist_count'],
            'total_orders' => $this['total_orders'],
            'pending_orders' => $this['pending_orders'],
            'canceled_orders' => $this['canceled_orders'],
            'on_hold_products' => $this['on_hold_products'],
            'recent_orders' => $this['recent_orders'],
        ];
    }
}
