<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rental = Rental::all();
        return response()->json($rental, 200);
    }


    // Create Data Rental
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'nama_kendaraan' => 'required|string|max:255',
                'kapasitas_kendaraan' => 'required|integer',
                'kapasitas_bagasi' => 'required|integer', 
                'umur_kendaraan' => 'required|integer',
                'jenis_kendaraan' => 'required|in:metic,automatic',
                'deskripsi' => 'nullable|string',
                'dengan_supir' => 'required|in:ya,tidak',
                'harga' => 'required|numeric',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk foto
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/rental/foto';
                $file->move(public_path($path), $filename);
            } else {
                $filename = null; // Default jika tidak ada file
            }

            $rentals = Rental::create([
                'nama_kendaraan' => $validateData['nama_kendaraan'],
                'kapasitas_kendaraan' => $validateData['kapasitas_kendaraan'],
                'kapasitas_bagasi' => $validateData['kapasitas_bagasi'],
                'umur_kendaraan' => $validateData['umur_kendaraan'],
                'jenis_kendaraan' => $validateData['jenis_kendaraan'],
                'deskripsi' => $validateData['deskripsi'],
                'dengan_supir' => $validateData['dengan_supir'],
                'harga' => $validateData['harga'],
                'foto' => $filename,
            ]);

            return response()->json([
                'message' => 'Data Rental/Sewa Kendaraan Berhasil Dibuat!',
                'data' => $rentals
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catat log error validasi dan kirimkan respons
            Log::error('Validation error during rental creation', [
                'error' => $e->errors(),
                'request' => $request->all()
            ]);

            // Respons jika validasi gagal
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request
        } catch (\Exception $e) {
            // Catat log error umum dan kirimkan respons
            Log::error('Unexpected error during rental creation', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            // Respons jika terjadi error lainnya
            return response()->json([
                'message' => 'Unexpected error occurred',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }
}
