<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($id = null)
    {
        $category = Category::find($id);

        return view('product.category', [
            'category' => $category
        ]);
    }
}
