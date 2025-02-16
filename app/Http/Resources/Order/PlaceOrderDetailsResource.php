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
            'invoice_number' => $this->invoice_number,
            'invoice_date' =>  optional($this->invoice_date)->toDateTimeString(),
            'order_type' => $this->order_type,
            'delivery_type' => $this->delivery_type,
            'delivery_option' => $this->delivery_option,
            'shipping_charge' => $this->shipping_charge,
            'additional_charge_name' => $this->additional_charge_name,
            'additional_charge_amount' => $this->additional_charge_amount,
            'additional_charge_commission' => $this->additional_charge_commission,
            'order_amount' => $this->order_amount,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
