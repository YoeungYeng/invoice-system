<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            "status" => 200,
            "message" => "get all products",
            "data" => $products
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile("image")) {
            $data["image"] = $request->uploadImage($request->file("image"));
        }

        $product = Product::create($data);
        return response()->json([
            "status" => 201,
            "messsage" => "products created",
            "data" => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        // find product to updated
        $product = Product::find($id);
        // check if product not found
        if (!$product) {
            return response()->json([
                "status" => 404,
                "message" => "Product not found"
            ], 404);
        }

        // check validation
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // delete old image first if you store images in filesystem
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Assuming uploadImage() returns a path or filename
            $validated['image'] = $request->uploadImage($request->file('image'));
        }

        // update product in this
        $product->update($validated);

        return response()->json([
            "status" => 201,
            "message" => "product is updated",
            "data" => $product
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                "status" => 404,
                "message" => "Product not found"
            ], 404);
        }

        $product->delete();
        return response()->json([
            "status" => 201,
            "message" => "Product is deleted"
        ], 201);
    }
}
