<?php

use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/**
 * Web Routes
 *
 * Define all application routes for the boarding house platform.
 */

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Category page
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// City page
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

// Boarding house detail
Route::get('/kos/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');

// Boarding house rooms
Route::get('/kos/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kos.rooms');

// Booking routes
Route::get('/kos/booking/{slug}', [BookingController::class, 'booking'])->name('booking');
Route::get('/kos/booking/{slug}/information', [BookingController::class, 'information'])->name('booking.information');
Route::post('/kos/booking/{slug}/information/save', [BookingController::class, 'saveInformation'])->name('booking.information.save');
Route::get('/kos/booking/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('/kos/booking/{slug}/payment', [BookingController::class, 'payment'])->name('booking.payment');

// Booking success page
Route::get('/booking-success', [BookingController::class, 'success'])->name('booking.success');

// Boarding house search
Route::get('/find-kos', [BoardingHouseController::class, 'find'])->name('find-kos');
Route::get('/find-results', [BoardingHouseController::class, 'findResults'])->name('find-kos.results');

// Check booking
Route::get('/check-booking', [BookingController::class, 'check'])->name('check-booking');
Route::post('/check-booking', [BookingController::class, 'show'])->name('check-booking.show');
