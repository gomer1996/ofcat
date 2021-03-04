<?php

namespace App\Http\Livewire;

use App\Models\Discount;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotal extends Component
{
    public $productsCount = 0;
    public $totalPriceWithoutDiscount = 0;
    public $totalPrice = 0;
    public $userDiscount;
    public $cartDiscount = 0;

    public $discountPercent = 0;

    protected $listeners = ['cartUpdated' => 'mount'];

    public function mount()
    {
        $this->productsCount = Cart::count();
        $this->totalPrice = Cart::total();
        $this->totalPriceWithoutDiscount = Cart::priceTotal();
        $this->cartDiscount = Cart::discount();

        $discountParsed = floatval(Cart::discount(2, '.', ''));
        $totalPriceParsed = floatval(Cart::priceTotal(2, '.', ''));
        $this->discountPercent = $discountParsed ? round($totalPriceParsed / $discountParsed ) : 0;
    }

    public function applyDiscount()
    {
        if ($this->userDiscount) {
            $foundDiscount = Discount::where(['code' => $this->userDiscount])
                ->whereDate('starts_at', '<', Carbon::now())
                ->whereDate('expires_at', '>', Carbon::now())
                ->first();

            if ($foundDiscount) {
                Cart::setGlobalDiscount($foundDiscount->percent);
                $this->mount();
                $this->emit('discountApplied');
            }
            $this->emit('discountFailed');
        }
    }

    public function render()
    {
        return view('livewire.cart-total', [
            'productsCount' => $this->productsCount,
            'totalPriceWithoutDiscount' => $this->totalPriceWithoutDiscount,
            'totalPrice' => $this->totalPrice,
            'cartDiscount' => $this->cartDiscount,
            'discountPercent' => $this->discountPercent,
        ]);
    }
}
