<?php

namespace App\Http\Controllers;

use App\Models\PackageTrip;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class adminVoucher extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = \App\Models\Voucher::with('packageTrip')->get();
        return view('pages.voucher.voucher', compact('voucher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'voucher_code' => 'required|string|unique:vouchers,voucher_code|max:255',
                'fixed_discount' => 'nullable|numeric|min:0',
                'percentage_discount' => 'nullable|numeric|min:0|max:100',
                'voucher_type' => 'required|in:general,specific',
                'tripID' => 'nullable|exists:package_trip,tripID',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after_or_equal:valid_from',
                'is_active' => 'required|boolean',
                'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Validasi tambahan untuk tipe voucher "specific"
            if ($validate['voucher_type'] === 'specific' && empty($validate['tripID'])) {
                return back()->withErrors(['tripID' => 'Trip wajib dipilih untuk tipe voucher specific.'])->withInput();
            }

            // Handle Picture
            $filename = null; // Default jika tidak ada file
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/voucher';
                $file->move(public_path($path), $filename);
            }

            // Simpan data ke database
            $voucher = \App\Models\Voucher::create([
                'voucher_code' => $validate['voucher_code'],
                'fixed_discount' => $validate['fixed_discount'],
                'percentage_discount' => $validate['percentage_discount'],
                'voucher_type' => $validate['voucher_type'],
                'tripID' => $validate['voucher_type'] === 'specific' ? $validate['tripID'] : null,
                'valid_from' => $validate['valid_from'],
                'valid_until' => $validate['valid_until'],
                'is_active' => $validate['is_active'],
                'picture' => $filename,
            ]);

            // Log yang relevan
            Log::info('Voucher baru berhasil ditambahkan', [
                'voucherID' => $voucher->voucherID,
                'voucher_code' => $voucher->voucher_code,
                'voucher_type' => $voucher->voucher_type,
                'tripID' => $voucher->tripID,
                'valid_from' => $voucher->valid_from,
                'valid_until' => $voucher->valid_until,

            ]);

            // Redirect dengan pesan sukses
            session()->flash('success', 'Data berhasil disimpan!');
            return redirect('/Voucher');
        } catch (\Exception $e) {
            Log::error('Error menambahkan voucher: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menambahkan voucher',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $Vouchers = PackageTrip::all(); // Mengambil semua data negara dari tabel 'Vouchers'
        return view('pages.voucher.CU.add', compact('Vouchers')); // Pastikan view sesuai
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //Log
        Log::info('Update Request ', ['id' => $id, 'data' => $request->all()]);

        // Validasi
        $validatedData = $request->validate([
            'voucher_code' => 'required|string|unique:vouchers,voucher_code|max:255',
            'fixed_discount' => 'nullable|numeric|min:0',
            'percentage_discount' => 'nullable|numeric|min:0|max:100',
            'voucher_type' => 'required|in:general,specific',
            'tripID' => 'nullable|exists:package_trip,tripID',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active' => 'required|boolean',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);

            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/img/voucher';

                //Simpan file baru
                $file->move(public_path($path), $filename);
                //Hapus file lama jika ada
                if ($voucher->picture && File::exists(public_path($path) . '/' . $voucher->picture)) {
                    File::delete(public_path($path) . '/' . $voucher->picture);
                    Log::info('Foto lama terganti', ['filename' => $voucher->picture]);
                }

                $validatedData['picture'] = $filename;
            }

            $voucher->update($validatedData);
            Log::info('Voucher updated successfully', ['update_voucher' => $voucher]);

            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Voucher');
        } catch (\Throwable $th) {
            Log::error('Error updating voucher: ' . $th->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan data',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data voucher berdasarkan ID
        $voucher = Voucher::findOrFail($id);
    
        // Ambil semua trip untuk dropdown
        $trips = PackageTrip::all();
    
        // Kirim data voucher dan trips ke view
        return view('pages.voucher.CU.update', compact('voucher', 'trips'));
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            return redirect()->back()->with('error', 'Voucher not found'); // Menangani jika tidak ditemukan
        }
        $voucher->delete();
        return redirect()->back()->with('message', 'Package trip deleted successfully');
    }
}
