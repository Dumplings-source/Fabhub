<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderPlaced extends Notification
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
            ->subject('New Order Placed')
            ->line('A new order (#' . $this->order->id . ') has been placed for ' . $this->order->service->name . '.')
            ->action('View Order', url('/admin/orders'))
            ->line('Material: ' . $this->order->material)
            ->line('Quantity: ' . $this->order->quantity)
            ->line('Preferred Date: ' . $this->order->preferred_date);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New order #' . $this->order->id . ' placed for ' . $this->order->service->name,
            'order_id' => $this->order->id,
        ];
    }
}