<?php

namespace App\Http\Resources\Deliveryman;

use App\Http\Resources\Customer\CustomerDetailsResource;
use App\Http\Resources\Order\CustomerOrderResource;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
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
            "order_id" => $this->order->id,
            "payment_method" => $this->order?->orderMaster?->payment_gateway,
            "store" => new StoreDetailsForOrderResource($this->order?->store),
            "customer" => new CustomerDetailsResource($this->order?->orderMaster?->customer),
            "order_address" => $this->order?->orderMaster?->orderAddress->address,
            "items" => $this->order?->orderDetail->count(),
            "invoice_number" => $this->order?->invoice_number,
            "invoice_date" => $this->order?->invoice_date,
            "order_type" => $this->order?->order_type,
            "delivery_option" => $this->order?->delivery_option,
            "delivery_type" => $this->order?->delivery_type,
            "order_amount" => $this->order?->order_amount,
            "status" => $this->order?->status,
            "created_at" => optional($this->order->created_at)->format('h:i A, F j, Y'), // Example: "8:00 AM, May 29, 2025"
        ];
    }
}
