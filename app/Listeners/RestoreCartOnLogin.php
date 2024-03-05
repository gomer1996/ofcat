<?php

namespace App\Listeners;

use App\Events\NewOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class RestoreCartOnLogin
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
     * @return void
     */
    public function handle()
    {
        try {
            Cart::restore(auth()->id());
        } catch (\Throwable $E) {
            Log::critical('Error while restoring the cart' . $E->getMessage());
        }
    }
}
