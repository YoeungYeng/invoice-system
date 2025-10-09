<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::all();

        return response()->json([
            "status" => 200,
            "message" => "all category",
            "data" => $categories
        ], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);

        return response()->json([
            "status" => 201,
            "message" => "category is created",
            "data" => $category
        ], 201);
    }
}
