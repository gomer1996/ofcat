<?php

namespace App\Http\Controllers;

use App\DTO\CheckoutDTO;
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
        return view('checkout.index', ['type' => $request->get('type') ?? 'person']);
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

        $email = Auth::user() ? Auth::user()->email : $request->get('email');

        $checkoutDTO = new CheckoutDTO(
            $request->get('name'),
            $request->get('company'),
            $request->get('phone'),
            $email,
            $request->get('address'),
            $request->get('note'),
            $request->get('delivery'),
            $request->get('user_type'),
            CartHelper::getTotalWithDelivery()
        );

        if (Order::create($request->all())) {
            NewOrder::dispatch($checkoutDTO, $cart);
            Cart::destroy();

            return redirect()->route('checkout.success');
        }

        return view('checkout.index')->with('status', 'Что-то пошло не так');
    }
}
