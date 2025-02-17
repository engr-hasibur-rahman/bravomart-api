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
            'subtotal' => round($this->sum('line_total_price'), 2),
//            'product_discount_amount' => round($this->product_discount_amount, 2),
            'coupon_discount' => round($this->sum('coupon_discount_amount'), 2),
            'tax_rate' => round($this->sum('tax_rate'), 2) ?? 0,
            'total_tax_amount' => round($this->sum('total_tax_amount'), 2) ?? 0,
//            'shipping_charge' => round($this->shipping_charge, 2),
        ];
    }

}