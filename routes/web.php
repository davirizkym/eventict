<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/kegiatan', [EventController::class, 'catalog'])->name('events.index_public');
Route::redirect('/jadwal', '/kegiatan');
Route::get('/tentang', [EventController::class, 'about'])->name('about');
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
    Route::get('/penyelenggara', [OrganizerController::class, 'hub'])->name('organizer.dashboard');
    Route::post('/penyelenggara/event/create', [OrganizerController::class, 'storeEvent'])->name('organizer.event.store');

    Route::get('/penyelenggara/narasumber', [OrganizerController::class, 'speakersIndex'])->name('organizer.speakers.index');
    Route::post('/penyelenggara/narasumber', [OrganizerController::class, 'speakersStore'])->name('organizer.speakers.store');
    Route::get('/penyelenggara/narasumber/{speaker}', [OrganizerController::class, 'speakersShow'])->name('organizer.speakers.show');
    Route::put('/penyelenggara/narasumber/{speaker}', [OrganizerController::class, 'speakersUpdate'])->name('organizer.speakers.update');
    Route::delete('/penyelenggara/narasumber/{speaker}', [OrganizerController::class, 'speakersDestroy'])->name('organizer.speakers.destroy');
    Route::post('/penyelenggara/narasumber/{speaker}/penempatan', [OrganizerController::class, 'speakersAssignEvents'])->name('organizer.speakers.assign_events');

    Route::get('/penyelenggara/kategori', [OrganizerController::class, 'categoriesIndex'])->name('organizer.categories.index');
    Route::post('/penyelenggara/kategori', [OrganizerController::class, 'categoriesStore'])->name('organizer.categories.store');
    Route::put('/penyelenggara/kategori/{category}', [OrganizerController::class, 'categoriesUpdate'])->name('organizer.categories.update');
    Route::delete('/penyelenggara/kategori/{category}', [OrganizerController::class, 'categoriesDestroy'])->name('organizer.categories.destroy');

    Route::get('/penyelenggara/event/{event}', [OrganizerController::class, 'workspace'])->name('organizer.workspace');
    Route::put('/penyelenggara/event/{event}', [OrganizerController::class, 'updateEvent'])->name('organizer.event.update');
    Route::post('/penyelenggara/event/{event}/narasumber', [OrganizerController::class, 'assignSpeaker'])->name('organizer.event.speaker.assign');
    Route::delete('/penyelenggara/event/{event}/narasumber/{speaker}', [OrganizerController::class, 'removeSpeaker'])->name('organizer.event.speaker.remove');
    Route::post('/penyelenggara/event/{event}/quick-checkin', [OrganizerController::class, 'quickCheckinWorkspace'])->name('organizer.workspace.quick_checkin');
    Route::get('/penyelenggara/event/{event}/ekspor-peserta', [OrganizerController::class, 'exportEventPeserta'])->name('organizer.workspace.export');
    Route::post('/penyelenggara/event/{event}/upload-sertifikat-massal', [OrganizerController::class, 'uploadBatchWorkspace'])->name('organizer.workspace.certificate.batch');

    Route::get('/penyelenggara/riwayat', [OrganizerController::class, 'history'])->name('organizer.history');
    Route::get('/penyelenggara/ekspor-peserta', [OrganizerController::class, 'export'])->name('organizer.export');
    Route::post('/penyelenggara/quick-checkin', [OrganizerController::class, 'quickCheckin'])->name('organizer.quick_checkin');
    Route::post('/penyelenggara/registrasi/{registration}/upload-sertifikat', [OrganizerController::class, 'uploadSingle'])->name('organizer.certificate.single');
    Route::post('/penyelenggara/upload-sertifikat-massal', [OrganizerController::class, 'uploadBatch'])->name('organizer.certificate.batch');
    Route::post('/penyelenggara/registrasi/{registration}/presensi', [OrganizerController::class, 'toggleAttendance'])->name('organizer.attendance.toggle');
    Route::delete('/penyelenggara/registrasi/{registration}/sertifikat', [OrganizerController::class, 'deleteCertificate'])->name('organizer.certificate.delete');
});
