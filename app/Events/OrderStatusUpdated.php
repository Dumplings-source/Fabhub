<?php
namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load(['service']);
    }

    public function broadcastOn()
    {
        // Broadcast to a private channel for the specific user
        return new Channel('user-' . $this->order->user_id);
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order,
            'message' => 'Your order #' . $this->order->id . ' for ' . $this->order->service->name . ' is now ' . $this->order->status . '.'
        ];
    }
} 