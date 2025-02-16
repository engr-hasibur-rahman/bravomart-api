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
            'tax_rate_sum' => round($this->sum('tax_rate'), 2),
            'tax_amount_sum' => round($this->sum('tax_amount'),2),
            'total_tax_amount_sum' => round($this->sum('total_tax_amount'), 2),
            'total' => round($this->sum('line_total_price') + $this->sum('total_tax_amount'), 2),
        ];
    }

}