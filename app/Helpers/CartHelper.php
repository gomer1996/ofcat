<?php

namespace App\Helpers;

use App\Models\Settings;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartHelper {

    /**
     * @return float
     */
    public static function getTotalWithDelivery(): float
    {
        $total = floatval(Cart::total(2, '.', ''));
        $settings = Settings::first();

        if ($settings) {
            if ($total < $settings->delivery_price_depends) {
                return $total + $settings->delivery_price;
            }
        }
        return $total;
    }

    /**
     * @return float
     */
    public static function getDelivery(): float
    {
        $total = floatval(Cart::total(2, '.', ''));
        $settings = Settings::first();

        if ($settings) {
            if ($total < $settings->delivery_price_depends) return $settings->delivery_price;
        }
        return 0;
    }
}
