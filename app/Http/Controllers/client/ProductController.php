<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $products = Product::orderBy("id", "desc")->get();
        return response()->json([
            "status" => 200,
            "message" => "get all product",
            "data" => $products
        ], 200);
    }
}
