<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Deliveryman\DeliverymanResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'shipping_address_id' => $this->shipping_address_id,
            'shipping_time_preferred' => $this->shipping_time_preferred,
            'delivery_status' => $this->delivery_status,
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'order_notes' => $this->order_notes,
            'order_amount' => $this->order_amount,
            'coupon_code' => $this->coupon_code,
            'coupon_title' => $this->coupon_title,
            'coupon_disc_amt_store' => $this->coupon_disc_amt_store,
            'product_discount_amount' => $this->product_discount_amount,
            'shipping_charge' => $this->shipping_charge,
            'additional_charge_name' => $this->additional_charge_name,
            'additional_charge' => $this->additional_charge,
            'confirmed_by' => $this->confirmed_by,
            'confirmed_at' => $this->confirmed_at,
            'cancel_request_at' => $this->cancel_request_at,
            'cancelled_at' => $this->cancelled_at,
            'delivery_completed_at' => $this->delivery_completed_at,
            'refund_status' => $this->refund_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deliveryman' => new DeliverymanResource($this->whenLoaded('deliveryman')),
            'order_packages' => CustomerOrderPackageResource::collection($this->whenLoaded('orderPackages')),
            'order_payment' => new CustomerOrderPaymentResource($this->whenLoaded('orderPayment')),
        ];
    }
}
