<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('events.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/peserta', [PesertaController::class, 'dashboard'])->name('peserta.dashboard');
    Route::post('/kegiatan/{slug}/daftar', [EventController::class, 'registerEvent'])->name('events.register');
});

Route::middleware(['auth', 'role:penyelenggara'])->group(function () {
    Route::get('/penyelenggara', function () {
        return view('organizer.index');
    })->name('organizer.dashboard');
});
