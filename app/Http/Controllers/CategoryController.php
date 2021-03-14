<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        return view('product.category', [
            'category' => $category
        ]);
    }
}
