<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // index
    public function getAllCategory(){
        $categories = Category::orderBy("id", "desc")->get();

        return response()->json([
            "status" => 200,
            "message" => "all category",
            "data" => $categories
        ], 200);
    }
}
