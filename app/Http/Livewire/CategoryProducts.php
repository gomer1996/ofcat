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
    public $searchString = '';

    public function mount()
    {
        $this->searchString = request()->get('search');
    }

    public function render()
    {
        $filter = Product::whereNotNull('id');

        if ($this->category) $filter->where('category_id', $this->category->id);

        if ($this->searchString) $filter->where('name', 'like', "%$this->searchString%");

        $products = $filter->paginate(3);

        return view('livewire.category-products', [
            'products' => $products,
            'category' => $this->category
        ]);
    }
}
