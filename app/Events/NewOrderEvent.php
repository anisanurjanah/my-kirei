<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $role;
    public $username;
    public $outlet_code;

    /**
     * Create a new event instance.
     */
    public function __construct($order, $role = null, $username = null, $outlet_code = null)
    {
        $this->order = $order;
        $this->role = $role;
        $this->username = $username;
        $this->outlet_code = $outlet_code;

        Log::info('NewOrderEvent constructed', [
            'order_number' => $order->order_number,
            'role' => $role,
            'username' => $username,
            'outlet_code' => $outlet_code
        ]);
    }

    public function broadcastOn()
    {
        if ($this->username === 'administrator') {
            return new PrivateChannel('orders.administrator');
        }

        if ($this->role && $this->outlet_code) {
            return new PrivateChannel("orders.outlet.{$this->outlet_code}.{$this->role}");
        }

        return new PrivateChannel('orders');
    }

    public function broadcastWith()
    {
        return ['order' => $this->order];
    }
}
