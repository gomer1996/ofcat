<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class NewsletterForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

    public function subscribe()
    {
        $this->validate();

        if ($this->name && $this->email) {

            Mail::to("marat-valiev-1996@mail.ru")
                ->send(new \App\Mail\NewsletterSubscriptionMail($this->name, $this->email));

            $this->emit('livewireNotify', 'success', 'Вы успешно подписались на рассылку');
            $this->name = '';
            $this->email = '';
        }
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
