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
                'shipping_address' => $this->shippingAddress ?
                    "{$this->shippingAddress->house}, Road {$this->shippingAddress->road}, Floor {$this->shippingAddress->floor}\n" .
                    "{$this->shippingAddress->address}\n" .
                    "Postal Code: {$this->shippingAddress->postal_code}\n" .
                    "Contact: {$this->shippingAddress->contact_number}" : null,
            ] : null,
            'invoice_number' => '#' . $this->invoice_number,
            'invoice_date' => $this->invoice_date ? Carbon::parse($this->invoice_date)->format('d-M-Y') : null,
            'payment_status' => $this->payment_status,
            'order_amount' => $this->orderPackages->map->order_amount->sum(),
            'packages' => $this->orderPackages,
            'items' => $this->orderPackages->map(function ($package) {
                return $package->orderDetails->map(function ($item) {
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
            }),
        ];
    }
}
