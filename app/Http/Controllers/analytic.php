<?php

namespace App\Http\Controllers;

use App\Models\customTrip;
use App\Models\PackageTrip;
use App\Models\reservation;
use App\Models\User;
use Illuminate\Http\Request;

class analytic extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAnalytics()
    {
        $totalTrip = PackageTrip::count();
        $totalOpenTrip = PackageTrip::where('trip_type', 'open')->count();
        $totalPrivateTrip = PackageTrip::where('trip_type', 'private')->count();

        // Custom Trip
        $totalCustom = customTrip::count();
        $totalDiterima = customTrip::where('status', 'Diterima')->count();
        $totalDitolak = customTrip::where('status', 'Ditolak')->count();
        $totalPanding = customTrip::where('status', 'Pending')->count();


        // Hitung jumlah total user
        $totalUser = User::count();


        // Menghitung total harga reservasi dan format ke Rupiah
        $totalReservasi = reservation::sum('total_harga');
        $formattedTotalReservasi = 'Rp ' . number_format($totalReservasi, 0, ',', '.');

        $reservasiCount = reservation::count();
        // Kirim semua data ke view
        return view(
            'component.master',
            compact(
                'totalOpenTrip',
                'totalUser',
                'totalPrivateTrip',
                'totalTrip',
                'totalCustom',
                'totalDiterima',
                'totalDitolak',
                'totalPanding',
                'formattedTotalReservasi',
                'reservasiCount'
            )
        );
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
