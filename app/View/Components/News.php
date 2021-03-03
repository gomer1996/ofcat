<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\News as NewsModel;

class News extends Component
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
        $news = NewsModel::latest()->limit(2)->get();

        return view('components.news', [
            'news' => $news
        ]);
    }
}
