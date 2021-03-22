<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductSingle extends Component
{
    public $product;

    public function addToCart($product)
    {
        Cart::add($product["id"], $product["name"], 1, $product["price"], 0, [
            'img' => $product["thumbnail"]
        ]);
        $this->emit('livewireNotify', 'success', 'Товар добавлен в корзину');
        $this->emit('cartUpdated');
    }

    public function render()
    {
        return view('livewire.product-single', [
            'product' => $this->product
        ]);
    }
}
