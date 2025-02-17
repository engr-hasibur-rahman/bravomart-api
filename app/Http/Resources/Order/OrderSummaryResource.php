<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subtotal' => round($this->orderDetail?->line_total_price),
            'product_discount_amount' => round($this->product_discount_amount, 2),
            'coupon_discount' => round($this->coupon_discount_amount, 2),
            'tax_rate' => $this->orderDetail?->tax_rate ?? 0,
            'total_tax_amount' => $this->orderDetail?->total_tax_amount ?? 0,
            'shipping_charge' => round($this->shipping_charge, 2),
        ];
    }

}