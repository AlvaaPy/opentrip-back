<?php

namespace App\Http\Controllers;

use App\Models\provinces;
use Illuminate\Http\Request;

class ProvincesController extends Controller
{
    // Get all provinces
    public function index()
    {
        $provinces = Provinces::with('country')->get();
        return response()->json($provinces, 200);
    }
    public function indexWeb()
    {
        $provinces = Provinces::with('country')->get();
        return view('pages.locate.provice', compact('provinces'));
    }

    // Create new province
    public function store(Request $request)
    {
        $request->validate([
            'countryID' => 'required|exists:countries,countryID',
            'province_name' => 'required|string|max:255',
        ]);

        $province = Provinces::create([
            'countryID' => $request->countryID,
            'province_name' => $request->province_name,
        ]);

        return response()->json(['message' => 'Province created successfully', 'province' => $province], 201);
    }
    public function storeWeb(Request $request)
    {
        $request->validate([
            'countryID' => 'required|exists:countries,countryID',
            'province_name' => 'required|string|max:255',
        ]);

        $province = Provinces::create([
            'countryID' => $request->countryID,
            'province_name' => $request->province_name,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');

        // Redirect ke halaman trip
        return redirect('/Province');
    }

    // Get single province by ID
    public function show($id)
    {
        $province = Provinces::with('country')->findOrFail($id);
        return response()->json($province, 200);
    }

    // Update province by ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'countryID' => 'required|exists:countries,countryID',
            'province_name' => 'required|string|max:255',
        ]);

        $province = Provinces::findOrFail($id);
        $province->update([
            'countryID' => $request->countryID,
            'province_name' => $request->province_name,
        ]);

        return response()->json(['message' => 'Province updated successfully', 'province' => $province], 200);
    }
    public function updateWeb(Request $request, $id)
    {
        $request->validate([
            'countryID' => 'required|exists:countries,countryID',
            'province_name' => 'required|string|max:255',
        ]);

        $province = Provinces::findOrFail($id);
        $province->update([
            'countryID' => $request->countryID,
            'province_name' => $request->province_name,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Province');
    }

    public function editWeb($id){
        $province = provinces::find($id);
        return view('pages.locate.province.update', compact('province'));
      }
   

    // Delete province by ID
    public function destroy($id)
    {
        $province = Provinces::findOrFail($id);
        $province->delete();

        return response()->json(['message' => 'Province deleted successfully'], 200);
    }
    public function destroyWeb($id)
    {
        $province = Provinces::findOrFail($id);
        $province->delete();

        return redirect()->back()->with('message', 'Package trip deleted successfully');
    }
}
