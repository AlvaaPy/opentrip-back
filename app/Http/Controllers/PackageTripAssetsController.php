<?php

namespace App\Http\Controllers;

use App\Models\PackageTripAsset;
use App\Models\PackageTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageTripAssetsController extends Controller
{
    public function index()
    {
        //get all image
        $assets = PackageTripAsset::with('packageTrip')->get();
        return response()->json($assets, 200);
    }

    public function indexWeb()
    {
        //get all image for web
        $assets = PackageTripAsset::with('packageTrip')->get();
        return view('pages.Trip.galery', compact('assets'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tripID' => 'required|exists:package_trip,tripID', // Validasi bahwa tripID ada di tabel package_trips
            'picture.*' => 'mimes:png,jpg,webp,jpeg|max:2048' // Validasi setiap file dalam array
        ]);

        try {
            $tripID = $request->tripID; // Ambil tripID dari request
            $imageData = [];

            if ($files = $request->file('picture')) {
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = "uploads/img/assetstrip/";

                    // Pindahkan file ke path yang ditentukan
                    $file->move(public_path($path), $filename);

                    // Simpan data gambar ke dalam array untuk di-insert ke database
                    $imageData[] = [
                        'tripID' => $tripID, // Set tripID yang diterima dari request
                        'picture' => $path . $filename,
                    ];
                }

                // Simpan data gambar ke tabel package_trip_assets menggunakan model PackageTripAsset
                PackageTripAsset::insert($imageData);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Images uploaded successfully',
                    'data' => $imageData
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No images found to upload'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while uploading images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeWeb(Request $request)
    {
        // Validasi input
        $request->validate([
            'tripID' => 'required|exists:package_trip,tripID', // Validasi bahwa tripID ada di tabel package_trips
            'picture.*' => 'mimes:png,jpg,webp,jpeg|max:2048' // Validasi setiap file dalam array
        ]);

        try {
            $tripID = $request->tripID; // Ambil tripID dari request
            $imageData = [];

            if ($files = $request->file('picture')) {
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = "uploads/img/assetstrip/";

                    // Pindahkan file ke path yang ditentukan
                    $file->move(public_path($path), $filename);

                    // Simpan data gambar ke dalam array untuk di-insert ke database
                    $imageData[] = [
                        'tripID' => $tripID, // Set tripID yang diterima dari request
                        'picture' => $path . $filename,
                    ];
                }

                // Simpan data gambar ke tabel package_trip_assets menggunakan model PackageTripAsset
                PackageTripAsset::insert($imageData);

                session()->flash('success', 'Data berhasil disimpan!');

                // Redirect ke halaman trip
                return redirect('/galery');
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No images found to upload'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while uploading images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $PackageTrip = PackageTrip::all(); // Mengambil semua data negara dari tabel 'PackageTrips'
        return view('pages.Trip.galery.addGalery', compact('PackageTrip')); // Pastikan view sesuai
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'picture' => 'nullable|mimes:png,jpg,webp,jpeg|max:10240', // maksimal ukuran 10MB
            'tripID' => 'required|exists:package_trip,tripID'
        ]);

        try {
            // Temukan asset berdasarkan ID atau berikan 404 jika tidak ditemukan
            $asset = PackageTripAsset::findOrFail($id);

            // Tangani upload file baru jika picture disediakan
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/img/assetstrip';

                // Pindahkan gambar baru ke direktori publik
                $file->move(public_path($path), $filename);

                // Hapus gambar lama jika ada dan filenya masih ada di direktori
                if ($asset->picture && File::exists(public_path($asset->picture))) {
                    File::delete(public_path($asset->picture));
                }

                // Update field picture dengan nama file baru
                $validatedData['picture'] = $path . '/' . $filename;
            }

            // Update data di database
            $asset->update($validatedData);

            // Set flash message dan redirect
            session()->flash('success', 'Data berhasil disimpan!');
            return redirect('/galery');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 400);
        } catch (\Exception $e) {
            // Tangani exception lain
            return response()->json([
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editWeb($id)
    {
        // Find the package trip, or throw 404 if not found
        $assets = PackageTripAsset::findOrFail($id);

        // Load necessary data for the edit view
        return view('pages.Trip.galery.editGalery', compact('assets'));
    }

    public function destroy($id)
    {
        try {
            // Temukan asset berdasarkan ID
            $asset = PackageTripAsset::findOrFail($id);

            // Hapus gambar dari direktori publik jika ada
            if ($asset->picture && File::exists(public_path($asset->picture))) {
                File::delete(public_path($asset->picture));
            }

            // Hapus data dari database
            $asset->delete();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('message', 'Package trip asset deleted successfully');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



}
