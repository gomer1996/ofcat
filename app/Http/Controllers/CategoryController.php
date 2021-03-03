<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        //$products = Product::where('category_id', $category->id)->paginate(2);

        return view('product.category', [
          //  'products' => $products,
            'category' => $category
        ]);
    }
}
