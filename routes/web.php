<?php

use App\Http\Controllers\BannerAdsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\ItenaryTripController;
use App\Http\Controllers\PackageTripController;
use App\Http\Controllers\ProvincesController;
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

Route::get('/itenaryTrip', function () {
    return view('pages.Trip.itenary');
});
Route::get('/galery', function () {
    return view('pages.Trip.galery');
});
// Route::get('/banner', function () {
//     return view('pages.Trip.banners');
// });

// REQ

Route::get('/request-custom', function () {
    return view('pages.Request.customTrip');
});

// City
Route::get('/Country', function () {
    return view('pages.locate.country');
});
Route::get('/Province', function () {
    return view('pages.locate.provice');
});
Route::get('/City', function () {
    return view('pages.locate.city');
});


// Users

Route::get('/pengguna', function () {
    return view('pages.users.pengguna');
});

// Coba Routing
Route::get('/add-trip', function () {
    return view('pages.Trip.addtrip');
});

Route::get('/trip', [PackageTripController::class, 'indexWeb'])->name('trip.index');
Route::post('/add-trip', [PackageTripController::class, 'storeWeb']);
// Route::get('/add-trip', [PackageTripController::class, 'storeWeb']);

Route::delete('/trip/delete/{id}', [PackageTripController::class, 'destroy'])->name('trip.delete');
Route::get('/trip/edit/{id}', [PackageTripController::class, 'editWeb'])->name('trip.edit');
Route::put('/trip/update/{id}', [PackageTripController::class, 'updateWeb'])->name('trip.update');


//Itenary
Route::get('/itenaryTrip', [ItenaryTripController::class, 'indexWeb'])->name('trip.index1');
Route::get('/add-itenary', function () {
    return view('pages.Trip.additenary');
});
Route::post('/add-itenary', [ItenaryTripController::class, 'storeWeb']);

Route::get('/itenary/update/{id}', [ItenaryTripController::class, 'editWeb'])->name('itenary.edit');

Route::put('/itenary/update/{id}', [ItenaryTripController::class, 'updateWeb'])->name('itenary.update');
Route::delete('/itenary/delete/{id}', [ItenaryTripController::class, 'destroy'])->name('itenary.delete');
// Route::put('/itenary/update/{id}', [ItenaryTripController::class, 'updateWeb'])->name('itenary.update');



//Banner Ads
Route::get('/banner', [BannerAdsController::class, 'indexWeb'])->name('trip.banner');
Route::get('/add-banner', function () {
    return view('pages.Trip.banners.add');
});

Route::post('/add-banner', [BannerAdsController::class, 'storeWeb']);
Route::get('/banner/update/{id}', [BannerAdsController::class, 'editWeb'])->name('banner.edit');
Route::put('/banner/update/{id}', [BannerAdsController::class, 'update'])->name('banner.update');
Route::delete('/banner/delete/{id}', [BannerAdsController::class, 'destroy'])->name('banner.delete');


// locate

// country
Route::get('/add-country', function () {
    return view('pages.locate.country.add');
});
Route::get('/Country', [CountriesController::class, 'indexWeb'])->name('locate.country');
Route::post('/add-country', [CountriesController::class, 'storeWeb']);
Route::get('/country/update/{id}', [CountriesController::class, 'editWeb'])->name('country.edit');
Route::put('/country/update/{id}', [CountriesController::class, 'updateWeb'])->name('country.update');
Route::delete('/country/delete/{id}', [CountriesController::class, 'destroyWeb'])->name('country.delete');

// Provice
Route::get('/add-province', function () {
    return view('pages.locate.province.add');
});
Route::get('/Province', [ProvincesController::class, 'indexWeb'])->name('locate.provice');
Route::post('/add-province', [ProvincesController::class, 'storeWeb']);
Route::get('/province/update/{id}', [ProvincesController::class, 'editWeb'])->name('province.edit');
Route::put('/province/update/{id}', [ProvincesController::class, 'updateWeb'])->name('province.update');
Route::delete('/province/delete/{id}', [ProvincesController::class, 'destroyWeb'])->name('province.delete');
