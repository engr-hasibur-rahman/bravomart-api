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
        //return parent::toArray($request);
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
            'order_amount' => $this->orderPackages->map->order_amount->sum(),
            'packages' => $this->orderPackages->flatMap(function ($package) {
                $subtotal = 0;
                $tax_rate_sum = 0;
                $tax_amount_sum = 0;
                $total_tax_amount_sum = 0;
                $items = $package->orderDetails->map(function ($item) use (&$subtotal, &$tax_rate_sum, &$tax_amount_sum, &$total_tax_amount_sum) {
                    $subtotal += $item->line_total_price;
                    $tax_rate_sum += $item->tax_rate;
                    $tax_amount_sum += $item->tax_amount;
                    $total_tax_amount_sum += $item->total_tax_amount;
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
                });
                return array_merge($items->toArray(), [
                    'subtotal' => $subtotal,
                    'tax_rate_sum' => $tax_rate_sum,
                    'tax_amount_sum' => $tax_amount_sum,
                    'total_tax_amount_sum' => $total_tax_amount_sum,
                    'total' => $subtotal + $total_tax_amount_sum,
                ]);
            }),
        ];
    }
}
