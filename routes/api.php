<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\C_Admin;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\PackageTripController;

use Illuminate\Support\Facades\Route;

// User routes with middleware
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [UserController::class, 'me']);
});

// Admin routes without middleware
Route::group(['prefix' => 'auth'], function () {
    Route::post('login-admin', [C_Admin::class, 'loginAdmin']);
    Route::post('create', [C_Admin::class, 'create']);
    Route::get('admin', [C_Admin::class, 'me']);
    Route::post('logout-admin', [C_Admin::class, 'logout']);
});

// API routes Country, Province, City

// Country
// Country Routes
Route::get('countries', [CountriesController::class, 'index']);
Route::post('countries', [CountriesController::class, 'store']);
Route::get('countries/{id}', [CountriesController::class, 'show']);
Route::put('countries/{id}', [CountriesController::class, 'update']);
Route::delete('countries/{id}', [CountriesController::class, 'destroy']);

// Province
Route::get('provinces', [ProvincesController::class, 'index']);
Route::post('provinces', [ProvincesController::class, 'store']);
Route::get('provinces/{id}', [ProvincesController::class, 'show']);
Route::put('provinces/{id}', [ProvincesController::class, 'update']);
Route::delete('provinces/{id}', [ProvincesController::class, 'destroy']);

// City
Route::get('cities', [CitiesController::class, 'index']);
Route::post('cities', [CitiesController::class, 'store']);
Route::get('cities/{id}', [CitiesController::class, 'show']);
Route::put('cities/{id}', [CitiesController::class, 'update']);
Route::delete('cities/{id}', [CitiesController::class, 'destroy']);


Route::group(['middleware' => 'auth:admin'], function () {
    Route::post('package-trip', [PackageTripController::class, 'store']);
    Route::delete('package-trip/{id}', [PackageTripController::class, 'destroy']);
});
// Route::post('package/trip', [PackageTripController::class, 'store']);
Route::get('package/trip', [PackageTripController::class, 'index']);
Route::get('package/trip/{id}', [PackageTripController::class, 'show']);
Route::put('package-trip/{id}', [PackageTripController::class, 'update']);
// Route::delete('package-trip/{id}', [PackageTripController::class, 'update']);
