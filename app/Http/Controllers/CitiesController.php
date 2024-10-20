<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\provinces;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    // Get all cities
    public function index()
    {
        $cities = Cities::with('country', 'province')->get();
        return response()->json($cities, 200);
    }
    public function indexWeb()
    {
        $cities = Cities::with('country', 'province')->get();
        return view('pages.locate.city', compact('cities'));
    }

    // Create new city
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        // Ambil data provinsi terkait dan dapatkan countryID-nya
        $province = provinces::where('provinceID', $request->provinceID)->first();

        // Periksa apakah provinsi ditemukan dan memiliki countryID
        if ($province && $province->countryID) {
            // Buat record baru di tabel cities
            $city = Cities::create([
                'provinceID' => $request->provinceID,
                'city_name' => $request->city_name,
                'countryID' => $province->countryID, // Ambil countryID dari provinsi terkait
            ]);

            return response()->json(['message' => 'City created successfully', 'city' => $city], 201);
        } else {
            // Jika provinsi tidak valid atau tidak memiliki countryID, kembalikan error
            return response()->json(['message' => 'Invalid province or province does not have an associated country'], 400);
        }
    }


    public function storeWeb(Request $request)
    {
        // Validasi input
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        // Ambil data provinsi terkait dan dapatkan countryID-nya
        $province = provinces::where('provinceID', $request->provinceID)->first();

        // Periksa apakah provinsi ditemukan dan memiliki countryID
        if ($province && $province->countryID) {
            // Buat record baru di tabel cities
            $city = Cities::create([
                'provinceID' => $request->provinceID,
                'city_name' => $request->city_name,
                'countryID' => $province->countryID, // Ambil countryID dari provinsi terkait
            ]);

            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/City');;
        }
    }

    // Get single city by ID
    public function show($id)
    {
        $city = Cities::with('province')->findOrFail($id);
        return response()->json($city, 200);
    }

    // Update city by ID
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        // Ambil data provinsi terkait dan dapatkan countryID-nya
        $province = Provinces::where('provinceID', $request->provinceID)->first();

        // Periksa apakah provinsi ditemukan dan memiliki countryID
        if ($province && $province->countryID) {
            // Temukan kota yang akan diupdate
            $city = Cities::findOrFail($id);

            // Update data kota dengan provinceID dan countryID yang sesuai
            $city->update([
                'provinceID' => $request->provinceID,
                'city_name' => $request->city_name,
                'countryID' => $province->countryID, // Ambil countryID dari provinsi terkait
            ]);

            return response()->json(['message' => 'City updated successfully', 'city' => $city], 200);
        } else {
            // Jika provinsi tidak valid atau tidak memiliki countryID, kembalikan error
            return response()->json(['message' => 'Invalid province or province does not have an associated country'], 400);
        }
    }


    public function updateWeb(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        // Ambil data provinsi terkait dan dapatkan countryID-nya
        $province = Provinces::where('provinceID', $request->provinceID)->first();

        // Periksa apakah provinsi ditemukan dan memiliki countryID
        if ($province && $province->countryID) {
            // Temukan kota yang akan diupdate
            $city = Cities::findOrFail($id);

            // Update data kota dengan provinceID dan countryID yang sesuai
            $city->update([
                'provinceID' => $request->provinceID,
                'city_name' => $request->city_name,
                'countryID' => $province->countryID, // Ambil countryID dari provinsi terkait
            ]);


        session()->flash('success', 'Data berhasil disimpan!');

        // Redirect ke halaman trip
        return redirect('/City');
    }
}

    public function editWeb($id)
    {
        // Find the package trip, or throw 404 if not found
        $cities = cities::findOrFail($id);

        // Load necessary data for the edit view
        return view('pages.locate.city.update', compact('cities'));
    }

    // Delete city by ID
    public function destroy($id)
    {
        $city = Cities::findOrFail($id);
        $city->delete();

        return response()->json(['message' => 'City deleted successfully'], 200);
    }
    public function destroyWeb($id)
    {
        $city = Cities::findOrFail($id);
        $city->delete();

        return redirect()->back()->with('message', 'Package trip deleted successfully');
    }
}
