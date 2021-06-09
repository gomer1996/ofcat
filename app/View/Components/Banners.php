<?php

namespace App\View\Components;

use App\Models\Banner;
use Illuminate\View\Component;

class Banners extends Component
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
        $banners = Banner::all();

        $largeBanners = $banners->where('type', 'large') ?? [];
        $smallTop = $banners->firstWhere('type', 'small-top');
        $smallBottom = $banners->firstWhere('type', 'small-bottom');

        return view('components.banners', [
            'largeBanners' => $largeBanners,
            'smallTop' => $smallTop,
            'smallBottom' => $smallBottom
        ]);
    }
}
