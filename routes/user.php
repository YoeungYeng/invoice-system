<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/category', [CategoryController::class, "index"]);
Route::get("/product", [ProductController::class, "index"]);

// 