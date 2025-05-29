<?php

namespace App\Events;

use App\Models\Service;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewServiceAdded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function broadcastOn()
    {
        return new Channel('admin');
    }

    public function broadcastWith()
    {
        return [
            'service' => $this->service
        ];
    }
}
