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

   // Delete country by ID
   public function destroy($id)
   {
       $country = Countries::findOrFail($id);
       $country->delete();

       return response()->json(['message' => 'Country deleted successfully'], 200);
   }
}
