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
        $orderDetails = $this->resource; // Access the full collection

        return [
            'subtotal' => round($orderDetails->sum('line_total_price'), 2),
            'coupon_discount' => round($orderDetails->sum('coupon_discount_amount'), 2),
            'tax_rate_sum' => round($orderDetails->sum('tax_rate'), 2),
            'tax_amount_sum' => round($orderDetails->sum('tax_amount'), 2),
            'total_tax_amount_sum' => round($orderDetails->sum('total_tax_amount'), 2),
            'total' => round($orderDetails->sum('line_total_price') + $orderDetails->sum('total_tax_amount'), 2),
            'master' => $orderDetails->order
        ];
    }

}