<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
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
                'store' => [
                    'icon' => 'store-icon',
                    'title' => 'Total Store',
                    'count' => $this->total_stores
                ],
                'store_owner' => [
                    'icon' => 'user-icon',
                    'title' => 'Total Seller',
                    'count' => $this->total_sellers
                ],
                'product' => [
                    'icon' => 'product-icon',
                    'title' => 'Total Product',
                    'count' => $this->total_products
                ],
                'order' => [
                    'icon' => 'order-icon',
                    'title' => 'Total Order',
                    'count' => $this->total_orders
                ],
                'customer' => [
                    'icon' => 'customer-icon',
                    'title' => 'Total Customer',
                    'count' => $this->total_customers
                ],
                'staff' => [
                    'icon' => 'staff-icon',
                    'title' => 'Total Staff',
                    'count' => $this->total_staff
                ],
            ],
            'order_summary' => [
                'pending_orders' => [
                    'icon' => 'pending-icon',
                    'title' => 'Pending Orders',
                    'count' => $this->total_pending_orders
                ],
                'completed_orders' => [
                    'icon' => 'completed-icon',
                    'title' => 'Completed Orders',
                    'count' => $this->total_delivered_orders
                ],
                'cancelled_orders' => [
                    'icon' => 'cancelled-icon',
                    'title' => 'Cancelled Orders',
                    'count' => $this->total_cancelled_orders
                ],
                'deliveryman_not_assigned_orders' => [
                    'icon' => 'unassigned-icon',
                    'title' => 'Unassigned Orders',
                    'count' => $this->deliveryman_not_assigned_orders
                ],
                'refunded_orders' => [
                    'icon' => 'refunded-icon',
                    'title' => 'Refunded Orders',
                    'count' => $this->total_refunded_orders
                ],
            ]
        ];
    }
}
