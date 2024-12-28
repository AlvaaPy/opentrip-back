<?php

namespace App\Http\Controllers;

use App\Mail\CustomTripStatusUpdated;
use App\Models\customTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class adminCustomTrip extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexWeb()
    {
        //
        $customTrips = customTrip::with(['user', 'packageTrip', 'city'])->get();
        return view('pages.Request.customTrip', compact('customTrips'));
    }

    public function accept($id)
    {
        $customTrip = CustomTrip::findOrFail($id);
        $customTrip->status = 'Diterima'; // Mengubah status menjadi 'Diterima'
        $customTrip->save();

        // Kirim email pemberitahuan
        Mail::to($customTrip->user->email)->send(new CustomTripStatusUpdated($customTrip, 'Diterima'));

        return redirect()->back()->with('success', 'Custom trip diterima dan email sudah dikirim.');
    }

    public function reject($id)
    {
        $customTrip = CustomTrip::findOrFail($id);
        $customTrip->status = 'Ditolak'; // Mengubah status menjadi 'Ditolak'
        $customTrip->save();

        // Kirim email pemberitahuan
        Mail::to($customTrip->user->email)->send(new CustomTripStatusUpdated($customTrip, 'Ditolak'));

        return redirect()->back()->with('success', 'Custom trip ditolak dan email sudah dikirim.');
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
