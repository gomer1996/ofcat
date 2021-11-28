<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Кто то подписался на новостную ленту';

    public $name;

    public $email;

    /**
     * NewsletterSubscribtionMail constructor.
     * @param string $name
     * @param string $email
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
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
            'greeting' => 'Пользователь подписался на ленту',
            'introLines' => [
                'Имя: ' . $this->name,
                'Email: ' . $this->email
            ],
            'outroLines' => []
        ]);
    }
}
