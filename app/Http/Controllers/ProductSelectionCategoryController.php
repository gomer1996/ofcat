<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSelectionCategory;

class ProductSelectionCategoryController extends Controller
{
    public function index(ProductSelectionCategory $category)
    {
        $productIds = $category->productSelections->pluck('product_id');

        return view('product-selection-category.index', [
            'category' => $category,
            'products' => Product::whereIn('products.id', $productIds)->limit(8)->get()
        ]);
    }
}
