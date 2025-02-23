<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "customer_note" => $this->customer_note,
            "status" => $this->status,
            "amount" => $this->amount,
            "store" => $this->store?->name,
            "customer" => $this->customer?->getFullNameAttribute(),
            "order_refund_reason" => $this->orderRefundReason?->reason,
            "file" => asset('storage/' . $this->file) ?? null
        ];
    }
}
