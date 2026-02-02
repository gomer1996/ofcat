<?php

namespace App\Mail;

use App\DTO\CheckoutDTO;
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

    public CheckoutDTO $checkoutDTO;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CheckoutDTO $checkoutDTO, Collection $cartItems)
    {
        $this->cartItems = $cartItems;
        $this->checkoutDTO = $checkoutDTO;
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
            'outroLines' => [],
            'name' => $this->checkoutDTO->getName(),
            'email' => $this->checkoutDTO->getEmail(),
            'delivery' => $this->checkoutDTO->getDelivery(),
            'phone' => $this->checkoutDTO->getPhone(),
            'address' => $this->checkoutDTO->getAddress(),
            'company' => $this->checkoutDTO->getCompany(),
            'note' => $this->checkoutDTO->getNote(),
            'userType' => $this->checkoutDTO->getUserType(),
            'price' => $this->checkoutDTO->getPrice(),
        ];

        return $this->markdown('vendor.notifications.order-admin-email')->with($data);
    }
}
