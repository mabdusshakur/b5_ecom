<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;

Route::resource("/", HomeController::class);
Route::resource("/products", ProductController::class);
Route::resource("/carts", CartController::class);
Route::resource("/dashboards", DashboardController::class);
Route::post('/profile', [DashboardController::class, 'profile'])->name('profile.post');
Route::post('/profile/mail', [DashboardController::class, 'profileMail'])->name('profile.mail.post');
Route::post('/profile/password', [DashboardController::class, 'profilePassword'])->name('profile.password.post');

Route::resource("/wishlists", WishlistController::class);


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/verify', [AuthController::class, 'verifyPage'])->name('verify');

Route::post('/otp/verify', [AuthController::class, 'verify'])->name('verify.otp.post');
Route::post('/otp/resend', [AuthController::class, 'resend'])->name('resend.otp.post');