<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryProducts extends Component
{
    use WithPagination;

    public $category;

    public function render()
    {
        return view('livewire.category-products', [
            'products' => Product::where('category_id', $this->category->id)->paginate(3),
            'category' => $this->category
        ]);
    }
}
