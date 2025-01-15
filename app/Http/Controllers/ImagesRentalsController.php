<?php

namespace App\Http\Controllers;

use App\Models\images_rentals;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImagesRentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = images_rentals::with('rentals')->get();
        return response()->json($assets, 200);
    }

    

    public function indexWeb()
    {
        //get all image for web
        $assets = images_rentals::with('rentals')->get();
        return view('pages.rental.assets.assets', compact('assets'));
    }

    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'rentalID' => 'required|exists:rentals,rentalID', // Validasi bahwa rentalID ada di tabel package_trips
            'picture.*' => 'mimes:png,jpg,webp,jpeg|max:2048' // Validasi setiap file dalam array
        ]);
    
        try {
            $rentalID = $request->rentalID; // Ambil rentalID dari request
            $imageData = [];
    
            // Log validasi berhasil
            Log::info('Validation passed, rentalID: ' . $rentalID);
    
            if ($files = $request->file('picture')) {
                Log::info('Files received: ' . count($files)); // Log jumlah file yang diterima
    
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = "uploads/img/rental/assets/";
    
                    // Pindahkan file ke path yang ditentukan
                    $file->move(public_path($path), $filename);
    
                    // Simpan data gambar ke dalam array untuk di-insert ke database
                    $imageData[] = [
                        'rentalID' => $rentalID, // Set rentalID yang diterima dari request
                        'picture' => $path . $filename,
                    ];
    
                    // Log nama file yang diproses
                    Log::info('File processed: ' . $filename);
                }
    
                // Simpan data gambar ke tabel package_trip_assets menggunakan model rentalsAsset
                images_rentals::insert($imageData);
    
                // Log data gambar berhasil disimpan
                Log::info('Images successfully inserted to database.');
    
                session()->flash('success', 'Data berhasil disimpan!');
    
                // Redirect ke halaman trip
                return redirect('/image-rental');
            } else {
                // Log jika tidak ada gambar yang diterima
                Log::warning('No images found to upload.');
    
                return response()->json([
                    'status' => 'error',
                    'message' => 'No images found to upload'
                ], 400);
            }
        } catch (\Exception $e) {
            // Log error jika terjadi exception
            Log::error('Error occurred while uploading images: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while uploading images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rentals = Rental::all(); // Mengambil semua data negara dari tabel 'rentalss'
        return view('pages.rental.assets.add', compact('rentals')); // Pastikan view sesuai
    }


    /**
     * Display the specified resource.
     */
    public function show(images_rentals $images_rentals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(images_rentals $images_rentals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, images_rentals $images_rentals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(images_rentals $images_rentals)
    {
        //
    }
}
