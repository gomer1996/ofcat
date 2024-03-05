<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductIntro extends Component
{
    public $product;
    public $cartQty = 1;
    public $viewType;
    public $productCalculatedPrice;

    public function mount()
    {
        $this->productCalculatedPrice = $this->product->calculated_price;
    }

    public function addToCart($product)
    {
       Cart::add($product["id"], $product["name"], $this->cartQty, $this->productCalculatedPrice, 0, [
           'img' => $product["thumbnail"],
           'code' => $product["code"],
           'integration' => $product['integration']
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
        $view = $this->viewType === 'line' ? 'product-intro-line' : 'product-intro';

        return view("livewire.{$view}", [
            'product' => $this->product,
            'viewType' => $this->viewType,
            'productCalculatedPrice' => $this->productCalculatedPrice,
        ]);
    }
}
