<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('viderpanier', function() {
    Cart::destroy();
    redirect()->route('index');
});

/* gestion produits */
Route::get("produit", "ProductController@index")->name("index");
Route::get("produit/{slug}", "ProductController@show")->name("products.show");

/*le Gestion de panier */

Route::post('panier/ajoute', 'cartController@store')->name('cart.store');
Route::patch('/panier/{rowId}', 'cartController@update')->name('cart.update');
Route::get('panier', 'cartController@index')->name('cart.index');
Route::delete('/panier/{rowId}', 'cartController@destroy')->name('cart.destroy');

/* Gestion de paiement */

Route::get('paiement', 'CheckoutController@index')->name('check.paiement');
Route::post('paiement', 'CheckoutController@store')->name('check.paiement');
Route::get('/merci', 'CheckoutController@thankYou')->name('checkout.thankYou');
