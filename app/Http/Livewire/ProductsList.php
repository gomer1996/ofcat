<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $category;

    public function render()
    {
        return view('livewire.products-list', [
            'products' => Product::where('category_id', $this->category->id)->paginate(3),
            'title' => $this->category->name
        ]);
    }
}
