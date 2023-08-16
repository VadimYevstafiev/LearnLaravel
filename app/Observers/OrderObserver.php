<?php

namespace App\Observers;

use App\Models\Order;
use App\Jobs\OrderUpdatedNotifyJob;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->attributesToArray()['status_id'] != $order->getOriginal()['status_id']) {
            //dd('bingo!');
            OrderUpdatedNotifyJob::dispatch($order)->onQueue('notifications')->delay(now()->addSeconds(10));
        }
    }
}
