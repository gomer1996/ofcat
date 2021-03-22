<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductIntro extends Component
{
    public $product;
    public $cartQty = 1;

    public function addToCart($product)
    {
       Cart::add($product["id"], $product["name"], $this->cartQty, $product["price"], 0, [
           'img' => $product["thumbnail"]
       ]);
       $this->emit('livewireNotify', 'success', 'Товар добавлен в корзину');
       $this->emit('cartUpdated');
    }

    public function increase()
    {
        $this->cartQty++;
    }

    public function reduce()
    {
        if ($this->cartQty > 1) $this->cartQty--;
    }


    public function render()
    {
        return view('livewire.product-intro', [
            'product' => $this->product
        ]);
    }
}
