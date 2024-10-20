<?php

namespace App\Http\Controllers;

use App\Models\itenary_trip;
use App\Models\ItenaryTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItenaryTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data ItenaryTrip beserta relasi PackageTrip
        $itenaryTrips = ItenaryTrip::with('packageTrip')->get();

        return response()->json($itenaryTrips, 200);
    }
    public function indexWeb()
    {
        $itenaryTrip = ItenaryTrip::with('packageTrip')->get();

        return view('pages.Trip.itenary', compact('itenaryTrip'));
    }

    public function editWeb($id)
    {
        // Find the package trip, or throw 404 if not found
        $itenaryTrip = ItenaryTrip::findOrFail($id);

        // Load necessary data for the edit view
        return view('pages.Trip.updateItenary', compact('itenaryTrip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            // Validasi input
            $validatedData = $request->validate([
                'tripID' => 'required|exists:package_trip,tripID',
                'hari_ke' => 'required|integer',
                'deskripsi' => 'required|string',
                'waktu_mulai' => 'required|date_format:H:i',
                'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            ]);

            $itenaryTrip = ItenaryTrip::create($validatedData); // Membuat data baru

            return response()->json([
                'message' => 'Itenary trip created successfully',
                'data' => $itenaryTrip,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Respons untuk validasi input salah
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Respons untuk data yang tidak ditemukan (misal cityID tidak valid)
            return response()->json([
                'message' => 'Trip not found',
            ], 404); // Not Found

        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Respons untuk otentikasi gagal
            return response()->json([
                'message' => 'Unauthorized',
            ], 401); // Unauthorized

        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
            // Respons untuk akses ditolak
            return response()->json([
                'message' => 'Forbidden',
            ], 403); // Forbidden

        } catch (\Exception $e) {
            // Respons untuk kesalahan server lainnya
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(), // Untuk debugging, bisa dihapus di production
            ], 500); // Internal Server Error
        }
    }

    public function storeWeb(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'tripID' => 'required|exists:package_trip,tripID',
                'hari_ke' => 'required|integer',
                'deskripsi' => 'required|string',
                'waktu_mulai' => 'required|date_format:H:i',
                'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            ]);

            // Membuat data baru untuk ItenaryTrip
            $itenaryTrip = ItenaryTrip::create([
                'tripID' => $validatedData['tripID'],
                'hari_ke' => $validatedData['hari_ke'],
                'deskripsi' => $validatedData['deskripsi'],
                'waktu_mulai' => $validatedData['waktu_mulai'],
                'waktu_selesai' => $validatedData['waktu_selesai'],
            ]);

            // Flash session message untuk notifikasi keberhasilan
            session()->flash('success', 'Itenary Trip berhasil ditambahkan!');

            // Redirect ke halaman itenary trip
            return redirect('/itenaryTrip');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Trip not found',
            ], 404); // Not Found

        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401); // Unauthorized

        } catch (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403); // Forbidden

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(), // Bisa dihapus di production
            ], 500); // Internal Server Error
        }
    }

    // update
    public function update(Request $request, $id)
    {

        $validateData =  $request->validate([
            'tripID' => 'required|exists:package_trip,tripID',
            'hari_ke' => 'required|integer',
            'deskripsi' => 'required|string',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        // jika id tidak ada?
        if (!ItenaryTrip::find($id)) {
            return response()->json([
                'message' => 'Itenary Trip not found',
            ], 404);
        }

        // update data
        ItenaryTrip::find($id)->update($validateData);

        return response()->json([
            'message' => 'Itenary Trip updated successfully',
            'data' => ItenaryTrip::find($id),
        ], 200);
    }

    public function updateWeb(Request $request, $id)
    {
        try {
            // Validasi input
            $validateData = $request->validate([
                'tripID' => 'required|exists:package_trip,tripID',
                'hari_ke' => 'required|integer',
                'deskripsi' => 'required|string',
                'waktu_mulai' => 'required|date_format:H:i',
                'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            ]);

            // Cek apakah ItenaryTrip dengan ID ada
            $itenaryTrip = ItenaryTrip::find($id);
            if (!$itenaryTrip) {
                Log::error('Itenary Trip not found with ID: ' . $id);
                return response()->json([
                    'message' => 'Itenary Trip not found',
                ], 404);
            }


            // update data
            Log::info('Updating Itenary Trip with data: ', $validateData);
            $itenaryTrip->update($validateData);

            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/itenaryTrip');
        } catch (\Exception $e) {
            // Tangkap error dan log
            Log::error('Error updating Itenary Trip: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Update failed, please try again.']);
        }
    }


    // delete
    public function destroy($id)
    {
        $itenaryTrip = ItenaryTrip::find($id);

        if (!$itenaryTrip) {
            return redirect()->back()->with('error', 'Package trip not found'); // Menangani jika tidak ditemukan
        }

        $itenaryTrip->delete();

        return redirect()->back()->with('message', 'Package trip deleted successfully');
    }

}
