<?php

namespace App\Http\Controllers;

use App\Models\banner_ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner_ads = banner_ads::all();
        return response()->json($banner_ads, 200);
    }
    public function indexWeb()
    {
        $banner_ads = banner_ads::all();
        return view('pages.Trip.banners', compact('banner_ads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        try {
            $validateData = $request->validate([
                'banner_assets' => 'required|mimes:png,jpg,webp,jpeg|max:2040',
                'description' => 'required|string'
            ]);
    
            if ($request->hasFile('banner_assets')){
                $file = $request->file('banner_assets');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/banner';
                $file->move(public_path($path), $filename);
            } else {
                $filename = null; // Default jika tidak ada file
            }
    
            $bannerAds = banner_ads::create([
                'banner_assets' => $filename,
                'description' => $validateData['description']
            ]);
    
            return response()->json([
               'message' => 'Banner Ads created successfully',
                'data' => $bannerAds
            ], 201);
        }catch (\Illuminate\Validation\ValidationException $e) {
            // Respons untuk validasi input salah
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Respons untuk data yang tidak ditemukan (misal cityID tidak valid)
            return response()->json([
                'message' => 'City not found',
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
            $validateData = $request->validate([
                'banner_assets' => 'required|mimes:png,jpg,webp,jpeg|max:10240',
                'description' => 'required|string'
            ]);
    
            if ($request->hasFile('banner_assets')){
                $file = $request->file('banner_assets');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/img/banner';
                $file->move(public_path($path), $filename);
            } else {
                $filename = null; // Default jika tidak ada file
            }
    
            $bannerAds = banner_ads::create([
                'banner_assets' => $filename,
                'description' => $validateData['description']
            ]);
    
            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/banner');
        }catch (\Illuminate\Validation\ValidationException $e) {
            // Respons untuk validasi input salah
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Respons untuk data yang tidak ditemukan (misal cityID tidak valid)
            return response()->json([
                'message' => 'City not found',
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


    public function update(Request $request, $id)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'banner_assets' => 'nullable|mimes:png,jpg,webp,jpeg|max:10240',
            'description' => 'required|string'
        ]);

        try {
            // Find the package trip, or throw 404 if not found
            $bannerAds = banner_ads::findOrFail($id);

            // Handle file upload if a new banner_assets is provided
            if ($request->hasFile('banner_assets')) {
                $file = $request->file('banner_assets');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/img/banner';

                // Move new image to public directory
                $file->move(public_path($path), $filename);

                // Delete the old banner_assets if it exists
                if ($bannerAds->banner_assets && File::exists(public_path($path) . '/' . $bannerAds->banner_assets)) {
                    File::delete(public_path($path) . '/' . $bannerAds->banner_assets);
                }

                // Update the banner_assets field with the new filename
                $validatedData['banner_assets'] = $filename;
            }

            // Update the package trip with the validated data
            $bannerAds->update($validatedData);

            // Redirect ke halaman trip
            session()->flash('success', 'Data berhasil disimpan!');

            // Redirect ke halaman trip
            return redirect('/banner');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 400); // Bad Request

        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(), // For debugging, can be removed in production
            ], 500); // Internal Server Error
        }
    }

    public function editWeb($id)
    {
        // Find the package trip, or throw 404 if not found
        $bannerAds = banner_ads::findOrFail($id);

        // Load necessary data for the edit view
        return view('pages.Trip.banners.update', compact('bannerAds'));
    }

    public function destroy($id)
    {
        $bannerAds = banner_ads::find($id);

        if (!$bannerAds) {
            return redirect()->back()->with('error', 'Package trip not found'); // Menangani jika tidak ditemukan
        }

        $bannerAds->delete();

        return redirect()->back()->with('message', 'Package trip deleted successfully');
    }
     
}
