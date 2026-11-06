<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
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
    Route::get('/kegiatan/{slug}/daftar', [EventController::class, 'showRegistrationForm'])->name('events.register.form');
    Route::post('/kegiatan/{slug}/daftar', [EventController::class, 'registerEvent'])->name('events.register');
});

Route::middleware(['auth', 'role:penyelenggara'])->group(function () {
    Route::get('/penyelenggara', [OrganizerController::class, 'index'])->name('organizer.dashboard');
    Route::post('/penyelenggara/registrasi/{registration}/upload-sertifikat', [OrganizerController::class, 'uploadSingle'])->name('organizer.certificate.single');
    Route::post('/penyelenggara/upload-sertifikat-massal', [OrganizerController::class, 'uploadBatch'])->name('organizer.certificate.batch');
    Route::post('/penyelenggara/registrasi/{registration}/presensi', [OrganizerController::class, 'toggleAttendance'])->name('organizer.attendance.toggle');
    Route::delete('/penyelenggara/registrasi/{registration}/sertifikat', [OrganizerController::class, 'deleteCertificate'])->name('organizer.certificate.delete');
});
