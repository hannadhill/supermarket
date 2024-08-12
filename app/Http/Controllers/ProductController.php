<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();
        // $products = Product::paginate(10);
        // $products = Product::paginate(15,['name', 'price'], 'products');

        $query=$request->input('query');
        $itemPerPage=10;
        $page=$request->input('limit', 5);
        $order=$request->input('order');
        $sort=$request->input('sort');
        if($query){
            $products=Product::where($order, 'name', 'like', '%'.$query.'%')->orderBy($order, $sort)->paginate($itemPerPage);
        } else {
            $products=Product::orderBy($order,$sort)->paginate($itemPerPage);
        }
        return response()->json(['products' => $products]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|integer',
        // ]);

        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => "required|exists:categories,id",
            'brand_id' => "required|exists:brands,id",
        ]);

        // Membuat produk baru
        Product::create($request->all());

        // Mengembalikan respons JSON
        return response()->json(['message' => 'Produk berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        // if ($product) {
            return response()->json(['product' => $product]);
        // } else {
            // return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        // }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => "required|exists:categories,id",
            'brand_id' => "required|exists:brands,id",
        ]);
        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return response()->json(['message' => 'Produk berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
    
}
