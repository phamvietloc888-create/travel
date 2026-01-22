<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clients\homeController;
use App\Http\Controllers\clients\aboutController;
use App\Http\Controllers\clients\blogController;
use App\Http\Controllers\clients\contactController;
use App\Http\Controllers\clients\destinationController;
use App\Http\Controllers\clients\hotelController;
use App\Http\Controllers\clients\loginController;

Route::get('/',[homeController::class,'index'])->name('home');
Route::get('/about',[aboutController::class,'index'])->name('about');
Route::get('/blog',[blogController::class,'index'])->name('blog');
Route::get('/contact',[contactController::class,'index'])->name('contact');
Route::get('/destination',[destinationController::class,'index'])->name('destination');
Route::get('/hotel',[hotelController::class,'index'])->name('hotel');
Route::get('/login',[loginController::class,'index'])->name('login');