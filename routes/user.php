<?php

use App\Http\Controllers\client\CategoryController;
use App\Http\Controllers\client\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/getcategory', [CategoryController::class, "getAllCategory"]);
Route::get("/getallproduct", [ProductController::class, "getAllProduct"]);