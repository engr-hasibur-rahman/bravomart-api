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
        return [
            'customer' => $this->customer ? [
                'name' => $this->customer->first_name . ' ' . $this->customer->last_name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
                'shipping_address' => $this->shippingAddress ? [
                    'house' => $this->shippingAddress->house,
                    'road' => $this->shippingAddress->road,
                    'floor' => $this->shippingAddress->floor,
                    'address' => $this->shippingAddress->address,
                    'postal_code' => $this->shippingAddress->postal_code,
                    'contact' => $this->shippingAddress->contact_number
                ] : null
            ] : null,
            'invoice_number' => '#' . $this->invoice_number,
            'invoice_date' => $this->invoice_date ? Carbon::parse($this->invoice_date)->format('d-M-Y') : null,
            'payment_status' => $this->payment_status,
            'order_amount' => round($this->orderDetails->sum('line_total_price'), 2),
            'items' => $this->orderDetails->map(function ($item) {
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
            'subtotal' => round($this->orderDetails->sum('line_total_price'), 2),
            'tax_rate_sum' => round($this->orderDetails->sum('tax_rate'), 2),
            'tax_amount_sum' => round($this->orderDetails->sum('tax_amount'),2),
            'total_tax_amount_sum' => round($this->orderDetails->sum('total_tax_amount'), 2),
            'total' => round($this->orderDetails->sum('line_total_price') + $this->orderDetails->sum('total_tax_amount'), 2),
        ];
    }
}
