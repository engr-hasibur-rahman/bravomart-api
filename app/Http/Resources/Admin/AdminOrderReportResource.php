<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderReportResource extends JsonResource
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
            "store" => $this->store->name ?? null,
            "area" => $this->area->name ?? null,
            "customer" => $this->order ? ($this->order->customer ? $this->order->customer->first_name . ' ' . $this->order->customer->last_name : null) : null,
            "payment_gateway" => $this->order ? $this->order->payment_gateway : null,
            "payment_status" => $this->order ? $this->order->payment_status : null,
            "order_amount" => $this->order ? $this->order->order_amount : null,
            "coupon_discount_amount_admin" => $this->order ? $this->order->coupon_discount_amount_admin : null,
            "product_discount_amount" => $this->order ? $this->order->product_discount_amount : null,
            "flash_discount_amount_admin" => $this->order ? $this->order->flash_discount_amount_admin : null,
            "shipping_charge" => $this->order ? $this->order->shipping_charge : null,
            "additional_charge_amount" => $this->order ? $this->order->additional_charge_amount : null,
            "refund_status" => $this->order ? $this->order->refund_status : null,
            "status" => $this->order ? $this->order->status : null,
            "base_price" => $this->base_price,
            "price" => $this->price,
            "quantity" => $this->quantity,
            "line_total_price_with_qty" => $this->line_total_price_with_qty,
            "line_total_excluding_tax" => $this->line_total_excluding_tax,
            "tax_rate" => $this->tax_rate,
            "tax_amount" => $this->tax_amount,
            "total_tax_amount" => $this->total_tax_amount,
            "line_total_price" => $this->line_total_price,
            "admin_commission_type" => $this->admin_commission_type,
            "admin_commission_rate" => $this->admin_commission_rate,
            "admin_commission_amount" => $this->admin_commission_amount,
        ];
    }
}
