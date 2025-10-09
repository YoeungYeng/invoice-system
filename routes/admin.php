<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/category", CategoryController::class);
Route::apiResource("/product", ProductController::class);