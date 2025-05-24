<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Deliveryman\DeliverymanResource;
use App\Http\Resources\Seller\Store\StoreDetailsPublicResource;
use App\Http\Resources\Seller\Store\StoreDetailsResource;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
use App\Models\Order;
use App\Models\User;
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
            'order_id' => $this->id,
            'store' => $this->store->name ?? null,
            'customer_name' => $this->orderMaster->customer->first_name . ' ' . $this->orderMaster->customer->last_name ?? null,
            'invoice_number' => $this->invoice_number,
            'order_date' => $this->created_at->format('F d, Y h:i a'),
            'invoice_date' => $this->invoice_date,
            'order_type' => $this->order_type,
            'delivery_option' => $this->delivery_option,
            'delivery_type' => $this->delivery_type,
            'delivery_time' => $this->delivery_time,
            'order_amount' => $this->order_amount,
            'product_discount_amount' => $this->product_discount_amount,
            'shipping_charge' => $this->shipping_charge,
            'additional_charge_name' => $this->order_additional_charge_name,
            'additional_charge_amount' => $this->order_additional_charge_amount,
            'is_reviewed' => $this->is_reviewed,
            'confirmed_by' => $this->confirmed_by,
            'confirmed_at' => $this->confirmed_at,
            'cancel_request_at' => $this->cancel_request_at,
            'cancelled_at' => $this->cancelled_at,
            'delivery_completed_at' => $this->delivery_completed_at,
            'payment_status' => $this->orderMaster->payment_status,
            'status' => $this->status,
            'refund_status' => $this->refund_status,
            'store_details' => new StoreDetailsForOrderResource($this->whenLoaded('store')),
            'deliveryman' => new DeliverymanResource($this->whenLoaded('deliveryman')),
            'deliveryman_review_status' => auth('api_customer')->check() &&
                Order::isReviewedByCustomer(
                    auth('api_customer')->user()->id,
                    $this->order_id,
                    $this->confirmed_by,
                    User::class),
            'order_master' => new OrderMasterResource($this->whenLoaded('orderMaster')),
            'order_details' => OrderDetailsResource::collection($this->whenLoaded('orderDetail')),
        ];
    }
}
