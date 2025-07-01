<?php

namespace App\Observers;

use App\Jobs\DispatchOrderEmails;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Dispatch the job to send emails when the order is created
//        dispatch(new DispatchOrderEmails($order->id, 'new-order'));
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if the order status has changed
        if ($order->isDirty('status')) {
            // check which guard is being used
            if (auth()->guard('api_customer')->check()) {
                $user = auth()->guard('api_customer')->user();
                dispatch(new DispatchOrderEmails($order->id, 'order-status-change-deliveryman'));
            } elseif (auth()->guard('api')->check()) {
                $user = auth()->guard('api')->user();
            }

            // Check if the user is a seller, admin, customer, or deliveryman
            if ($user->activity_scope === 'store_level') {
                dispatch(new DispatchOrderEmails($order->id, 'order-status-change-store'));
            } elseif ($user->activity_scope === 'system_level') {
                dispatch(new DispatchOrderEmails($order->id, 'order-status-change-admin'));
            } elseif ($user->activity_scope === 'delivery_level') {
                dispatch(new DispatchOrderEmails($order->id, 'order-status-change-customer'));
            }
        }
        // If the order is refunded or cancelled then restore the product quantity
        if ($order->isDirty('refund_status') && $order->refund_status === 'refunded' ||
            $order->isDirty('status') && $order->refund_status === 'cancelled')
        {
            DB::transaction(function () use ($order) {
                foreach ($order->orderDetail as $detail) {
                    if ($detail->productVariant) {
                        $detail->productVariant->increment('stock_quantity', $detail->quantity);
                    }
                }
            });
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
