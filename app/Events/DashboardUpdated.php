<?php

namespace App\Events;

use App\Models\Device;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DashboardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $device;
    public $notifications;

    public function __construct($device, $notifications)
    {
        $this->device = $device;
        $this->notifications = $notifications;
    }

    public function broadcastOn()
    {
        return new Channel("dashboard");
    }

    public function broadcastAs()
    {
        return "DashboardUpdated";
    }

    public function broadcastWith()
    {
        return [
            'device' => $this->device,
            'notifications' => $this->notifications
        ];
    }
}
