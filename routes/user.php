<?php

use App\Http\Controllers\client\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/getcategory', [CategoryController::class, "getAllCategory"]);
