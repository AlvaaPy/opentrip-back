<?php

namespace App\Http\Controllers;

use App\Models\M_Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class C_Admin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['loginAdmin', 'create', 'loginWeb', 'logout', 'logoutWeb', 'editProfile']]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:admin',
            'username' => 'required|string|max:255|unique:admin',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        $admin = M_Admin::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Admin registered successfully', 'admin' => $admin], 201);
    }

    public function editProfile(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email,'.auth()->user()->id,
            'username' => 'required|string|max:255|unique:admin,username,'.auth()->user()->id,
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        $admin = M_Admin::find(auth()->user()->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->save();
        return response()->json(['message' => 'Profile updated successfully', 'admin' => $admin], 200);
    }
    
    
    
    // public function login(Request $request) 
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if (empty($request->username) || empty($request->password)) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'username and password fields are required.'
    //         ], 400); // Bad Request status code
    //     }

    //     $credentials = $request->only('username', 'password');

    //     // Attempt to log the user in
    //     if (!$token = auth()->attempt($credentials)) {
    //         // If login fails, return unauthorized error with a descriptive message
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid username or password. Please try again.'
    //         ], 401); // Unauthorized status code
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Login successful',
    //         'data' => $this->respondWithToken($token)
    //     ], 200);

    // }

    public function loginAdmin(Request $request)
    {
        // Validasi request yang masuk
        $request->validate([
            'credential' => 'required|string', // Ganti email menjadi satu field untuk credential
            'password' => 'required|string|min:6',
        ]);

        // Ambil credential (email atau username)
        $credential = $request->credential;

        // Ambil password
        $password = $request->password;

        // Cek apakah credential berupa email atau username
        if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            // Jika credential adalah email
            $field = 'email';
        } else {
            // Jika credential adalah username
            $field = 'username';
        }

        // Attempt untuk login dengan field yang sesuai
        if (!$token = auth('admin')->attempt([$field => $credential, 'password' => $password])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email/username or password. Please try again.'
            ], 401); // Status kode Unauthorized
        }

        // Jika berhasil, kembalikan token dengan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => $this->respondWithToken($token)
        ], 200); // Status kode OK
    }



    public function loginWeb(Request $request)
    {
        // Validasi request yang masuk
        $request->validate([
            'credential' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Ambil credential (email atau username)
        $credential = $request->credential;
        $password = $request->password;

        // Tentukan apakah credential berupa email atau username
        $field = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Coba login dengan menggunakan field yang sesuai
        if (!$token = auth('admin')->attempt([$field => $credential, 'password' => $password])) {
            // Kembalikan respons JSON error jika login gagal
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email/username or password. Please try again.'
            ], 401); // Status Unauthorized
        }

        // Ambil data admin yang sedang login
        $admin = auth('admin')->user();

        // Jika login berhasil, kembalikan data dalam respons JSON
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'username' => $admin->username,
            'name' => $admin->name,
            'email' => $admin->email,
            'message' => 'Login successful'
        ]);
    }



    public function logoutWeb(Request $request)
    {
        // Menghapus token untuk logout
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }






    public function logout(Request $request)
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Logout failed'], 500);
        }
    }



    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
