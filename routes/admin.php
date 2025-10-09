<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/category", CategoryController::class);
Route::apiResource("/product", ProductController::class);