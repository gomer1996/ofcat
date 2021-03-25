<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    public $category;

    public $sort = 'price_asc';

    private $orderState = [
        "price_asc" => [ "field" => "price", "type" => "ASC" ],
        "price_desc" => [ "field" => "price", "type" => "DESC" ],
        "name_asc" => [ "field" => "name", "type" => "ASC" ],
        "name_desc" => [ "field" => "name", "type" => "DESC" ],
    ];

    public function sort($val)
    {
        $this->sort = $val;
    }

    public function render()
    {
        return view('livewire.products-list', [
            'products' => Product::where('category_id', $this->category->id)
                ->orderBy($this->orderState[$this->sort]["field"], $this->orderState[$this->sort]["type"])
                ->paginate(3),

            'title' => $this->category->name
        ]);
    }
}
