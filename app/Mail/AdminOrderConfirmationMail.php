<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AdminOrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Новый заказ на сайте';

    public Collection $cartItems;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $cartItems)
    {
        $this->cartItems = $cartItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $introLines = [];
        foreach($this->cartItems as $cartItem) {
            $introLines[] = $cartItem->name . ' (' . $cartItem->qty . ') - ' . $cartItem->price . ' руб.';
        }
        $data = [
            'level' => 'success',
            'greeting' => 'Данные по заказу',
            'introLines' => $introLines,
            'outroLines' => []
        ];

        return $this->markdown('vendor.notifications.email')->with($data);
    }
}
