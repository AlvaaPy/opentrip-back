<?php

use App\Http\Controllers\Auth\C_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [C_User::class, 'register']);
Route::post('login', [C_User::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [C_User::class, 'logout']);
    Route::get('user', [C_User::class, 'getUser']);
});