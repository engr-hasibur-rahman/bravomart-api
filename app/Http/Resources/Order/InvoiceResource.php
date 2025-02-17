<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $subtotal = round($this->orderDetail->sum('line_total_price'), 2);
        $coupon_discount = round($this->orderDetail->sum('coupon_discount_amount'), 2);
        $total_tax_amount = round($this->orderDetail->sum('total_tax_amount'), 2);
        $product_discount_amount = round($this->product_discount_amount, 2);
        $shipping_charge = round($this->shipping_charge, 2);
        $additional_charge = round(optional($this->orderMaster)->additional_charge, 2) ?? 0;

        // Total Amount Calculation
        $total_amount = ($subtotal - $coupon_discount - $product_discount_amount)
            + $total_tax_amount
            + $shipping_charge
            + $additional_charge;

        return [
            'customer' => $this->orderMaster->customer ? [
                'name' => $this->orderMaster->customer->first_name . ' ' . $this->orderMaster->customer->last_name,
                'email' => $this->orderMaster->customer->email,
                'phone' => $this->orderMaster->customer->phone,
                'shipping_address' => $this->orderMaster->shippingAddress ? [
                    'house' => $this->orderMaster->shippingAddress->house,
                    'road' => $this->orderMaster->shippingAddress->road,
                    'floor' => $this->orderMaster->shippingAddress->floor,
                    'address' => $this->orderMaster->shippingAddress->address,
                    'postal_code' => $this->orderMaster->shippingAddress->postal_code,
                    'contact' => $this->orderMaster->shippingAddress->contact_number
                ] : null
            ] : null,
            'invoice_number' => '#' . $this->invoice_number,
            'invoice_date' => $this->invoice_date ? Carbon::parse($this->invoice_date)->format('d-M-Y') : null,
            'payment_status' => $this->orderMaster->payment_status,
            'items' => $this->orderDetail->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'description' => $item->product->description,
                    'quantity' => $item->quantity,
                    'amount' => $item->line_total_price,
                    'tax_rate' => $item->tax_rate,
                    'tax_amount' => $item->tax_amount,
                    'total_tax_amount' => $item->total_tax_amount,
                ];
            }),
            'subtotal' => $subtotal,
            'coupon_discount' => $coupon_discount,
            'tax_rate_sum' => round($this->orderDetail->sum('tax_rate'), 2),
            'total_tax_amount' => $total_tax_amount,
            'product_discount_amount' => $product_discount_amount,
            'shipping_charge' => $shipping_charge,
            'additional_charge' => $additional_charge,
            'total_amount' => round($total_amount, 2), // Final total amount
        ];
    }
}
