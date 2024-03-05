<?php

namespace App\Listeners;

use App\Events\NewOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        if ($event->user) {
            try {
                Mail::to($event->user->email)->send(new \App\Mail\OrderConfirmMail());
            } catch (\Throwable $E) {
                Log::critical('Error while sending confirmation email ' . $E->getMessage());
            }
        }
    }
}
