<?php

namespace App\Http\Controllers;

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
        return response()->json($reservation, 200) ;

    }

    public function readVoucher()
    {
        $voucher = Voucher::all();
        return view('pages.voucher.voucher', compact('voucher'));
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
