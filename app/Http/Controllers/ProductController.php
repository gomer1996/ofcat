<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('product.single', [
            'product' => $product
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
