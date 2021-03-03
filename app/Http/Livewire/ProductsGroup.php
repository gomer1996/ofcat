<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductsGroup extends Component
{
    public $type;

    public function addToCart($product)
    {
        Cart::add($product["id"], $product["name"], 1, $product["price"]);
        $this->emit('productAddedToCart');
    }

    public function render()
    {
        return view('livewire.products-group', [
            'products' => Product::all()->random()->limit(8)->get()
        ]);
    }
}
