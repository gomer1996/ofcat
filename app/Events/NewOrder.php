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
use App\DTO\CheckoutDTO;

class NewOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CheckoutDTO $checkoutDTO;
    public Collection $cartContent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CheckoutDTO $checkoutDTO, Collection $cartContent)
    {
        $this->checkoutDTO = $checkoutDTO;
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
