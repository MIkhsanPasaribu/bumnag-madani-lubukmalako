<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\Admin\KeuanganController as AdminKeuanganController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use Illuminate\Support\Facades\Route;

// Public Routes
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

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Profil BUMNag
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [AdminProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
    
    // Berita CRUD
    Route::resource('berita', AdminBeritaController::class)->except(['show']);
    
    // Pengumuman CRUD
    Route::resource('pengumuman', AdminPengumumanController::class)->except(['show']);
    
    // Keuangan CRUD
    Route::resource('keuangan', AdminKeuanganController::class)->except(['show']);
});
