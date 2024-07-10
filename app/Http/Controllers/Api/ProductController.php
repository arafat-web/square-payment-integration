<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json(['product' => $product], 200);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json(['product' => $product], 200);
    }
}
