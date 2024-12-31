<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PekerjaController;

Route::get('/daftar', [PekerjaController::class, 'daftarIndex'])->name('workersunion.daftarIndex');
Route::post('/daftar/create', [PekerjaController::class, 'store'])->name('workersunion.storePekerja');
Route::post('/checkEmail', [PekerjaController::class, 'checkEmail'])->name('workersunion.checkEmail');
Route::get('/login', [PekerjaController::class, 'loginIndex'])->name('workersunion.loginIndex');
Route::post('/login/verify', [PekerjaController::class, 'logIn'])->name('workersunion.logIn');
Route::get('/home-page',[PekerjaController::class, 'homeIndex'])->name('workersunion.homePage');
Route::get('/profile', [PekerjaController::class, 'profileIndex'])->name('workersunion.profilePage');
Route::post('/addRingkasan', [PekerjaController::class, 'addRingkasan'])->name('workersunion.addRingkasan');
Route::post('/addInformasiPekerjaan', [PekerjaController::class, 'addInformasiPekerjaan'])->name('workersunion.addInformasiPekerjaan');
Route::post('/addInformasiPendidikan', [PekerjaController::class, 'addInformasiPendidikan'])->name('workersunion.addInformasiPendidikan');
Route::post('/addInformasiLisensi', [PekerjaController::class, 'addInformasiLisensi'])->name('workersunion.addInformasiLisensi');
Route::post('/addSkills', [PekerjaController::class, 'addSkills'])->name('workersunion.addSkills');
Route::post('/getSkills', [PekerjaController::class, 'getSkills'])->name('workersunion.getSkills');
Route::post('/deleteSkills',[PekerjaController::class, 'deleteSkills'])->name('workersunion.deleteSkills');
