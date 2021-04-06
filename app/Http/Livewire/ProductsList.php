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

    public $type = 'block';

    private $orderState = [
        "price_asc" => [ "field" => "price", "type" => "ASC" ],
        "price_desc" => [ "field" => "price", "type" => "DESC" ],
        "name_asc" => [ "field" => "name", "type" => "ASC" ],
        "name_desc" => [ "field" => "name", "type" => "DESC" ],
    ];

    public $priceFrom = 0;
    public $priceTo = 0;
    public $selectedBrands = [];
    public $brands = [];

    public function mount()
    {
        $this->priceTo = ceil(Product::max('price') ?? 0);
        $this->brands = Product::getUniqueBrands($this->category->id);
    }

    public function sort($val)
    {
        $this->sort = $val;
        $this->resetPage();
    }

    public function changeView($type)
    {
        if (in_array($type, ['line', 'block'])) $this->type = $type;
    }

    public function updatedPriceTo()
    {
        $this->resetPage();
    }

    public function updatedPriceFrom()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrands()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::where('products.category_id', $this->category->id);

        $query->where('price', '>=', $this->priceFrom)
              ->where('price', '<=', $this->priceTo);

        if (count($this->selectedBrands)) $query->whereIn('brand', $this->selectedBrands);

        $products = $query->orderBy(
            $this->orderState[$this->sort]["field"],
            $this->orderState[$this->sort]["type"]
        )->paginate(3);

        return view('livewire.products-list', [
            'products' => $products,
            'title' => $this->category->name,
            'viewType' => $this->type,
            'chunkCount' => $this->type === 'block' ? 3 : 1,
            'brands' => $this->brands
        ]);
    }
}
