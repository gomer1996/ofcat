<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public $cartProducts = [];

    public $totalPrice = 0;

    public $selected = [];

    public $discount = "";

    public function mount()
    {
        $this->resetCartProps();
        $this->selected = collect([]);
    }

    public function resetCartProps()
    {
        $this->cartProducts = Cart::content();
        $this->totalPrice = Cart::total();
        $this->emit('cartUpdated');
    }

    public function update($qty, $rowId)
    {
        Cart::update($rowId, $qty);
        $this->resetCartProps();
    }

    public function increase($rowId)
    {
        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty + 1);
        $this->resetCartProps();
    }

    public function reduce($rowId)
    {
        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty - 1);
        $this->resetCartProps();
    }

    public function removeProduct($rowId)
    {
        Cart::remove($rowId);
        $this->selected = collect([]);
        $this->resetCartProps();
    }

    public function selectProduct($rowId)
    {
        if ($this->selected->contains($rowId)) {
            $this->selected = $this->selected->filter(function($val) use($rowId){
                return $rowId !== $val;
            });
        } else {
            $this->selected->push($rowId);
        }
        $this->resetCartProps();
    }

    public function removeSelected()
    {
        $this->selected->each(function($rowId){
            Cart::remove($rowId);
        });
        $this->selected = collect([]);
        $this->resetCartProps();
    }

    public function clearCart()
    {
        Cart::destroy();
        $this->resetCartProps();
    }

    public function apply()
    {
        if ($this->discount) Cart::setGlobalDiscount($this->discount);
        $this->resetCartProps();
    }

    public function render()
    {
        return view('livewire.cart-page', [
            'cartProducts' => $this->cartProducts,
            'totalPrice' => $this->totalPrice,
            'selected' => $this->selected
        ]);
    }
}
