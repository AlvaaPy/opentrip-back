<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $rental = Rental::with(['images_rental'])->get();
        return response()->json([
            'message' => 'Data yang ditemukan: ' . $rental->count() . ' kendaraan',
            'data' => $rental
        ], 200);
    }

    public function show($id)
    {
        $rentals = Rental::with(['images_rental'])->find($id);
        if (!$rentals) {
            return response()->json(['message' => 'Rental/Sewa Kendaraan not found'], 404); // Status Not Found
        }
        return response()->json(['Data' => $rentals], 200);
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

            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Rental');
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
     * Display the specified resource.
     */




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Log awal untuk debug input
        Log::info('Update request received', ['id' => $id, 'data' => $request->all()]);
    
        // Validasi input
        $validatedData = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'kapasitas_kendaraan' => 'required|integer',
            'kapasitas_bagasi' => 'required|integer',
            'umur_kendaraan' => 'required|integer',
            'jenis_kendaraan' => 'required|in:metic,automatic',
            'deskripsi' => 'nullable|string',
            'dengan_supir' => 'required|in:ya,tidak',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            // Cari data Rental berdasarkan ID
            $rental = Rental::findOrFail($id);
            Log::info('Rental found', ['rental' => $rental]);
    
            // Jika ada file foto baru
            if ($request->hasFile('foto')) {
                Log::info('Processing image upload');
    
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/img/rental/foto';
    
                // Simpan file baru
                $file->move(public_path($path), $filename);
                Log::info('New image uploaded', ['filename' => $filename]);
    
                // Hapus file lama jika ada
                if ($rental->foto && File::exists(public_path($path) . '/' . $rental->foto)) {
                    File::delete(public_path($path) . '/' . $rental->foto);
                    Log::info('Old image deleted', ['filename' => $rental->foto]);
                }
    
                // Tambahkan nama file ke data yang akan diupdate
                $validatedData['foto'] = $filename;
            }
    
            // Update data di database
            $rental->update($validatedData);
            Log::info('Rental updated successfully', ['updated_rental' => $rental]);
    
            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Rental');
        } catch (\Throwable $th) {
            // Log jika terjadi error
            Log::error('Update failed', ['error' => $th->getMessage()]);
    
            // Kembalikan respons error
            return response()->json([
                'message' => 'Update failed',
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rentals = Rental::find($id);
        if (!$rentals) {
            return response()->json(['message' => 'Rental/Sewa Kendaraan not found'], 404); // Status Not Found
        }

        $rentals->delete();

        //response with log
        Log::info('Rental deleted successfully', ['id' => $id]);

        return redirect()->back()->with('message', 'Package trip deleted successfully');
        
    }

    public function editWeb($id)
    {
        // Find the package trip, or throw 404 if not found
        $rentals = Rental::findOrFail($id);

        // Load necessary data for the edit view
        return view('pages.rental.update', compact('rentals'));
    }

}
