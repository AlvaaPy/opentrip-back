<?php

use App\Http\Controllers\adminCustomTrip;
use App\Http\Controllers\adminReservstion;
use App\Http\Controllers\adminUserController;
use App\Http\Controllers\BannerAdsController;
use App\Http\Controllers\C_Admin;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CustomTripController;
use App\Http\Controllers\ItenaryTripController;
use App\Http\Controllers\PackageTripAssetsController;
use App\Http\Controllers\PackageTripController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\UserController;
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





// User
Route::get('/pengguna', [adminUserController::class, 'getAllUser'])
    ->name('user.index');

Route::get('/pengguna/update/{id}', [adminUserController::class, 'editWeb'])->name('pengguna.edit');

Route::put('/pengguna/update/{id}', [adminUserController::class, 'updateProfileWeb'])->name('pengguna.update');

Route::delete('/pengguna/delete/{id}', [adminUserController::class, 'destroy'])->name('pengguna.delete');


// Admin
Route::get('/admin', [adminUserController::class, 'getAllAdmin'])
    ->name('admin.index');

//Login
Route::get('/Login', function () {
    return view('pages.Login.login');
})->name('login');

// Route untuk memproses login
Route::post('/Login', [C_Admin::class, 'loginWeb']);

Route::delete('/admin/delete/{id}', [adminUserController::class, 'destroyAdmin'])->name('admin.delete');

// Logout
Route::post('/logout', [C_Admin::class, 'logoutWeb'])->middleware('auth:api')->name('admin.logout');




// Trip
Route::get('/add-trip', function () {
    return view('pages.Trip.addtrip');
});

Route::get('/trip', [PackageTripController::class, 'indexWeb'])->name('trip.index');
Route::post('/add-trip', [PackageTripController::class, 'storeWeb']);
Route::get('/add-trip', [PackageTripController::class, 'create']);
// Route::get('/add-trip', [PackageTripController::class, 'storeWeb']);

Route::delete('/trip/delete/{id}', [PackageTripController::class, 'destroy'])->name('trip.delete');
Route::get('/trip/edit/{id}', [PackageTripController::class, 'editWeb'])->name('trip.edit');
Route::put('/trip/update/{id}', [PackageTripController::class, 'updateWeb'])->name('trip.update');

// Itenary
Route::get('/itenaryTrips', function () {
    return view('pages.Trip.itenary');
});

Route::get('/itenaryTrip', [ItenaryTripController::class, 'indexWeb'])->name('trip.index1');
Route::get('/add-itenary', function () {
    return view('pages.Trip.additenary');
});
Route::post('/add-itenary', [ItenaryTripController::class, 'storeWeb']);
Route::get('/add-itenary', [ItenaryTripController::class, 'create']);

Route::get('/itenary/update/{id}', [ItenaryTripController::class, 'editWeb'])->name('itenary.edit');

Route::put('/itenary/update/{id}', [ItenaryTripController::class, 'updateWeb'])->name('itenary.update');
Route::delete('/itenary/delete/{id}', [ItenaryTripController::class, 'destroy'])->name('itenary.delete');
// Route::put('/itenary/update/{id}', [ItenaryTripController::class, 'updateWeb'])->name('itenary.update');

// galery
Route::get('/galery', [PackageTripAssetsController::class, 'indexWeb'])->name('trip.galery');
Route::get('/add-galery', function () {
    return view('pages.Trip.galery.addGalery');
});
Route::post('/add-galery', [PackageTripAssetsController::class, 'storeWeb']);
Route::get('/add-galery', [PackageTripAssetsController::class, 'create']);
Route::get('/galery/update/{id}', [PackageTripAssetsController::class, 'editWeb'])->name('galery.edit');
Route::put('/galery/update/{id}', [PackageTripAssetsController::class, 'update'])->name('galery.update');
Route::delete('/galery/delete/{id}', [PackageTripAssetsController::class, 'destroy'])->name('galery.delete');

// bannersAds
Route::get('/banner', [BannerAdsController::class, 'indexWeb'])->name('trip.banner');
Route::get('/add-banner', function () {
    return view('pages.Trip.banners.add');
});


Route::post('/add-banner', [BannerAdsController::class, 'storeWeb']);
Route::get('/banner/update/{id}', [BannerAdsController::class, 'editWeb'])->name('banner.edit');
Route::put('/banner/update/{id}', [BannerAdsController::class, 'update'])->name('banner.update');
Route::delete('/banner/delete/{id}', [BannerAdsController::class, 'destroy'])->name('banner.delete');

// Custom Trip
Route::get('/request-custom', function () {
    return view('pages.Request.customTrip');
});

Route::get('/request-custom', [adminCustomTrip::class, 'indexWeb'])->name('custom.index');

// Accept
Route::patch('/admin/custom-trip/{id}/accept', [adminCustomTrip::class, 'accept'])
    ->name('admin.customTrip.accept');


// Voucher
Route::get("/Voucher", function () {
    return view('pages.Voucher.voucher');
});

Route::get('/Voucher', [adminReservstion::class, 'readVoucher'])->name('voucher.index');


//Transaction & Reservasi
Route::get("/Reservasi", function () {
    return view('pages.transaction.reservasi');
});

// Reservasi
Route::get('/Reservasi', [adminReservstion::class, 'readReservasi'])->name('reservasi.index');


// Rental 
Route::get('/Rental', function () {
    return view('pages.rental.rental');
});

Route::get('/Rental', [adminReservstion::class, 'readRental'])->name('rental.index');


//========================//
Route::get('/', function () {
    return view('component.master');
});
Route::post('/', function () {
    return view('component.master');
})->name('dashboard');





// Route::get('/banner', function () {
//     return view('pages.Trip.banners');
// });

// REQ


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

// Route::get('/pengguna', function () {
//     return view('pages.users.pengguna');
// });



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
    Route::get('/add-province', [ProvincesController::class, 'create']);
    Route::get('/province/update/{id}', [ProvincesController::class, 'editWeb'])->name('province.edit');
    Route::put('/province/update/{id}', [ProvincesController::class, 'updateWeb'])->name('province.update');
    Route::delete('/province/delete/{id}', [ProvincesController::class, 'destroyWeb'])->name('province.delete');

    //City
    Route::get('/add-city', function () {
        return view('pages.locate.city.add');
    });
    Route::get('/City', [CitiesController::class, 'indexWeb'])->name('locate.city');
    Route::post('/add-city', [CitiesController::class, 'storeWeb']);
    Route::get('/add-city', [CitiesController::class, 'create']);
    Route::get('/city/update/{id}', [CitiesController::class, 'editWeb'])->name('city.edit');
    Route::put('/city/update/{id}', [CitiesController::class, 'updateWeb'])->name('city.update');
    Route::delete('/city/delete/{id}', [CitiesController::class, 'destroyWeb'])->name('city.delete');


