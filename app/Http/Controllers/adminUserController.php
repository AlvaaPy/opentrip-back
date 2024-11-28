<?php

namespace App\Http\Controllers;

use App\Models\M_Admin;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class adminUserController extends Controller
{


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

    public function editWeb($userID)
    {
        // Find the user, or throw 404 if not found
        $user = User::findOrFail($userID);
        // Load necessary data for the edit view
        return view('pages.users.edit', compact('user'));
    }

    public function getAllUser()
    {
        Log::info('Fetching all users'); // Log fetching all users
        $users = User::all();
        return  view('pages.users.pengguna', compact('users'));
    }

    public function destroy($userID)
    {
        $user = User::find($userID);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found'); // Menangani jika tidak ditemukan
        }
        $user->delete();
        return redirect()->back()->with('message', 'User deleted successfully');
    }


    // Admin
    public function getAllAdmin()
    {
        Log::info('Fetching all admin'); // Log fetching all users
        $admins = M_Admin::all();
        return  view('pages.users.admin', compact('admins'));
    }


    // Delete Admin
    public function destroyAdmin($adminID)
    {
        $admin = M_Admin::find($adminID);
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found'); // Menangani jika tidak ditemukan
        }
        $admin->delete();
        return redirect()->back()->with('message', 'Admin deleted successfully');
    }


    // Logout
    public function logout(Request $request)
    {

        return redirect()->route('login');
    }
    

    
}
