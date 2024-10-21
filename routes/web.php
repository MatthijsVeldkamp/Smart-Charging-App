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
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/manage', [ManageController::class, 'index'])->name('manage');
    Route::get('/sockets', [SocketController::class, 'index'])->name('sockets');
    Route::post('/sockets', [SocketController::class, 'store'])->name('sockets.store');
    Route::post('/sockets/{socket}/toggle', [SocketController::class, 'togglePower'])->name('sockets.toggle');
    Route::get('/sockets/{socket}/data', [SocketController::class, 'getData'])->name('sockets.data');
    Route::get('/locations', [LocationController::class, 'index'])->name('locations');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/sockets/{socket}', [SocketController::class, 'show'])->name('sockets.show');
    Route::post('/sockets/{socket}/add-smart-meter', [SocketController::class, 'addSmartMeter'])->name('sockets.addSmartMeter');
});

Route::post('/firebase-login', [FirebaseAuthController::class, 'login'])->name('firebase.login');

require __DIR__.'/auth.php';
