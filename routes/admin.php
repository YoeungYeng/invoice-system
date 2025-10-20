<?php

use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/loginadmin', [AuthenticationController::class, 'login']);

Route::middleware(['jwt.auth', 'checkAdmin'])->group(function () {
    Route::apiResource("/category", CategoryController::class);
    Route::apiResource("/product", ProductController::class);
    // update profile admin
    Route::post('/updateprofileadmin', [ProfileController::class, 'updateProfile']);
});
