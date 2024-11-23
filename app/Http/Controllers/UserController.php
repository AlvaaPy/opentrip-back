<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'getAllUser', 'verifyOtp', 'setPin', 'completeProfile', 'updateProfile']]);
        
    }

    public function register(Request $request)
    {
        Log::info('Starting registration with email and password only');

        // Validasi hanya untuk email dan password
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat user baru dengan email dan password saja
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate OTP dan kirim via email
            $otp = $user->generateOtp();
            Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

            Log::info('User registered with email and password. OTP sent.', ['user' => $user]);

            return response()->json(['message' => 'Registration successful. Please check your email for OTP.'], 201);
        } catch (\Exception $e) {
            Log::error('Error during registration', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Registration failed. Please try again.'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        Log::info('Verifying OTP');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('User not found', ['email' => $request->email]);
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
            Log::error('OTP expired', ['email' => $request->email]);
            return response()->json(['message' => 'OTP expired. Please request a new OTP.'], 400);
        }

        if ($user->otp == $request->otp) {
            $user->email_verified_at = now();
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            Log::info('OTP verified successfully', ['user' => $user]);
            return response()->json(['message' => 'OTP verified. Please complete your profile.'], 200);
        }

        Log::error('Invalid OTP', ['email' => $request->email]);
        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

    public function completeProfile(Request $request)
    {
        Log::info('Completing profile for user', ['email' => $request->email]);

        // Validasi input pengguna termasuk foto
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'noTlpn' => 'required|string|max:15',
            'birthDate' => 'required|date',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'nullable|mimes:png,jpg,webp,jpeg|max:10240' // Validasi foto
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed for complete profile', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Cari user berdasarkan email
            $user = User::where('email', $request->email)->firstOrFail();

            // Cek dan proses file upload foto jika ada
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/profile_pictures'; // Path untuk penyimpanan foto profil
                $file->move(public_path($path), $filename);
                $user->profile_picture = $filename; // Simpan nama file ke kolom `profile_picture` pada user
            }

            // Update data user lainnya
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->noTlpn = $request->noTlpn;
            $user->birthDate = $request->birthDate;
            $user->gender = $request->gender;
            $user->save();

            Log::info('Profile completed successfully', ['user' => $user]);
            return response()->json(['message' => 'Profile completed successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error during profile completion', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to complete profile. Please try again.'], 500);
        }
    }

    public function login(Request $request)
    {
        Log::info('Attempting login');

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::error('Login failed: user not found');
            return response()->json([
                'status' => 'error',
                'message' => 'User not found. Please check your credentials.'
            ], 404);
        }

        if (is_null($user->email_verified_at)) {
            Log::error('Login failed: email not verified');
            return response()->json([
                'status' => 'error',
                'message' => 'Please verify your email first before logging in.'
            ], 400);
        }

        if (!$token = auth()->attempt($credentials)) {
            Log::error('Login failed: invalid credentials');
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password. Please try again.'
            ], 401);
        }

        $user = auth()->user();

        Log::info('Login successful', ['user' => $user]);
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'username' => $user->username,  // Mengembalikan username
                    'email' => $user->email,
                    'profile_picture' => $user->profile_picture
                ],
                'token' => $this->respondWithToken($token)
            ]
        ], 200);
    }


    public function setPin(Request $request, $userID)
    {
        $request->validate([
            'pin' => 'required|string|size:4' // Pastikan PIN adalah 4 digit dan unik
        ]);

        try {
            $user = User::findOrFail($userID);
            $user->pin = Hash::make($request->pin);  // PIN disimpan dalam bentuk hash
            $user->save();
            Log::info('PIN telah diset untuk pengguna', ['user' => $user->userID]);
            return response()->json(['message' => 'PIN berhasil diset.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan PIN. Silakan coba lagi.'], 500);
        }
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->logout();
            Log::info('User logged out successfully');

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed'
            ], 500);
        }
    }

    public function refresh()
    {
        Log::info('Refreshing token'); // Log token refresh
        return $this->respondWithToken(auth()->refresh());
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        try {
            $user = auth()->user();

            if (!$user) {
                Log::warning('Unauthorized access attempt to user profile');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], 401);
            }

            Log::info('User profile fetched successfully', ['user_id' => $user->id]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'fullname' => $user->fullname,
                    'noTlpn' => $user->noTlpn,
                    'birthDate' => $user->birthDate,
                    'gender' => $user->gender,
                    'profile_picture' => $user->profile_picture,
                    // Add any other fields you want to return
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching user profile: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch user profile'
            ], 500);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }



    // web admin
    // get all user
    public function getAllUser()
    {
        Log::info('Fetching all users'); // Log fetching all users
        $users = User::all();
        return  view('pages.users.pengguna', compact('users'));
    }

    // Update user
    public function updateProfile(Request $request, $userID)
    {
        Log::info('Request received for updating profile', [
            'user_id' => $userID,
            'request_data' => $request->all(), // Log semua input teks
            'file_data' => $request->file('profile_picture'), // Log informasi file
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'noTlpn' => 'required|string|max:15',
            'birthDate' => 'required|date',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'nullable|mimes:png,jpg,webp,jpeg|max:10240', // Validasi file
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Cari user berdasarkan ID
            $user = User::findOrFail($userID);

            // Handle upload file baru
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/profile_pictures';

                // Hapus file lama jika ada
                if ($user->profile_picture && File::exists(public_path($path) . '/' . $user->profile_picture)) {
                    File::delete(public_path($path) . '/' . $user->profile_picture);
                }

                // Simpan file baru
                $file->move(public_path($path), $filename);
                $user->profile_picture = $filename;
            }

            // Update data pengguna
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->noTlpn = $request->noTlpn;
            $user->birthDate = $request->birthDate;
            $user->gender = $request->gender;
            $user->save();

            Log::info('Profile updated successfully:', ['user' => $user]);

            return response()->json([
                'message' => 'Profile updated successfully.',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating profile:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update profile. Please try again.'], 500);
        }
    }


    public function updateProfileWeb(Request $request, $userID)
    {
        Log::info('Request received for updating profile', [
            'user_id' => $userID,
            'request_data' => $request->all(), // Log semua input teks
            'file_data' => $request->file('profile_picture'), // Log informasi file
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'noTlpn' => 'required|string|max:15',
            'birthDate' => 'required|date',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'nullable|mimes:png,jpg,webp,jpeg|max:10240', // Validasi file
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Cari user berdasarkan ID
            $user = User::findOrFail($userID);

            // Handle upload file baru
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/profile_pictures';

                // Hapus file lama jika ada
                if ($user->profile_picture && File::exists(public_path($path) . '/' . $user->profile_picture)) {
                    File::delete(public_path($path) . '/' . $user->profile_picture);
                }

                // Simpan file baru
                $file->move(public_path($path), $filename);
                $user->profile_picture = $filename;
            }

            // Update data pengguna
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->noTlpn = $request->noTlpn;
            $user->birthDate = $request->birthDate;
            $user->gender = $request->gender;
            $user->save();

            Log::info('Profile updated successfully:', ['user' => $user]);

            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/pengguna');
        } catch (\Exception $e) {
            Log::error('Error updating profile:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update profile. Please try again.'], 500);
        }
    }

    public function editWeb($userID){
        // Find the user, or throw 404 if not found
        $user = User::findOrFail($userID);
        // Load necessary data for the edit view
        return view('pages.users.edit', compact('user'));
    }

    // delete user

}
