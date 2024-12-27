<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PekerjaController;

Route::get('/daftar', [PekerjaController::class, 'daftarIndex'])->name('workersunion.daftarIndex');
Route::post('/daftar/create', [PekerjaController::class, 'store'])->name('workersunion.storePekerja');
Route::post('/checkEmail', [PekerjaController::class, 'checkEmail'])->name('workersunion.checkEmail');
Route::get('/login', [PekerjaController::class, 'loginIndex'])->name('workersunion.loginIndex');