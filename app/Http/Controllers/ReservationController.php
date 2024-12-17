<?php

namespace App\Http\Controllers;

use App\Models\PackageTrip;
use App\Models\reservation;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'index', 'show']]);
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                Log::error('Token tidak valid atau user tidak ditemukan.');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access',
                ], 401);
            }

            $validate = $request->validate([
                'tripID' => 'required|exists:package_trip,tripID',
                'jumlah_peserta' => 'required|integer|min:1',
                'nama_pemesan' => 'required|string|max:255',
                'email_pemesan' => 'required|email',
                'no_telepon_pemesan' => 'required|string|max:15',
                'meeting_points' => 'required|string|max:255',
                'tgl_reservation' => 'required|date',
                'tgl_start' => 'required|date|after_or_equal:tgl_reservation',
                'tgl_end' => 'required|date|after_or_equal:tgl_start',
                'voucherID' => 'nullable|exists:vouchers,voucherID',
            ]);

            $validate['userID'] = $user->userID;

            $trip = PackageTrip::findOrFail($validate['tripID']);
            $totalHarga = $trip->price * $validate['jumlah_peserta'];

            if ($validate['voucherID']) {
                $voucher = Voucher::find($validate['voucherID']);
                if ($voucher && $voucher->is_active && now()->between($voucher->valid_from, $voucher->valid_until)) {
                    $discount = $voucher->fixed_discount ?: ($totalHarga * ($voucher->percentage_discount / 100));
                    $totalHarga = max($totalHarga - $discount, 0);
                }
            }

            // Menetapkan status default
            $status = 'Pending';  // Status default untuk reservasi baru

            $reservation = Reservation::create(array_merge($validate, [
                'total_harga' => $totalHarga,
                'status' => $status,
            ]));

            Log::info('Reservasi baru: ' . $reservation->reservationID);

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dibuat',
                'data' => $reservation
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating reservation: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create reservation',
            ], 500);
        }
    }

    public function store2(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access',
                ], 401);
            }

            // Validasi data
            $validate = $request->validate([
                'tripID' => 'required|exists:package_trip,tripID',
                'jumlah_peserta' => 'required|integer|min:1',
                'nama_pemesan' => 'required|string|max:255',
                'email_pemesan' => 'required|email',
                'no_telepon_pemesan' => 'required|string|max:15',
                'meeting_points' => 'required|string|max:255',
                'tgl_reservation' => 'required|date',
                'tgl_start' => 'required|date|after_or_equal:tgl_reservation',
                'tgl_end' => 'required|date|after_or_equal:tgl_start',
                'voucherID' => 'nullable|exists:vouchers,voucherID',
                'participants' => 'nullable|array',
                'participants.*.nama_peserta' => 'required_with:participants|string|max:255',
                'participants.*.email_peserta' => 'required_with:participants|email',
            ]);

            $validate['userID'] = $user->userID;

            // Hitung total harga
            $trip = PackageTrip::findOrFail($validate['tripID']);
            $totalHarga = $trip->price * $validate['jumlah_peserta'];

            // Cek voucher
            if ($validate['voucherID']) {
                $voucher = Voucher::find($validate['voucherID']);
                if ($voucher && $voucher->is_active && now()->between($voucher->valid_from, $voucher->valid_until)) {
                    $discount = $voucher->fixed_discount ?: ($totalHarga * ($voucher->percentage_discount / 100));
                    $totalHarga = max($totalHarga - $discount, 0);
                }
            }

            // Simpan data reservasi
            $reservation = Reservation::create(array_merge($validate, [
                'total_harga' => $totalHarga,
                'status' => 'Pending', // Status default
                'participants' => $validate['jumlah_peserta'] > 1 ? json_encode($validate['participants']) : null,
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dibuat',
                'data' => $reservation,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create reservation',
            ], 500);
        }
    }


    public function index()
    {
        $reservation = reservation::with(['user', 'packageTrip', 'voucher'])->get();
        return response()->json($reservation, 200) ;

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
    public function show($id)
    {
        $reservation = reservation::with(['user', 'packageTrip', 'voucher'])->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Package trip not found'], 404); // Status Not Found
        }

        return response()->json($reservation, 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reservation $reservation)
    {
        //
    }
}
