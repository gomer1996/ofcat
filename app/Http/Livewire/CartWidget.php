<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartWidget extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = Cart::count();
    }

    public function render()
    {
        return view('livewire.cart-widget', [
            'count' => $this->count
        ]);
    }
}
