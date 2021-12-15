<?php

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

Route::get('/home', function () {

    return view('home');
})
    ->name('home');

Route::get('/offers', function () {

    return view('offers');
})
    ->name('offers');

Route::get('/bus', function () {

    return view('bus');
})
    ->name('bus');

Route::get('/manage_bus', function () {

    return view('manage_bus');
})
    ->name('manage_bus');