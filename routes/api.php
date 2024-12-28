<?php

use App\Http\Controllers\BannerAdsController;
use App\Http\Controllers\CustomTripController;
use App\Http\Controllers\ItenaryTripController;
use App\Http\Controllers\PackageTripAssetsController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\C_Admin;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\PackageTripController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

// User routes with middleware
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    
    Route::post('v1/register', [UserController::class, 'register']);
    Route::post('v1/login', [UserController::class, 'login']);
    Route::post('v1/verify-otp', [UserController::class, 'verifyOtp']);
    Route::post('v1/complete-profile', [UserController::class, 'completeProfile']);
    

        
    Route::post('v1/logout', [UserController::class, 'logout']);
    Route::get('v1/user', [UserController::class, 'me']);
    Route::put('v1/user', [UserController::class, 'updateProfile']);
    Route::put('v1/user/profile/{id}', [UserController::class, 'updateProfilePicture']);

    // request custom trip
    route::post('v1/custom-trips', [CustomTripController::class, 'store']);

    // Reservasi
    route::post('v1/reservasi', [ReservationController::class, 'store2']);
   
    
});
Route::post('user/{id}/set-pin', [UserController::class, 'setPin']);
Route::get('v1/userAll', [UserController::class, 'getAllUser']);

// Admin routes without middleware
Route::group(['prefix' => 'auth'], function () {
    Route::post('v1/loginadmin', [C_Admin::class, 'loginAdmin']);
    Route::post('v1/create', [C_Admin::class, 'create']);
    Route::get('v1/admin', [C_Admin::class, 'me']);
    Route::post('v1/logout-admin', [C_Admin::class, 'logout']);
    
    // Vocher
    Route::post('v1/voucher', [VoucherController::class, 'store']);
});

Route::get('v1/voucher', [VoucherController::class, 'index']);

// Trip
Route::get('v1/package-trip', [PackageTripController::class, 'index']);
Route::post('v1/package-trip', [PackageTripController::class, 'store']);
Route::get('v1/package-trip/{id}', [PackageTripController::class, 'show']);
Route::put('v1/package-trip/{id}', [PackageTripController::class, 'update']);
Route::delete('v1/package-trip/{id}', [PackageTripController::class, 'destroyJson']);

// Itenary
Route::post('v1/itenary-trip', [ItenaryTripController::class, 'store']);
Route::get('v1/itenary-trip', [ItenaryTripController::class, 'index']);
Route::put('v1/itenary-trip/{id}', [ItenaryTripController::class, 'update']);

//Assets
Route::post('v1/assets', [PackageTripAssetsController::class, 'store']);

// Country
Route::get('v1/countries', [CountriesController::class, 'index']);
Route::post('v1/countries', [CountriesController::class, 'store']);
Route::get('v1/countries/{id}', [CountriesController::class, 'show']);
Route::put('v1/countries/{id}', [CountriesController::class, 'update']);
Route::delete('v1/countries/{id}', [CountriesController::class, 'destroy']);


// Province
Route::get('v1/provinces', [ProvincesController::class, 'index']);
Route::post('v1/provinces', [ProvincesController::class, 'store']);
Route::get('v1/provinces/{id}', [ProvincesController::class, 'show']);
Route::put('v1/provinces/{id}', [ProvincesController::class, 'update']);
Route::delete('v1/provinces/{id}', [ProvincesController::class, 'destroy']);

// City
Route::get('v1/cities', [CitiesController::class, 'index']);
Route::post('v1/cities', [CitiesController::class, 'store']);
Route::get('v1/cities/{id}', [CitiesController::class, 'show']);
Route::put('v1/cities/{id}', [CitiesController::class, 'update']);
Route::delete('v1/cities/{id}', [CitiesController::class, 'destroy']);

// package|Itenary
Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('package-trip', [PackageTripController::class, 'store']);
    Route::delete('package-trip/{id}', [PackageTripController::class, 'destroy']);
    
    
    //Itenary
    Route::post('itenary-trip', [ItenaryTripController::class, 'store']);

    // Banner Ads
    Route::post('banner', [BannerAdsController::class, 'store']);

    // assetsTrip
    Route::post('assets', [PackageTripAssetsController::class, 'store']);

});
// Route::post('package/trip', [PackageTripController::class, 'store']);
Route::get('package/trip', [PackageTripController::class, 'index']);
// Route::get('package/trip/{id}', [PackageTripController::class, 'show']);
// Route::put('package-trip/{id}', [PackageTripController::class, 'update']);
// Route::delete('package-trip/{id}', [PackageTripController::class, 'update']);

Route::get('itenary-trip', [ItenaryTripController::class, 'index']);
Route::put('itenary-trip/{id}', [ItenaryTripController::class, 'updateWeb']);


//Banner Ads
Route::get('v1/banner', [BannerAdsController::class, 'index']);
Route::put('v1/banner/{id}', [BannerAdsController::class, 'update']);

// image
Route::get('assets', [PackageTripAssetsController::class, 'index']);
Route::put('assets/{id}', [PackageTripAssetsController::class, 'update']);


// Custom Trip
route::get('v1/custom-trips', [CustomTripController::class, 'index']);
route::get('v1/custom-trips/{id}', [CustomTripController::class, 'show']);

// Reservation
route::get('v1/reservation', [ReservationController::class, 'index']);
route::get('v1/reservation/{id}', [ReservationController::class, 'show']);


// Rental
Route::get('v1/rental', [RentalController::class, 'index']);
Route::get('v1/rental/{id}', [RentalController::class, 'show']);
Route::post('v1/rental', [RentalController::class, 'store']);
Route::put('v1/rental/{id}', [RentalController::class, 'update']);
Route::delete('v1/rental/{id}', [RentalController::class, 'destroy']);





