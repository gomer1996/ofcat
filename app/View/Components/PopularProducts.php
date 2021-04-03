<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class PopularProducts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.popular-products', [
            'products' => Product::limit(8)->get()->shuffle()
        ]);
    }
}
