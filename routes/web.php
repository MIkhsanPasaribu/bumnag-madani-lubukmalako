<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

Route::prefix('keuangan')->name('keuangan.')->group(function () {
    Route::get('/statistik', [KeuanganController::class, 'statistik'])->name('statistik');
    Route::get('/transparansi', [KeuanganController::class, 'transparansi'])->name('transparansi');
});

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{berita}', [BeritaController::class, 'show'])->name('show');
});

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
