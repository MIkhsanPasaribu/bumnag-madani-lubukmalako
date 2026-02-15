<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\TransparansiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\LaporanTahunanController;
use App\Http\Controllers\GaleriBumnagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\LaporanTahunanController as AdminLaporanTahunanController;
use App\Http\Controllers\Admin\KategoriBeritaController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\GaleriBumnagController as AdminGaleriBumnagController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\KontakInfoController;
use App\Http\Controllers\Admin\PesanKontakController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Unit\DashboardController as UnitDashboardController;
use App\Http\Controllers\Unit\LaporanKeuanganController as UnitLaporanKeuanganController;
use App\Http\Controllers\SubUnit\DashboardController as SubUnitDashboardController;
use App\Http\Controllers\SubUnit\LaporanKeuanganController as SubUnitLaporanKeuanganController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TimPengembangController;
use App\Http\Controllers\HubungiKamiController;

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
Route::get('/transparansi/download-unit/{tahun}/{unit}', [TransparansiController::class, 'downloadPdfUnit'])->name('transparansi.download.unit');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/kategori/{slug}', [BeritaController::class, 'byKategori'])->name('berita.kategori');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Laporan Tahunan
Route::get('/laporan-tahunan', [LaporanTahunanController::class, 'index'])->name('laporan-tahunan.index');
Route::get('/laporan-tahunan/{slug}', [LaporanTahunanController::class, 'show'])->name('laporan-tahunan.show');
Route::get('/laporan-tahunan/{slug}/download', [LaporanTahunanController::class, 'download'])->name('laporan-tahunan.download');

// Galeri BUMNag
Route::get('/galeri-bumnag', [GaleriBumnagController::class, 'index'])->name('galeri-bumnag.index');

// Hubungi Kami
Route::get('/hubungi-kami', [HubungiKamiController::class, 'index'])->name('hubungi-kami');
Route::post('/hubungi-kami', [HubungiKamiController::class, 'store'])->name('hubungi-kami.store');

// Tim Pengembang
Route::get('/tim-pengembang', [TimPengembangController::class, 'index'])->name('tim-pengembang');

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

Route::prefix('admin')->middleware(['auth', 'role.admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Upload Image for Rich Editor
    Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');
    
    // Profil BUMNag (Edit Only)
    Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
    
    // CRUD Kategori Berita
    Route::post('/kategori-berita/{kategori_berita}/toggle-status', [KategoriBeritaController::class, 'toggleStatus'])
        ->name('kategori-berita.toggle-status');
    Route::post('/kategori-berita/update-order', [KategoriBeritaController::class, 'updateOrder'])
        ->name('kategori-berita.update-order');
    Route::resource('kategori-berita', KategoriBeritaController::class)->parameters([
        'kategori-berita' => 'kategori_berita'
    ]);
    
    // CRUD Berita - dengan explicit parameter naming
    Route::post('/berita/{berita}/toggle-featured', [AdminBeritaController::class, 'toggleFeatured'])
        ->name('berita.toggle-featured');
    Route::post('/berita/{berita}/toggle-pinned', [AdminBeritaController::class, 'togglePinned'])
        ->name('berita.toggle-pinned');
    Route::post('/berita/{id}/restore', [AdminBeritaController::class, 'restore'])
        ->name('berita.restore');
    Route::delete('/berita/{id}/force-delete', [AdminBeritaController::class, 'forceDestroy'])
        ->name('berita.force-delete');
    Route::resource('berita', AdminBeritaController::class)->parameters([
        'berita' => 'berita'
    ]);
    
    // CRUD Laporan Tahunan
    Route::post('/laporan-tahunan/{id}/restore', [AdminLaporanTahunanController::class, 'restore'])
        ->name('laporan-tahunan.restore');
    Route::delete('/laporan-tahunan/{id}/force-delete', [AdminLaporanTahunanController::class, 'forceDestroy'])
        ->name('laporan-tahunan.force-delete');
    Route::resource('laporan-tahunan', AdminLaporanTahunanController::class)->parameters([
        'laporan-tahunan' => 'laporan_tahunan'
    ]);
    
    // CRUD Laporan Keuangan (per unit/sub-unit, bulanan)
    Route::get('/laporan-keuangan/export-pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('laporan-keuangan.export-pdf');
    Route::get('/laporan-keuangan/activity', [LaporanKeuanganController::class, 'activity'])->name('laporan-keuangan.activity');
    Route::get('/laporan-keuangan/sub-units/{unit}', [LaporanKeuanganController::class, 'getSubUnits'])->name('laporan-keuangan.sub-units');
    Route::resource('laporan-keuangan', LaporanKeuanganController::class);
    
    // CRUD Hero Slides
    Route::post('/hero-slide/update-order', [HeroSlideController::class, 'updateOrder'])
        ->name('hero-slide.update-order');
    Route::post('/hero-slide/{hero_slide}/toggle-status', [HeroSlideController::class, 'toggleStatus'])
        ->name('hero-slide.toggle-status');
    Route::resource('hero-slide', HeroSlideController::class)->parameters([
        'hero-slide' => 'hero_slide'
    ]);
    
    // CRUD Galeri BUMNag
    Route::post('/galeri-bumnag/update-order', [AdminGaleriBumnagController::class, 'updateOrder'])
        ->name('galeri-bumnag.update-order');
    Route::post('/galeri-bumnag/{galeri_bumnag}/toggle-status', [AdminGaleriBumnagController::class, 'toggleStatus'])
        ->name('galeri-bumnag.toggle-status');
    Route::resource('galeri-bumnag', AdminGaleriBumnagController::class)->parameters([
        'galeri-bumnag' => 'galeri_bumnag'
    ]);
    
    // Informasi Kontak (Edit Only)
    Route::get('/kontak-info', [KontakInfoController::class, 'edit'])->name('kontak-info.edit');
    Route::put('/kontak-info', [KontakInfoController::class, 'update'])->name('kontak-info.update');
    
    // Pesan Kontak (dari form Hubungi Kami)
    Route::get('/pesan-kontak', [PesanKontakController::class, 'index'])->name('pesan-kontak.index');
    Route::get('/pesan-kontak/{pesan_kontak}', [PesanKontakController::class, 'show'])->name('pesan-kontak.show');
    Route::delete('/pesan-kontak/{pesan_kontak}', [PesanKontakController::class, 'destroy'])->name('pesan-kontak.destroy');
    Route::post('/pesan-kontak/{pesan_kontak}/tandai-dibaca', [PesanKontakController::class, 'tandaiDibaca'])->name('pesan-kontak.tandai-dibaca');
    Route::post('/pesan-kontak/tandai-semua-dibaca', [PesanKontakController::class, 'tandaiSemuaDibaca'])->name('pesan-kontak.tandai-semua-dibaca');
    
    // Kelola Akun Unit & Sub Unit
    Route::get('/users/sub-units/{unit}', [AdminUserController::class, 'getSubUnits'])->name('users.sub-units');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('users', AdminUserController::class)->parameters(['users' => 'user']);
    
    // Password Management
    Route::get('/ganti-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
    
    // Security Question Management
    Route::get('/pertanyaan-keamanan', [PasswordController::class, 'editSecurity'])->name('security.edit');
    Route::put('/pertanyaan-keamanan', [PasswordController::class, 'updateSecurity'])->name('security.update');
});

// ==========================================================================
// UNIT USAHA ROUTES (Protected by auth + role.unit middleware)
// ==========================================================================

Route::prefix('unit')->middleware(['auth', 'role.unit'])->name('unit.')->group(function () {
    // Dashboard Unit
    Route::get('/', [UnitDashboardController::class, 'index'])->name('dashboard');

    // Laporan Keuangan Unit
    Route::resource('laporan-keuangan', UnitLaporanKeuanganController::class)
        ->parameters(['laporan-keuangan' => 'laporan_keuangan']);

    // Password Management
    Route::get('/ganti-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
});

// ==========================================================================
// SUB UNIT USAHA ROUTES (Protected by auth + role.subunit middleware)
// ==========================================================================

Route::prefix('sub-unit')->middleware(['auth', 'role.subunit'])->name('subunit.')->group(function () {
    // Dashboard Sub Unit
    Route::get('/', [SubUnitDashboardController::class, 'index'])->name('dashboard');

    // Laporan Keuangan Sub Unit
    Route::resource('laporan-keuangan', SubUnitLaporanKeuanganController::class)
        ->parameters(['laporan-keuangan' => 'laporan_keuangan']);

    // Password Management
    Route::get('/ganti-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
});
