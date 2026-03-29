<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Clients\AboutController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\BlogController;
use App\Http\Controllers\Clients\CheckoutController;
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\DestinationController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\ProfileController;
use App\Http\Controllers\Clients\ReviewController;
use App\Http\Controllers\Clients\TourController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', fn () => redirect()->route('home'))->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/payment-settings/qr', [CheckoutController::class, 'paymentQr'])->name('payment.qr');

Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/destination/{slug}', [TourController::class, 'byDestination'])->name('tours.byDestination');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

Route::get('/login', fn () => redirect()->route('home', ['auth' => 'login']))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', fn () => redirect()->route('home', ['auth' => 'register']))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/forgot-password', fn () => redirect()->route('home', ['auth' => 'forgot']))->name('password.request');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/checkout/{tour}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/booking/{booking}/confirmation', [CheckoutController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/booking/{booking}/payment', [CheckoutController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking}/payment', [CheckoutController::class, 'submitPayment'])->name('booking.payment.submit');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('/profile/bookings', [ProfileController::class, 'bookings'])->name('profile.bookings');
    Route::get('/profile/bookings/{booking}/notification', [ProfileController::class, 'openNotification'])->name('profile.bookings.notification');
    Route::post('/profile/bookings/{booking}/cancel', [ProfileController::class, 'cancelBooking'])->name('profile.bookings.cancel');
    Route::delete('/profile/bookings/{booking}', [ProfileController::class, 'deleteBooking'])->name('profile.bookings.delete');
    Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::post('/reset-password', [ResetPasswordController::class, 'resetDirect'])->name('password.direct');

require __DIR__.'/admin.php';
