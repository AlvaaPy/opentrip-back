<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoucherController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['store']]);
    }


    public function store(Request $request)
    {
        //
        try {
            // $user = auth()->user();

            // if (!$user) {
            //     Log::error('Token tidak valid atau user tidak ditemukan.');
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Unauthorized access',
            //     ], 401);
            // }
            
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

            // Handle Picture
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/voucher';
                $file->move(public_path($path), $filename);
            } else {
                $filename = null; // Default jika tidak ada file
            }

            $voucher = Voucher::create([
                'voucher_code' => $validate['voucher_code'],
                'fixed_discount' => $validate['fixed_discount'],
                'percentage_discount' => $validate['percentage_discount'],
                'voucher_type' => $validate['voucher_type'],
                'tripID' => $validate['tripID'],
                'valid_from' => $validate['valid_from'],
                'valid_until' => $validate['valid_until'],
                'is_active' => $validate['is_active'],
                'picture' => $filename,
            ]);

            // kasih log info dong
            Log::info('Menambahkan voucher baru');
            Log::info('ID voucher: '. $voucher->voucherID);
            Log::info('Kode voucher: '. $voucher->voucher_code);
            Log::info('Tipe voucher: '. $voucher->voucher_type);
            Log::info('Trip ID: '. $voucher->tripID);
            Log::info('Diskon tetap: '. $voucher->fixed_discount);
            Log::info('Diskon persentase: '. $voucher->percentage_discount);
            Log::info('Tanggal mulai berlaku: '. $voucher->valid_from);
            Log::info('Tanggal berakhir berlaku: '. $voucher->valid_until);
            Log::info('Status voucher: '. ($voucher->is_active? 'Aktif' : 'Tidak Aktif'));

            

            // response
            return response()->json([
                'status' =>'success',
                'message' => 'Voucher berhasil ditambahkan',
                'data' => $voucher,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error menambahkan voucher: '. $e->getMessage());
            return response()->json([
                'message' => 'Gagal menambahkan voucher',
            ], 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

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
    public function show(Voucher $Voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $Voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $Voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $Voucher)
    {
        //
    }
}
