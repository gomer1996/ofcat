<?php

namespace App\View\Components;

use App\Models\Page;
use Illuminate\View\Component;

class Footer extends Component
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
        $pages = Page::with(['children' => function($q){
            $q->orderBy('order')->get();
        }])
            ->where(['position' => 'footer'])
            ->whereNull('parent_id')
            ->get();

        return view('components.footer', [
            'pages' => $pages
        ]);
    }
}
