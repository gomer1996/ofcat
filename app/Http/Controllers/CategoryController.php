<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        if (in_array($category->level, ['1', '2', '3'])) {

            $category->load('children.children');

            if (!$category->children()->count()) {
                return view('product.category', [
                    'category' => $category
                ]);
            }

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
