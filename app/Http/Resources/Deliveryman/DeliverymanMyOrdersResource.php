<?php

namespace App\Http\Resources\Deliveryman;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliverymanMyOrdersResource extends JsonResource
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
            "payment_method" => $this->orderMaster?->payment_gateway,
            "store" => $this->store?->name,
            "items" => $this->orderDetail->count(),
            "area_id" => $this->area_id,
            "invoice_number" => $this->invoice_number,
            "invoice_date" => $this->invoice_date,
            "order_type" => $this->order_type,
            "delivery_option" => $this->delivery_option,
            "delivery_type" => $this->delivery_type,
            "order_amount" => $this->order_amount,
            "status" => $this->status,
            "created_at" => $this->created_at->diffForHumans(),
        ];
    }
}
