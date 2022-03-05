<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function show($id, Request $request)
    {
        $product = Product::where('products.id', $id)->firstOrFail();
        $settings = Settings::first();

        $category = $request->get('cat')
            ? Category::find($request->get('cat'))
            : $product->category;

        $breadcrumbs = $category ? [
            $category->parent && $category->parent->parent ? $category->parent->parent->parent : null,
            $category->parent ? $category->parent->parent : null,
            $category->parent,
            $category
        ] : [];

        return view('product.single', [
            'product' => $product,
            'delivery_text' => $settings ? $settings->product_page_delivery_text : '',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function search()
    {
        $searchString = request()->get('q');

        return view('product.search-results', [
            'products' => Product::whereNotNull('products.category_id')
                ->where('products.name', 'like', "%$searchString%")
                ->orWhere('products.vendor_code', $searchString)
                ->limit(10)->get()
        ]);
    }
}
