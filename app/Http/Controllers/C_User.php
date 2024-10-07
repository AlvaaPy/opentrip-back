<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class C_User extends Controller
{

// Register
    public function register(Request $request){
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'noTlpn' => 'required|string|max:15',
            'birthDate' => 'required|date',
            'gender' => 'required|in:male,female',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'noTlpn' => $request->noTlpn,
            'birthDate' => $request->birthDate,
            'gender' => $request->gender,
        ]);

        return response()->json(['msg' => 'User Berhasil Registrasi', 'user' => $user], 201);
    }

    public function login(Request $request){
        
    }

}