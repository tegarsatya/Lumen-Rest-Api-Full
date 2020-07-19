<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $product = Product::all();
        return response()->json($product);

    }

    public function show ($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function create(Request $request)
    {
        $this->validate($request, [

            'nama'          => 'required|string',
            'harga'         => 'required|integer',
            'warna'         => 'required|string',
            'kondisi'       => 'required|in:baru,lama',
            'description'   => 'string'
        ]);

        $data = $request->all();

        $product = Product::create($data);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();

        $product->fill($data);

        $product->save();
        return response()->json($product);
    }

}
