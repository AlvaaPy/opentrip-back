<?php

namespace App\Http\Controllers;

use App\Models\countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{


   // Get all countries
   public function index()
   {
       $countries = Countries::all();
       return response()->json($countries, 200);
   }
   public function indexWeb()
   {
       $countries = Countries::all();
       return view('pages.locate.country', compact('countries'));
   }

   // Create new country
   public function store(Request $request)
   {
       $request->validate([
           'country_name' => 'required|string|max:255',
       ]);

       $country = Countries::create([
           'country_name' => $request->country_name
       ]);

       return response()->json(['message' => 'Country created successfully', 'country' => $country], 201);
   }
   public function storeWeb(Request $request)
   {
       $request->validate([
           'country_name' => 'required|string|max:255',
       ]);

       $country = Countries::create([
           'country_name' => $request->country_name
       ]);

       session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Country');
   }

   // Get single country by ID
   public function show($id)
   {
       $country = Countries::findOrFail($id);
       return response()->json($country, 200);
   }

   // Update country by ID
   public function update(Request $request, $id)
   {
       $request->validate([
           'country_name' => 'required|string|max:255',
       ]);

       $country = Countries::findOrFail($id);
       $country->update([
           'country_name' => $request->country_name,
       ]);

       return response()->json(['message' => 'Country updated successfully', 'country' => $country], 200);
   }
   public function updateWeb(Request $request, $id)
   {
       $request->validate([
           'country_name' => 'required|string|max:255',
       ]);

       $country = Countries::findOrFail($id);
       $country->update([
           'country_name' => $request->country_name,
       ]);

       session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/Country');
   }
   
   public function editWeb($id){
     $country = Countries::find($id);
     return view('pages.locate.country.update', compact('country'));
   }

   // Delete country by ID
   public function destroyWeb($id)
   {
       $country = Countries::findOrFail($id);
       $country->delete();

       return redirect()->back()->with('message', 'Package trip deleted successfully');
   }
   public function destroy($id)
   {
       $country = Countries::findOrFail($id);
       $country->delete();

       return response()->json(['message' => 'Country deleted successfully'], 200);
   }
}
