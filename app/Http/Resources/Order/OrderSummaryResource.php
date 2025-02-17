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
            'subtotal' => round($this->orderDetail->sum('line_total_price'), 2),
            'coupon_discount' => round($this->orderDetail->sum('coupon_discount_amount'), 2),
            'tax_rate' => round($this->orderDetail->sum('tax_rate'), 2) ?? 0,
            'total_tax_amount' => round($this->orderDetail->sum('total_tax_amount'), 2) ?? 0,

            // Fetch data from Order model
            'product_discount_amount' => round($this->product_discount_amount, 2),
            'shipping_charge' => round($this->shipping_charge, 2),

            // Fetch data from OrderMaster relation
            'additional_charge' => round(optional($this->orderMaster)->additional_charge, 2) ?? 0,
        ];
    }


}