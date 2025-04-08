<?php

namespace App\Events;

use App\Models\Order;
use App\Models\OrderMaster;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


//    public $orderMaster;
    public $order;

//    public function __construct(OrderMaster $orderMaster)
//    {
//        $this->orderMaster = $orderMaster;
//    }

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing(['store', 'orderMaster.customer', 'orderMaster.orderAddress']);
    }

//    public function broadcastOn()
//    {
//        Log::info('broadcastOn method called');
//        return new Channel('orders');
//    }
//
//    public function broadcastWith()
//    {
//        // find order master
//        $order_master = OrderMaster::with('orderAddress','customer')->find($this->orderMaster->id);
//
//        return [
//            'order_master_id' => $this->orderMaster->id,
//            'order_details' => $this->orderMaster->id,
//        ];
//    }

    public function broadcastOn()
    {
        $channels = [];

        // Safe check: orderMaster exists
        if ($this->order->orderMaster && $this->order->orderMaster->customer_id) {
            $channels[] = new Channel('customer.' . $this->order?->orderMaster?->customer_id ?? 0);
        }

        // Safe check: store & seller exist
        if ($this->order->store && $this->order->store->seller_id) {
            $channels[] = new Channel('seller.' . $this->order->store?->seller_id ?? 0);
        }

        // Always notify admin
        $channels[] = new Channel('admin');

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'store_id' => $this->order?->store_id,
            'seller_id' => optional($this->order->store)->seller_id ?? 0,
            'customer_id' => optional($this->order->orderMaster)->customer_id ?? 0,
            'order_details' => $this->order,
            'message' => 'Order ID #' . $this->order->id . ' placed successfully.',
        ];
    }


}
