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
        $validate = $request->validated();
        $category = Category::create($validate);

        return response()->json([
            "status" => 201,
            "message" => "category is created",
            "data" => $category
        ], 201);
    }

    // update category
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 404, // Not Found
                'message' => 'Category Not Found',
            ], 404);
        }

        $validate = $request->validated();
        // update category
        $category->update($validate);

        return response()->json([
            "status" => 201,
            "message" => "category updated",
            "data" => $category
        ]);
    }


    // destoy method
    public function destroy($id)
    {
        $category = Category::find($id);
        // check if category not found
        if (!$category) {
            return response()->json([
                'status' => 404, // Not Found
                'message' => 'Category Not Found',
            ], 404);
        }

        // delete category
        $category->delete();
        return response()->json([
            "status" => 201,
            "message" => "category deleted",
            "data" => $category
        ]);
    }
}
