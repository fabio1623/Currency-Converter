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

Route::get('/', function () {
    // return view('welcome');
    return view('Home.Index');
});

// Currency
Route::get('Rate', 'CurrencyController@index');
Route::post('Rate', 'CurrencyController@rate');
Route::get('Convert', 'CurrencyController@convertPage');
Route::get('ActiveUsersAmounts', 'CurrencyController@activeUsers');
Route::get('Earnings2014', 'CurrencyController@earnings');
Route::post('Convert', 'CurrencyController@convert');
