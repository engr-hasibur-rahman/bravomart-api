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
            'subtotal' => round($orderDetails->sum('line_total_price'), 2) ?? 0,
            'product_discount_amount' => round($this->first()->order->product_discount_amount, 2) ?? 0,
            'shipping_charge' => round($this->first()->order->shipping_charge, 2) ?? 0,
            'additional_charge_amount' => round($this->first()->order->orderMaster->additional_charge_amount,2) ?? 0,
            'tax_rate_sum' => round($orderDetails->sum('tax_rate'), 2) ?? 0,
            'tax_amount_sum' => round($orderDetails->sum('tax_amount'), 2) ?? 0,
            'total_tax_amount_sum' => round($orderDetails->sum('total_tax_amount'), 2) ?? 0,
            'total' => round($orderDetails->sum('line_total_price') + $orderDetails->sum('total_tax_amount'), 2) ?? 0,
        ];
    }

}