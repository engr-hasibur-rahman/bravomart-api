<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerStoreSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'summary' => [
                'product' => [
                    'icon' => 'product-icon',
                    'title' => 'Total Product',
                    'count' => $this->total_product
                ],
                'order' => [
                    'icon' => 'order-icon',
                    'title' => 'Total Order',
                    'count' => $this->total_order
                ],
                'staff' => [
                    'icon' => 'staff-icon',
                    'title' => 'Total Staff',
                    'count' => $this->total_stuff
                ],
            ],
            'order_summary' => [
                'pending_orders' => [
                    'icon' => 'pending-icon',
                    'title' => 'Pending Orders',
                    'count' => $this->pending_orders
                ],
                'completed_orders' => [
                    'icon' => 'completed-icon',
                    'title' => 'Completed Orders',
                    'count' => $this->completed_orders
                ],
                'cancelled_orders' => [
                    'icon' => 'cancelled-icon',
                    'title' => 'Cancelled Orders',
                    'count' => $this->cancelled_orders
                ],
                'deliveryman_not_assigned_orders' => [
                    'icon' => 'unassigned-icon',
                    'title' => 'Unassigned Orders',
                    'count' => $this->deliveryman_not_assigned_orders
                ],
                'refunded_orders' => [
                    'icon' => 'refunded-icon',
                    'title' => 'Refunded Orders',
                    'count' => $this->refunded_orders
                ],
            ]
        ];
    }
}
