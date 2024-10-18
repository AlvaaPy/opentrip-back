<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('component.master');
});
Route::get('/trip', function () {
    return view('pages.Trip.trip');
});
Route::get('/itenaryTrip', function () {
    return view('pages.Trip.itenary');
});
Route::get('/galery', function () {
    return view('pages.Trip.galery');
});
Route::get('/banner', function () {
    return view('pages.Trip.banners');
});

// REQ

Route::get('/request-custom', function () {
    return view('pages.Request.customTrip');
});
