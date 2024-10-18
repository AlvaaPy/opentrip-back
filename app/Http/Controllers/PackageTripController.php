<?php

namespace App\Http\Controllers;

use App\Models\PackageTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageTripController extends Controller
{

    // Menampilkan semua paket trip
    public function index()
    {
        $packageTrips = PackageTrip::with('city')->get(); // Relasi dengan model City
        return response()->json($packageTrips, 200);
    }

    // Menyimpan paket trip baru
    public function store(Request $request)
    {

        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // Validasi input
            $validatedData = $request->validate([
                'namaTrip' => 'required|string|max:255',
                'cityID' => 'required|exists:cities,cityID',
                'alamat' => 'required|string',
                'deskripsi' => 'required|string',
                'meeting_point' => 'required|string',
                'price' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'rating' => 'nullable|numeric|min:0|max:5',
                'picture' => 'required|mimes:png,jpg,webp,jpeg|max:2048',
            ]);

            // Handle file upload jika ada gambar
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/trip';
                $file->move(public_path($path), $filename);
            } else {
                $filename = null; // Default jika tidak ada file
            }

            // Membuat package trip
            $packageTrip = PackageTrip::create([
                'namaTrip' => $validatedData['namaTrip'],
                'cityID' => $validatedData['cityID'],
                'alamat' => $validatedData['alamat'],
                'deskripsi' => $validatedData['deskripsi'],
                'meeting_point' => $validatedData['meeting_point'],
                'price' => $validatedData['price'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'rating' => $validatedData['rating'],
                'picture' => $filename,
            ]);

            // Load relasi dengan city
            $packageTrip->load('city');

            // Berhasil, mengembalikan respons dengan status 201 Created
            return response()->json([
                'message' => 'Package trip created successfully',
                'data' => $packageTrip,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Respons untuk validasi input salah
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Respons untuk data yang tidak ditemukan (misal cityID tidak valid)
            return response()->json([
                'message' => 'City not found',
            ], 404); // Not Found

        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Respons untuk otentikasi gagal
            return response()->json([
                'message' => 'Unauthorized',
            ], 401); // Unauthorized

        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
            // Respons untuk akses ditolak
            return response()->json([
                'message' => 'Forbidden',
            ], 403); // Forbidden

        } catch (\Exception $e) {
            // Respons untuk kesalahan server lainnya
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(), // Untuk debugging, bisa dihapus di production
            ], 500); // Internal Server Error
        }
    }




    // Menampilkan detail paket trip berdasarkan ID
    public function show($id)
    {
        $packageTrip = PackageTrip::with('city')->find($id);

        if (!$packageTrip) {
            return response()->json(['message' => 'Package trip not found'], 404); // Status Not Found
        }

        return response()->json($packageTrip, 200);
    }

    // Mengupdate paket trip berdasarkan ID
    public function update(Request $request, $id)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'namaTrip' => 'required|string|max:255',
            'cityID' => 'required|exists:cities,cityID',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'meeting_point' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rating' => 'nullable|numeric|min:0|max:5',
            'picture' => 'nullable|mimes:png,jpg,webp,jpeg|max:2048',
        ]);
        
        try {
            // Find the package trip, or throw 404 if not found
            $packageTrip = PackageTrip::findOrFail($id);

            // Handle file upload if a new picture is provided
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/img/trip';

                // Move new image to public directory
                $file->move(public_path($path), $filename);

                // Delete the old picture if it exists
                if ($packageTrip->picture && File::exists(public_path($path) . '/' . $packageTrip->picture)) {
                    File::delete(public_path($path) . '/' . $packageTrip->picture);
                }

                // Update the picture field with the new filename
                $validatedData['picture'] = $filename;
            }

            // Update the package trip with the validated data
            $packageTrip->update($validatedData);

            // Load related city data and return the response
            $packageTrip->load('city');

            return response()->json([
                'message' => 'Package trip updated successfully',
                'data' => $packageTrip
            ], 201); // Status OK
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(), // For debugging, can be removed in production
            ], 500); // Internal Server Error
        }
    }


    // Menghapus paket trip berdasarkan ID
    public function destroy($id)
    {
        $packageTrip = PackageTrip::find($id);

        if (!$packageTrip) {
            return response()->json(['message' => 'Package trip not found'], 404);
        }

        $packageTrip->delete();

        return response()->json(['message' => 'Package trip deleted successfully'], 200);
    }

    //     public function destroy($id)
    //    {
    //        $country = PackageTrip::findOrFail($id);
    //        $country->delete();

    //        return response()->json(['message' => 'Package trip deleted successfully'], 200);
    //    }
}
