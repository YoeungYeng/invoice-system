<?php

use App\Http\Controllers\client\AccountController;
use App\Http\Controllers\client\CategoryController;
use App\Http\Controllers\client\ProductController;
use Illuminate\Support\Facades\Route;


// login and register
Route::post('/register', [AccountController::class, 'register']);
// login
Route::post('/login', [AccountController::class, 'login']);
Route::middleware(['jwt.auth', 'checkUser'])->group(function () {
    Route::get('/getcategory', [CategoryController::class, "getAllCategory"]);
    Route::get("/getallproduct", [ProductController::class, "getAllProduct"]);
});

