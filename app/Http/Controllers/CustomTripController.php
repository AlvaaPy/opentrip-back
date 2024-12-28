<?php

namespace App\Http\Controllers;

use App\Models\customTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }
    public function index()
    {
        //
        $customTrips = customTrip::with(['user', 'packageTrip', 'city'])->get();
        return response()->json($customTrips);
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
    public function store(Request $request)
    {
        try {
            // Mendapatkan user dari token
            $user = auth()->user();

            if (!$user) {
                Log::error('Token tidak valid atau user tidak ditemukan.');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access',
                ], 401);
            }


            // Validasi data request
            $validate = $request->validate([
                'nama_pemesan' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'jumlah_peserta' => 'required|integer|min:1',
                'tripID' => 'nullable|exists:package_trip,tripID',
                'judul_trip' => 'nullable|string',
                'jenis_custom' => 'required|in:Individu,Perusahaan,Sekolah,Universitas',
                'cityID' => 'required|exists:cities,cityID',
                'alamat_detail' => 'required|string',
                'catatan' => 'nullable|string',
            ]);

            // Tambahkan userID dari token ke data yang akan disimpan
            $validate['userID'] = $user->userID;

            // Simpan data
            $customTrip = CustomTrip::create($validate);

            Log::info('CustomTrip created successfully', ['customTrip_id' => $customTrip->customID]);

            return response()->json([
                'status' => 'success',
                'message' => 'CustomTrip berhasil dibuat.',
                'data' => $customTrip,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating CustomTrip: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create CustomTrip',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($customID)
    {
        //
        $customTrips = customTrip::with(['user', 'packageTrip', 'city'])->find($customID);
        if (!$customTrips) {
            return response()->json(['message' => 'CustomTrip tidak ditemukan.'], 404);
        }

        return response()->json($customTrips);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customTrip $customTrip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customTrip $customTrip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customTrip $customTrip)
    {
        //
    }
}
