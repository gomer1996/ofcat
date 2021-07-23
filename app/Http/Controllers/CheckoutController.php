<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Http\Requests\CheckoutStoreRequest;
use App\Models\Order;
use App\Models\Settings;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CartHelper;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function store(CheckoutStoreRequest $request)
    {
        $cart = Cart::content();
        if (!$cart->count()) {
            return redirect()->route('checkout.index')->with(
                'status',
                'Ваша корзина пуста'
            );
        }

        if (Auth::user()) $request->request->add(['user_id' => Auth::user()->id]);
        $request->request->add(['cart' => $cart->toJson()]);
        $request->request->add(['price' => CartHelper::getTotalWithDelivery()]);
        $request->request->add(['discount' => Cart::discount()]);

        if (Order::create($request->all())) {
            Cart::destroy();
            NewOrder::dispatch();
            return redirect()->route('checkout.success');
        }
        return view('checkout.index')->with('status', 'Что-то пошло не так');
    }
}
