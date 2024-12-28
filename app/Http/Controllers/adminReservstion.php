<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\reservation;
use App\Models\Voucher;
use Illuminate\Http\Request;

class adminReservstion extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservation = reservation::with(['user', 'packageTrip', 'voucher'])->get();
        return response()->json($reservation, 200);
    }

    public function readVoucher()
    {
        $voucher = Voucher::all();
        return view('pages.voucher.voucher', compact('voucher'));
    }

    public function readReservasi()
    {
        $reservasi = reservation::with(['user', 'packageTrip', 'voucher'])->get();
        return view('pages.transaction.reservasi', compact('reservasi'));
    }

    public function filter(Request $request)
    {
        // Ambil parameter filter dan search dari request
        $status = $request->input('status');
        $search = $request->input('search');

        // Query dasar dengan relasi yang diperlukan
        $query = Reservation::with(['user', 'packageTrip', 'voucher']);

        // Tambahkan filter berdasarkan status jika ada
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Tambahkan pencarian berdasarkan nama user atau nama trip
        if (!empty($search)) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('fullname', 'like', "%$search%");
            })->orWhereHas('packageTrip', function ($q) use ($search) {
                $q->where('namaTrip', 'like', "%$search%");
            });
        }

        // Ambil data yang sudah difilter
        $reservasi = $query->get();

        // Return view atau response JSON
        return response()->json([
            'html' => view('pages.transaction.reservasi', compact('reservasi'))->render(),
        ]);
    }

    public function readRental()
    {
        $rentals = Rental::all();
        return view('pages.rental.rental', compact('rentals'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
