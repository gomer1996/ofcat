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

Route::view('/cart', 'cart')->name('cart.index');
Route::view('/checkout', 'checkout')->name('checkout.index');

Route::get('/discounts', [\App\Http\Controllers\DiscountController::class, 'index'])->name('discounts.index');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');

Route::get('/categories/{id?}', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/news/{news}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

Route::get('/pages/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
