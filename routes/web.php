<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\AboutController;
use App\Http\Controllers\Clients\BlogController;
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\destinationController;
use App\Http\Controllers\Clients\HotelController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\TourController;
use App\Http\Controllers\Clients\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/destination', [destinationController::class, 'index'])->name('destination');
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel');

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Trang danh sách destination */
Route::get('/destinations', [DestinationController::class, 'index'])
    ->name('destinations.index');

/* Trang tour theo destination */
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])
    ->name('destinations.show');
    
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours');

// Tour theo destination
Route::get('/tours/destination/{slug}', [TourController::class, 'byDestination'])
    ->name('tours.byDestination');

// Chi tiết tour
Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');
Route::middleware('auth')->group(function () {

    // Trang profile + lịch sử booking
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.user');

    // Cập nhật thông tin cá nhân
    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Đổi mật khẩu
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])
        ->name('profile.password');

});

// Include admin routes
require __DIR__ . '/admin.php';