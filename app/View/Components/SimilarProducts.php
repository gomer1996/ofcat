<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class SimilarProducts extends Component
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
        return view('components.similar-products', [
            'products' => Product::all()->random()->limit(4)->get()
        ]);
    }
}
