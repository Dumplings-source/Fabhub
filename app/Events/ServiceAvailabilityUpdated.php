<?php

namespace App\Events;

use App\Models\Service;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ServiceAvailabilityUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $service;
    public $previousAvailability;

    public function __construct(Service $service, $previousAvailability = null)
    {
        $this->service = $service;
        $this->previousAvailability = $previousAvailability;
    }

    public function broadcastOn()
    {
        // Broadcast to both admin and public channels
        return [
            new Channel('admin'),
            new Channel('services')
        ];
    }

    /**
     * Get the event broadcasting name.
     */
    public function broadcastAs()
    {
        return 'service.availability.updated';
    }

    public function broadcastWith()
    {
        return [
            'service' => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'availability' => $this->service->availability,
                'description' => $this->service->description,
                'price' => $this->service->price,
            ],
            'previousAvailability' => $this->previousAvailability,
            'currentAvailability' => $this->service->availability,
            'message' => $this->service->name . ' is now ' . ($this->service->availability ? 'available' : 'unavailable')
        ];
    }
} 