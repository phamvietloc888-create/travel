<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\HistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('destinations', DestinationController::class);
        Route::delete('tours/{tour}/images/{image}', [TourController::class, 'destroyImage'])->name('tours.images.destroy');
        Route::resource('tours', TourController::class);
        Route::resource('bookings', BookingController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

        Route::resource('promotions', PromotionController::class);
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
        Route::get('chats/{thread}', [ChatController::class, 'show'])->name('chats.show');
        Route::post('chats/{thread}/reply', [ChatController::class, 'reply'])->name('chats.reply');

        Route::get('histories', [HistoryController::class, 'index'])->name('histories.index');

        Route::get('media', [PaymentSettingsController::class, 'index'])->name('media.index');
        Route::post('media', [PaymentSettingsController::class, 'update'])->name('media.update');
    });
