<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Подтверждение заказа';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.email')->with([
            'level' => 'success',
            'greeting' => 'Ваш заказ принят в обработку',
            'introLines' => [
                'Уважаемый клиент!',
                'Благодарим за ваш заказ в нашем интернет магазине',
                'С вами скоро свяжутся наши менеджеры'
            ],
            'outroLines' => []
        ]);
    }
}
