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

Route::get('/bus', function () {

    return view('bus');
})
    ->name('bus');



Route::get('/login', function () {

    return view('login');
})
    ->name('login');

Route::get('/register', function () {

    return view('register');
})
    ->name('register');

Route::post('auth/check', 'App\Http\Controllers\Auth\LoginController@checklogin');
Route::get('auth/success', 'App\Http\Controllers\Auth\LoginController@successlogin');
Route::get('auth/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');

Route::post('user/create', 'App\Http\Controllers\Auth\CreateUserController@Create');

Route::get('display_buses', 'App\Http\Controllers\BusController@getBuses');

Route::middleware('auth')->group( function () {
    Route::get('/manage_bus', function () {

        return view('manage_bus');
    })
        ->name('manage_bus')
        ->middleware('permission:ADMIN');
});
