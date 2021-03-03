<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotal extends Component
{
    public $productsCount = 0;
    public $totalPriceWithoutDiscount = 0;
    public $totalPrice = 0;
    public $discount;

    protected $listeners = ['cartUpdated' => 'mount'];

    public function mount()
    {
        $this->productsCount = Cart::count();
        $this->totalPrice = Cart::total();
        $this->totalPriceWithoutDiscount = Cart::priceTotal();
    }

    public function applyDiscount()
    {
        if ($this->discount) {
            Cart::setGlobalDiscount(20);
            $this->mount();
            $this->emit('discountApplied');
        }
    }

    public function render()
    {
        return view('livewire.cart-total', [
            'productsCount' => $this->productsCount,
            'totalPriceWithoutDiscount' => $this->totalPriceWithoutDiscount,
            'totalPrice' => $this->totalPrice,
        ]);
    }
}
