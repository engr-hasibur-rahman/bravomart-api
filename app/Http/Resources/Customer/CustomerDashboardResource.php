<?php

namespace App\Http\Resources\Customer;

use App\Actions\ImageModifier;
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
            'total_support_ticket' => $this['total_support_ticket'],
            'wallet' => $this['wallet'],
            'recent_orders' => collect($this['recent_orders'])->map(function ($orderDetail) {
                return [
                    'product_image' =>  ImageModifier::generateImageUrl($orderDetail['product']['image']), // Product image
                    'product_name' => $orderDetail['product']['name'] ?? null, // Product name
                    'order_id' => $orderDetail['order_id'],
                    'purchased_at' => $orderDetail['order']['created_at'], // Order placement timestamp
                    'status' => $orderDetail['order']['status'] ?? null, // Order status
                ];
            }),
        ];
    }
}
