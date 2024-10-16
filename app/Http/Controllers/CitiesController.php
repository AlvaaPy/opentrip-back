<?php

namespace App\Http\Controllers;

use App\Models\cities;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    // Get all cities
    public function index()
    {
        $cities = Cities::with('province')->get();
        return response()->json($cities, 200);
    }

    // Create new city
    public function store(Request $request)
    {
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        $city = Cities::create([
            'provinceID' => $request->provinceID,
            'city_name' => $request->city_name,
        ]);

        return response()->json(['message' => 'City created successfully', 'city' => $city], 201);
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
        $request->validate([
            'provinceID' => 'required|exists:provinces,provinceID',
            'city_name' => 'required|string|max:255',
        ]);

        $city = Cities::findOrFail($id);
        $city->update([
            'provinceID' => $request->provinceID,
            'city_name' => $request->city_name,
        ]);

        return response()->json(['message' => 'City updated successfully', 'city' => $city], 200);
    }

    // Delete city by ID
    public function destroy($id)
    {
        $city = Cities::findOrFail($id);
        $city->delete();

        return response()->json(['message' => 'City deleted successfully'], 200);
    }
}
