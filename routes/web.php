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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// 商品一覧
Route::get('/', 'ItemsController@index');
// 商品の詳細
Route::get('/items/{item}', 'ItemsController@show');
// カートへ商品を投入する
Route::post('/cartitems', 'CartItemsController@store');
// 商品の一覧
Route::get('/cartitems', 'CartItemsController@index');
// カートの中の商品の削除、更新　{Cartitem}で選択した商品を送っている
Route::delete('/cartitems/{cartItem}', 'CartItemsController@destroy');
Route::put('/cartitems/{cartItem}', 'CartItemsController@update');
