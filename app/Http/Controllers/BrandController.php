<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::all();
        $query=$request->input('query');
        if($query){
            $brands = Brand::where('name', 'LIKE', '%'.$query.'%')->get();
        }
        return response()->json(['brands' => $brands]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        // Membuat brand baru
        Brand::create($request->all());
        // Mengembalikan respons JSON
        return response()->json(['message' => 'Nama brand berhasil ditambahkan'], 201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        return response()->json(['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $brand = Brand::findOrFail($id);
        $brand->update($request->all());
        return response()->json(['message' => 'Nama brand berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand, string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['message' => 'Nama brand berhasil dihapus'], 200);
    }
}
