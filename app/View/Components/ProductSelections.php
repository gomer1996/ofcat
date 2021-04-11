<?php

namespace App\View\Components;

use App\Models\ProductSelectionCategory;
use Illuminate\View\Component;

class ProductSelections extends Component
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
        $selections = ProductSelectionCategory::all();

        $benefits = $selections->where('type', 'suggestions');
        $profits = $selections->where('type', 'selections');

        return view('components.product-selections', [
            'benefits' => $benefits,
            'profits' => $profits
        ]);
    }
}
