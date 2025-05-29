<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Status Updated')
            ->line('Your order (#' . $this->order->id . ') for ' . $this->order->service->name . ' is now ' . $this->order->status . '.')
            ->action('View Orders', url('/dashboard'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Order #' . $this->order->id . ' status updated to ' . $this->order->status,
            'order_id' => $this->order->id,
        ];
    }
}
