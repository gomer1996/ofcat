<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])
    ->name('profile.index');

Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
    ->name('profile.update');

Route::get('/profile/addresses', [\App\Http\Controllers\ProfileController::class, 'addresses'])
    ->name('profile.addresses');

Route::get('/profile/create/addresses', [\App\Http\Controllers\ProfileController::class, 'createAddresses'])
    ->name('profile.create.addresses');

Route::post('/profile/addresses', [\App\Http\Controllers\ProfileController::class, 'storeAddresses'])
    ->name('profile.store.addresses');

Route::delete('/profile/addresses/{address}', [\App\Http\Controllers\ProfileController::class, 'deleteAddresses'])
    ->name('profile.destroy.addresses');

Route::get('/profile/orders', [\App\Http\Controllers\ProfileController::class, 'orders'])
    ->name('profile.orders');

Route::get('/profile/subscriptions', [\App\Http\Controllers\ProfileController::class, 'subscriptions'])
    ->name('profile.subscriptions');

Route::put('/profile/subscriptions', [\App\Http\Controllers\ProfileController::class, 'updateSubscriptions'])
    ->name('profile.update.subscriptions');

Route::view('/cart', 'cart')
    ->name('cart.index');

Route::view('/products/new', 'product.new')
    ->name('products.new');

Route::view('/products/bestsellers', 'product.bestsellers')
    ->name('products.bestsellers');

//------------------------------------------------------------------------------------------

Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::view('/checkout/success', 'checkout.success')
    ->name('checkout.success');

Route::get('/discounts', [\App\Http\Controllers\DiscountController::class, 'index'])
    ->name('discounts.index');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])
    ->name('news.index');

Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'search'])
    ->name('products.search');

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])
    ->name('products.show');

Route::get('/news/{news}', [\App\Http\Controllers\NewsController::class, 'show'])
    ->name('news.show');

Route::get('/pages/{page}', [\App\Http\Controllers\PageController::class, 'show'])
    ->name('pages.show');

require __DIR__.'/auth.php';
