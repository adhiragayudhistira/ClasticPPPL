<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropOffController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\PointController;

// Redirect root to login or home
Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
})->name('root');

// Public Routes (Login, Register)
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/missions', [MissionController::class, 'index'])->name('missions');
    
    Route::get('/dropoff', [DropOffController::class, 'index'])->name('dropoff');
    Route::get('/dropoff/create', [DropOffController::class, 'create'])->name('dropoff.create');
    Route::post('/dropoff', [DropOffController::class, 'store'])->name('dropoff.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/pickup', [PickupController::class, 'index'])->name('pickup');
    Route::get('/pickup/create', [PickupController::class, 'create'])->name('pickup.create');
    Route::post('/pickup', [PickupController::class, 'store'])->name('pickup.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/points', [PointController::class, 'index'])->name('points');
});