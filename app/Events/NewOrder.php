<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public Collection $cartContent;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(?User $user, Collection $cartContent)
    {
        $this->user = $user;
        $this->cartContent = $cartContent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
