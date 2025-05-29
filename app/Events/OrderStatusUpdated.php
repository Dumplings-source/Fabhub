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
    public $previousStatus;

    public function __construct(Order $order, $previousStatus = null)
    {
        $this->order = $order->load(['service']);
        $this->previousStatus = $previousStatus;
    }

    public function broadcastOn()
    {
        // Broadcast to a private channel for the specific user
        return new Channel('user-' . $this->order->user_id);
    }

    /**
     * Get the event broadcasting name.
     */
    public function broadcastAs()
    {
        return 'order.status.updated';
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order,
            'previousStatus' => $this->previousStatus,
            'currentStatus' => $this->order->status,
            'message' => 'Your order #' . $this->order->id . ' for ' . $this->order->service->name . ' is now ' . $this->order->status . '.'
        ];
    }
} 