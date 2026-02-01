<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Http\Requests\CheckoutStoreRequest;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CartHelper;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type') ?? 'person';
        return view('checkout.index', ['type' => $type]);
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

        if (Auth::user()) {
            $request->request->add(['user_id' => Auth::user()->id]);
        }
        $request->request->add(['cart' => $cart->toJson()]);
        $request->request->add(['price' => CartHelper::getTotalWithDelivery()]);
        $request->request->add(['discount' => floatval(Cart::discount(2, '.', ''))]);

        if (Order::create($request->all())) {
            NewOrder::dispatch(Auth::user(), $cart);
            Cart::destroy();

            return redirect()->route('checkout.success');
        }

        return view('checkout.index')->with('status', 'Что-то пошло не так');
    }
}
