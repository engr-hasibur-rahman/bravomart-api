<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Deliveryman\DeliverymanResource;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderResource extends JsonResource
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
            'order_date' => $this->created_at,
            'invoice_date' => $this->invoice_date,
            'order_type' => $this->order_type,
            'delivery_type' => $this->delivery_type,
            'shipping_type' => $this->shipping_type,
            'order_amount' => $this->order_amount,
            'product_discount_amount' => $this->product_discount_amount,
            'shipping_charge' => $this->shipping_charge,
            'is_reviewed' => $this->is_reviewed,
            'confirmed_by' => $this->confirmed_by,
            'confirmed_at' => $this->confirmed_at,
            'cancel_request_at' => $this->cancel_request_at,
            'cancelled_at' => $this->cancelled_at,
            'delivery_completed_at' => $this->delivery_completed_at,
            'payment_status' => $this->orderMaster->payment_status,
            'status' => $this->status,
            'refund_status' => $this->refund_status,
            'store' => new StoreDetailsForOrderResource($this->whenLoaded('store')),
            'deliveryman' => new DeliverymanResource($this->whenLoaded('deliveryman')),
            'order_master' => new OrderMasterResource($this->whenLoaded('orderMaster')),
            'order_details' => OrderDetailsResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
