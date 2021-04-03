<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // todo medialib
//        $url = 'https://api.samsonopt.ru/goods/100008/7b9708521771c130b0b0db8024d06b81_x.jpg';
//        $product->addMediaFromUrl($url)
//                    ->toMediaCollection('product_media_collection');
        $settings = Settings::first();

        return view('product.single', [
            'product' => $product,
            'delivery_text' => $settings ? $settings->product_page_delivery_text : ''
        ]);
    }

    public function search()
    {
        $searchString = request()->get('q');

        return view('product.search-results', [
            'products' => Product::where('name', 'like', "%$searchString%")->limit(10)->get()
        ]);
    }
}
