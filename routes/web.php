<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/peserta', function () {
        return view('peserta.index');
    })->name('peserta.dashboard');
});

Route::middleware(['auth', 'role:penyelenggara'])->group(function () {
    Route::get('/penyelenggara', function () {
        return view('organizer.index');
    })->name('organizer.dashboard');
});
