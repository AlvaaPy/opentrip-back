<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'noTlpn' => 'required|string|max:15',
        'birthDate' => 'required|date',
        'gender' => 'required|in:male,female',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422); // 422 Unprocessable Entity
    }

    $user = User::create([
        'fullname' => $request->fullname,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'noTlpn' => $request->noTlpn,
        'birthDate' => $request->birthDate,
        'gender' => $request->gender,
    ]);

    return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
}

public function login(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:6',
    ]);

    // Check if email and password fields are empty
    if (empty($request->email) || empty($request->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Email and password fields are required.'
        ], 400); // Bad Request status code
    }

    // Get credentials
    $credentials = $request->only('email', 'password');

    // Attempt to log the user in
    if (!$token = auth()->attempt($credentials)) {
        // If login fails, return unauthorized error with a descriptive message
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password. Please try again.'
        ], 401); // Unauthorized status code
    }

    // If successful, return the token with a success message
    return response()->json([
        'status' => 'success',
        'message' => 'Login successful',
        'data' => $this->respondWithToken($token)
    ], 200); // OK status code
}


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
