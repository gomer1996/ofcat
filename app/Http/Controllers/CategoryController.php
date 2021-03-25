<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        if (in_array($category->level, ['1', '2'])) {

            $category->load('children.children');

            return view('category.index', [
                'category' => $category
            ]);
        }

        return view('product.category', [
            'category' => $category
        ]);
    }

    public function all()
    {
        return view('category.all', [
            'categories' => Category::with('children.children')->whereNull('parent_id')->get()
        ]);
    }
}
