<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query=$request->input('query');
        if($query){
            $categories = Category::where('name', 'LIKE', '%'.$query.'%')->paginate(10);
        }
        return response()->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        // Membuat produk baru
        Category::create($request->all());

        // Mengembalikan respons JSON
        return response()->json(['message' => 'Category berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return response()->json(['category' => $category]);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json(['message' => 'Category berhasil diupdate'], 200);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category berhasil dihapus'], 200);
    }
}
