<?php

namespace App\Listeners;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class StoreCartOnLogout
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
            Cart::store(auth()->id());
        } catch (\Throwable $E) {
            Log::critical('Error while storing the cart' . $E->getMessage());
        }
    }
}
