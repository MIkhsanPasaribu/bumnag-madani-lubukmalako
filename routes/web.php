<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\TransparansiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\Admin\TransaksiKasController;
use App\Http\Controllers\Admin\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes - BUMNag Madani Lubuk Malako
|--------------------------------------------------------------------------
*/

// ==========================================================================
// PUBLIC ROUTES
// ==========================================================================

// Beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Profil BUMNag
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// Statistik Keuangan
Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
Route::get('/statistik/{bulan}/{tahun}', [StatistikController::class, 'detail'])->name('statistik.detail');
Route::get('/widget/statistik', [StatistikController::class, 'widget'])->name('statistik.widget');

// Transparansi Keuangan
Route::get('/transparansi', [TransparansiController::class, 'index'])->name('transparansi');
Route::get('/transparansi/download/{bulan}/{tahun}', [TransparansiController::class, 'downloadPdf'])->name('transparansi.download');
Route::get('/transparansi/download-tahunan/{tahun}', [TransparansiController::class, 'downloadPdfTahunan'])->name('transparansi.download.tahunan');
Route::get('/transparansi/download-semua', [TransparansiController::class, 'downloadPdfSemua'])->name('transparansi.download.semua');
Route::get('/transparansi/excel/{bulan}/{tahun}', [TransparansiController::class, 'downloadExcel'])->name('transparansi.excel');
Route::get('/transparansi/excel-tahunan/{tahun}', [TransparansiController::class, 'downloadExcelTahunan'])->name('transparansi.excel.tahunan');
Route::get('/transparansi/excel-semua', [TransparansiController::class, 'downloadExcelSemua'])->name('transparansi.excel.semua');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// ==========================================================================
// AUTHENTICATION ROUTES
// ==========================================================================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Recovery (Security Question Based)
Route::get('/lupa-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'verifyEmail'])->name('password.verify.email');
Route::post('/lupa-password/verifikasi', [ForgotPasswordController::class, 'verifyAnswer'])->name('password.verify.answer');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// ==========================================================================
// ADMIN ROUTES (Protected by auth middleware)
// ==========================================================================

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profil BUMNag (Edit Only)
    Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
    
    // CRUD Berita
    Route::resource('berita', AdminBeritaController::class);
    
    // CRUD Pengumuman
    Route::resource('pengumuman', AdminPengumumanController::class);
    
    // CRUD Transaksi Kas (Buku Kas Harian)
    Route::get('/transaksi-kas/export-pdf', [TransaksiKasController::class, 'exportPdf'])->name('transaksi-kas.export-pdf');
    Route::get('/transaksi-kas/export-excel', [TransaksiKasController::class, 'exportExcel'])->name('transaksi-kas.export-excel');
    Route::get('/transaksi-kas/recalculate', [TransaksiKasController::class, 'recalculateSaldo'])->name('transaksi-kas.recalculate');
    Route::get('/transaksi-kas/activity', [TransaksiKasController::class, 'activity'])->name('transaksi-kas.activity');
    Route::resource('transaksi-kas', TransaksiKasController::class);
    
    // Password Management
    Route::get('/ganti-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
    
    // Security Question Management
    Route::get('/pertanyaan-keamanan', [PasswordController::class, 'editSecurity'])->name('security.edit');
    Route::put('/pertanyaan-keamanan', [PasswordController::class, 'updateSecurity'])->name('security.update');
});
