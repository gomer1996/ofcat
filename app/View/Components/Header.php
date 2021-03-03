<?php

namespace App\View\Components;

use App\Models\Page;
use Illuminate\View\Component;

class Header extends Component
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
        $pages = Page::where('position', 'header')->orderBy('order')->get();

        return view('components.header', [
            'pages' => $pages
        ]);
    }
}
