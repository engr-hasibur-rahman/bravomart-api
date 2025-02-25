<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliverymanDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_summary' => [
                'total_completed_orders' => [
                    'icon' => 'store-icon',
                    'title' => 'Total Completed Orders',
                    'count' => $this->total_completed_orders
                ],
                'ongoing_orders' => [
                    'icon' => 'store-icon',
                    'title' => 'Active Orders',
                    'count' => $this->ongoing_orders
                ],
                'pending_orders' => [
                    'icon' => 'store-icon',
                    'title' => 'Pending Orders',
                    'count' => $this->pending_orders
                ],
                'cancelled_orders' => [
                    'icon' => 'store-icon',
                    'title' => 'Cancelled Orders',
                    'count' => $this->cancelled_orders
                ],
            ],
            'collection_summary' => [
                'total_cash_collection' => [
                    'icon' => 'store-icon',
                    'title' => 'Total Cash Collection',
                    'count' => $this->total_cash_collection
                ],
                'total_cash_deposit' => [
                    'icon' => 'store-icon',
                    'title' => 'Total Cash Deposit',
                    'count' => $this->total_cash_deposit
                ],
                'cash_in_hand' => [
                    'icon' => 'store-icon',
                    'title' => 'Cash In Hand',
                    'count' => $this->in_hand
                ]
            ],
            'active_orders' => $this->active_orders,
            'wallet' => $this->wallet
        ];
    }
}
