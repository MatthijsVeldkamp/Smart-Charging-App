<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\SocketController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware('auth')->group(function () {
    // Dashboard & Settings
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Socket Management
    Route::get('/sockets', [ManageController::class, 'index'])->name('sockets');
    Route::post('/sockets/add', [ManageController::class, 'addSocket'])->name('sockets.add');
    Route::post('/sockets/{id}/toggle', [ManageController::class, 'toggleSocket'])->name('sockets.toggle');
    Route::delete('/sockets/{id}', [ManageController::class, 'destroy'])->name('sockets.destroy');
    
    // Locations
    Route::get('/locations', [LocationController::class, 'index'])->name('locations');
    
    // Authentication
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Firebase Authentication
Route::post('/firebase-login', [FirebaseAuthController::class, 'login'])->name('firebase.login');

require __DIR__.'/auth.php';
