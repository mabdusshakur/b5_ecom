<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::resource("/", HomeController::class);
Route::resource("/products", ProductController::class);