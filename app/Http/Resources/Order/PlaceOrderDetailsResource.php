<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceOrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'customer_id' => $this->customer_id,
            'shipping_address_id' => $this->shipping_address_id,
            'order_amount' => $this->order_amount,
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'delivery_status' => $this->delivery_status,
            'order_notes' => $this->order_notes,
            'coupon_code' => $this->coupon_code,
            'created_at' => $this->created_at->toDateTimeString(),
            'order_packages' => OrderPackageResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
