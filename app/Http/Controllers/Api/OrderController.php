<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;
        return response()->json(['orders' => $orders], 200);
    }

    public function store(Request $request)
    {
        $order = auth()->user()->orders()->create($request->all());
        return response()->json(['order' => $order], 200);
    }
}
