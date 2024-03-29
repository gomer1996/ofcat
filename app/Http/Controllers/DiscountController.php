<?php

namespace App\Http\Controllers;

use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        return view('discounts.index', [
            'discounts' => Discount::latest()->get()
        ]);
    }
}
