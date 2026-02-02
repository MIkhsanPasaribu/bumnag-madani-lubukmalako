# BUMNag Madani Lubuk Malako

Website resmi Badan Usaha Milik Nagari Madani Lubuk Malako.

## Overview

Website ini dibangun menggunakan **Laravel 11** dengan **PHP 8.4** dan database **MySQL**. Menampilkan profil organisasi, laporan keuangan, berita, dan pengumuman dengan desain modern **Bento Grid Style**. Website akan di-deploy ke hosting **cPanel** dengan file database `.sql` yang disiapkan secara manual.

---

## Color Palette (Warna Resmi dari Logo)

| Warna | Hex Code | Penggunaan |
|-------|----------|------------|
| **Cream** | `#fffaed` | Background utama, section highlight |
| **Hijau** | `#86ae5f` | Primary color, tombol CTA, aksen positif |
| **Merah** | `#b71e42` | Secondary color, highlight penting, alert |
| **Putih** | `#ffffff` | Card background, clean sections |
| **Abu-abu Terang** | `#f3f4f6` | Border, divider, subtle backgrounds |
| **Abu-abu** | `#6b7280` | Secondary text, placeholder |
| **Abu-abu Gelap** | `#374151` | Body text |
| **Hitam** | `#111827` | Heading, emphasis text |

### Tailwind CSS Custom Theme
```css
/* resources/css/app.css */
@tailwind base;
@tailwind components;
@tailwind utilities;

:root {
    --color-cream: #fffaed;
    --color-primary: #86ae5f;
    --color-primary-dark: #6b9a45;
    --color-primary-light: #a5c285;
    --color-secondary: #b71e42;
    --color-secondary-dark: #8f1734;
    --color-secondary-light: #d64a6a;
}
```

### Tailwind Config
```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                cream: '#fffaed',
                primary: {
                    DEFAULT: '#86ae5f',
                    dark: '#6b9a45',
                    light: '#a5c285',
                },
                secondary: {
                    DEFAULT: '#b71e42',
                    dark: '#8f1734',
                    light: '#d64a6a',
                }
            }
        }
    }
}
```

---

## Fitur Utama

### 🌐 Public Area (Tanpa Login)

Navigasi menggunakan **Header/Navbar horizontal** yang sticky dan responsif.

| Halaman | Deskripsi |
|---------|-----------|
| **Beranda** | Dashboard publik dengan statistik keuangan ringkas, berita terbaru, dan pengumuman |
| **Profil BUMNag** | Sejarah, visi misi, struktur organisasi, dan kontak |
| **Statistik Laporan Keuangan** | Dashboard visual dengan charts/grafik pendapatan, pengeluaran, dan laba/rugi |
| **Transparansi Keuangan** | Daftar laporan keuangan publik dengan filter periode/tahun |
| **Berita** | Daftar berita dengan pagination dan halaman detail |
| **Pengumuman** | Daftar pengumuman penting dengan prioritas |
| **Login Admin** | Halaman login untuk akses admin panel |

### 🔐 Admin Panel (Setelah Login)

Navigasi menggunakan **Sidebar** yang bisa di-collapse untuk tampilan mobile.

| Fitur | Deskripsi |
|-------|-----------|
| **Dashboard** | Ringkasan statistik: total berita, pengumuman, laporan keuangan |
| **Kelola Profil BUMNag** | Edit sejarah, visi misi, struktur organisasi, kontak |
| **Kelola Laporan Keuangan** | CRUD laporan bulanan dengan upload dokumen PDF |
| **Kelola Berita** | CRUD berita dengan upload gambar featured |
| **Kelola Pengumuman** | CRUD pengumuman dengan prioritas dan lampiran |

---

## Arsitektur & Struktur Proyek

### Dual Layout System
- `layouts/public.blade.php` → Layout untuk pengunjung dengan **top navbar horizontal sticky**
- `layouts/admin.blade.php` → Layout untuk admin dengan **sidebar collapsible**

### Struktur Folder Lengkap
```
bumnag-madani-lubukmalako/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php       # Authentication
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php   # Admin dashboard
│   │   │   │   ├── BeritaController.php      # CRUD berita
│   │   │   │   ├── PengumumanController.php  # CRUD pengumuman
│   │   │   │   ├── KeuanganController.php    # CRUD laporan keuangan
│   │   │   │   └── ProfilController.php      # CRUD profil BUMNag
│   │   │   ├── BerandaController.php         # Halaman beranda
│   │   │   ├── ProfilController.php          # Halaman profil publik
│   │   │   ├── StatistikController.php       # Halaman statistik keuangan
│   │   │   ├── TransparansiController.php    # Halaman transparansi
│   │   │   ├── BeritaController.php          # Halaman berita publik
│   │   │   └── PengumumanController.php      # Halaman pengumuman publik
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php           # Proteksi route admin
│   │   └── Requests/
│   │       ├── BeritaRequest.php             # Validasi berita
│   │       ├── PengumumanRequest.php         # Validasi pengumuman
│   │       └── KeuanganRequest.php           # Validasi laporan keuangan
│   └── Models/
│       ├── User.php                          # Model user/admin
│       ├── Berita.php                        # Model berita
│       ├── Pengumuman.php                    # Model pengumuman
│       ├── LaporanKeuangan.php               # Model laporan keuangan
│       └── ProfilBumnag.php                  # Model profil organisasi
├── config/                                   # Konfigurasi Laravel
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── xxxx_xx_xx_create_berita_table.php
│   │   ├── xxxx_xx_xx_create_pengumuman_table.php
│   │   ├── xxxx_xx_xx_create_laporan_keuangan_table.php
│   │   └── xxxx_xx_xx_create_profil_bumnag_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php                # Main seeder
│   │   ├── AdminUserSeeder.php               # Admin user seeder
│   │   ├── BeritaSeeder.php                  # Sample berita
│   │   ├── PengumumanSeeder.php              # Sample pengumuman
│   │   ├── LaporanKeuanganSeeder.php         # Sample laporan
│   │   └── ProfilBumnagSeeder.php            # Data profil
│   └── bumnag_madani.sql                     # File SQL untuk deployment
├── public/
│   ├── images/
│   │   └── logo.png                          # Logo BUMNag resmi
│   ├── uploads/
│   │   ├── berita/                           # Gambar berita
│   │   ├── pengumuman/                       # Lampiran pengumuman
│   │   └── keuangan/                         # Dokumen PDF laporan
│   └── build/                                # Compiled CSS/JS (Vite)
├── resources/
│   ├── css/
│   │   └── app.css                           # Tailwind CSS dengan custom theme
│   ├── js/
│   │   └── app.js                            # Alpine.js, Chart.js
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php              # Layout publik (top navbar)
│       │   └── admin.blade.php               # Layout admin (sidebar)
│       ├── components/
│       │   ├── navbar.blade.php              # Navbar horizontal sticky
│       │   ├── sidebar.blade.php             # Sidebar admin collapsible
│       │   ├── breadcrumb.blade.php          # Breadcrumb navigation
│       │   ├── card.blade.php                # Bento card component
│       │   ├── chart.blade.php               # Chart component
│       │   ├── pagination.blade.php          # Custom pagination
│       │   ├── alert.blade.php               # Alert/notification
│       │   ├── modal.blade.php               # Modal dialog
│       │   ├── loading.blade.php             # Loading state
│       │   └── empty-state.blade.php         # Empty state
│       ├── auth/
│       │   └── login.blade.php               # Halaman login
│       ├── public/
│       │   ├── beranda.blade.php             # Halaman beranda
│       │   ├── profil.blade.php              # Halaman profil
│       │   ├── statistik.blade.php           # Halaman statistik
│       │   ├── transparansi.blade.php        # Halaman transparansi
│       │   ├── berita/
│       │   │   ├── index.blade.php           # Daftar berita
│       │   │   └── show.blade.php            # Detail berita
│       │   └── pengumuman/
│       │       ├── index.blade.php           # Daftar pengumuman
│       │       └── show.blade.php            # Detail pengumuman
│       └── admin/
│           ├── dashboard.blade.php           # Dashboard admin
│           ├── profil/
│           │   └── edit.blade.php            # Edit profil BUMNag
│           ├── berita/
│           │   ├── index.blade.php           # Daftar berita
│           │   ├── create.blade.php          # Tambah berita
│           │   └── edit.blade.php            # Edit berita
│           ├── pengumuman/
│           │   ├── index.blade.php           # Daftar pengumuman
│           │   ├── create.blade.php          # Tambah pengumuman
│           │   └── edit.blade.php            # Edit pengumuman
│           └── keuangan/
│               ├── index.blade.php           # Daftar laporan
│               ├── create.blade.php          # Tambah laporan
│               └── edit.blade.php            # Edit laporan
├── routes/
│   └── web.php                               # Route definitions
├── .env.example                              # Environment template
├── composer.json                             # PHP dependencies
├── package.json                              # NPM dependencies
├── tailwind.config.js                        # Tailwind configuration
└── vite.config.js                            # Vite configuration
```

---

## Database Schema

### Tabel: `users`
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'super_admin') DEFAULT 'admin',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Tabel: `profil_bumnag`
```sql
CREATE TABLE profil_bumnag (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_bumnag VARCHAR(255) NOT NULL,
    nama_nagari VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    telepon VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    website VARCHAR(255) NULL,
    sejarah TEXT NULL,
    visi TEXT NULL,
    misi TEXT NULL,
    struktur_organisasi JSON NULL,  -- Array of {jabatan, nama, foto}
    logo VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Tabel: `berita`
```sql
CREATE TABLE berita (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    konten TEXT NOT NULL,
    ringkasan TEXT NULL,
    gambar VARCHAR(255) NULL,
    penulis_id BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    tanggal_publikasi TIMESTAMP NULL,
    views INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (penulis_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Tabel: `pengumuman`
```sql
CREATE TABLE pengumuman (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    konten TEXT NOT NULL,
    prioritas ENUM('rendah', 'sedang', 'tinggi') DEFAULT 'sedang',
    lampiran VARCHAR(255) NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_berakhir DATE NULL,
    status ENUM('aktif', 'tidak_aktif') DEFAULT 'aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Tabel: `laporan_keuangan`
```sql
CREATE TABLE laporan_keuangan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    periode_bulan TINYINT UNSIGNED NOT NULL,  -- 1-12
    periode_tahun YEAR NOT NULL,
    pendapatan DECIMAL(15, 2) NOT NULL DEFAULT 0,
    pengeluaran DECIMAL(15, 2) NOT NULL DEFAULT 0,
    laba_rugi DECIMAL(15, 2) AS (pendapatan - pengeluaran) STORED,
    keterangan TEXT NULL,
    dokumen_pdf VARCHAR(255) NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    disetujui_oleh BIGINT UNSIGNED NULL,
    tanggal_persetujuan TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (disetujui_oleh) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_periode (periode_bulan, periode_tahun)
);
```

---

## Route Definitions

### Public Routes
```php
// routes/web.php

// Halaman Publik
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
Route::get('/transparansi', [TransparansiController::class, 'index'])->name('transparansi');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
```

### Admin Routes
```php
// routes/web.php

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Profil BUMNag
    Route::get('/profil', [Admin\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Admin\ProfilController::class, 'update'])->name('profil.update');
    
    // CRUD Berita
    Route::resource('berita', Admin\BeritaController::class);
    
    // CRUD Pengumuman
    Route::resource('pengumuman', Admin\PengumumanController::class);
    
    // CRUD Laporan Keuangan
    Route::resource('keuangan', Admin\KeuanganController::class);
});
```

---

## UI Components & Design Guidelines

### 🎨 Design Principles
1. **Bento Grid Style** - Layout berbasis card dengan grid modern
2. **Professional & Trustworthy** - Mencerminkan institusi pemerintahan nagari
3. **Clean & Minimal** - Tidak berlebihan, fokus pada konten

### 📱 Responsive Breakpoints
| Device | Width | Keterangan |
|--------|-------|------------|
| Mobile | < 768px | Single column, hamburger menu |
| Tablet | 768px - 1024px | 2 columns, condensed layout |
| Desktop | > 1024px | Full layout, multi-column grid |

### 🧩 UI Components Wajib

#### Navbar (Public)
- Sticky/fixed di atas
- Logo di kiri, menu di tengah/kanan
- Hamburger menu untuk mobile
- Background cream dengan shadow subtle
- Active state dengan warna primary

#### Sidebar (Admin)
- Collapsible untuk mobile (toggle button)
- Logo di atas
- Menu items dengan icon
- Active state dengan background primary
- Footer dengan info user dan logout

#### Breadcrumb
- Tampil di semua halaman (kecuali beranda)
- Format: Beranda > Halaman > Sub-halaman
- Link aktif dengan warna primary

#### Cards (Bento Style)
- Rounded corners (rounded-xl)
- Shadow subtle (shadow-md)
- Hover effect (scale, shadow increase)
- Padding konsisten (p-6)
- Background putih

#### Buttons
```html
<!-- Primary Button (Hijau) -->
<button class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg transition">
    Simpan
</button>

<!-- Secondary Button (Merah) -->
<button class="bg-secondary hover:bg-secondary-dark text-white px-4 py-2 rounded-lg transition">
    Hapus
</button>

<!-- Outline Button -->
<button class="border border-primary text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-lg transition">
    Batal
</button>
```

#### States
- **Loading State**: Spinner dengan overlay
- **Empty State**: Ilustrasi/icon dengan pesan dan CTA
- **Error State**: Alert merah dengan icon warning
- **Success State**: Alert hijau dengan icon check

#### Form Validation
- Real-time validation feedback
- Error message di bawah input
- Border merah untuk input error
- Icon check hijau untuk valid

---

## Authentication

### Login Admin
| Field | Value |
|-------|-------|
| URL | `/login` |
| Email | `admin@bumnagmadani.id` |
| Password | `admin123` |

### Protected Routes
- Semua route dengan prefix `/admin` dilindungi oleh middleware `auth`
- Redirect ke `/login` jika belum login
- Redirect ke `/admin` setelah login berhasil

---

## Deployment ke cPanel

### Persiapan File
1. Export database lengkap ke `database/bumnag_madani.sql`
2. Pastikan semua asset ter-compile (`npm run build`)
3. Hapus folder `node_modules` dan `.git` sebelum upload

### Langkah Deployment
1. Upload semua file ke hosting cPanel (ke dalam folder utama atau subfolder)
2. Buat database MySQL baru via cPanel
3. Import `database/bumnag_madani.sql` ke MySQL via phpMyAdmin
4. Copy `.env.example` ke `.env` dan update konfigurasi:
   ```env
   APP_NAME="BUMNag Madani Lubuk Malako"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
   ```
5. Set document root ke folder `public/`
6. Pastikan folder berikut writable (chmod 775):
   - `storage/`
   - `bootstrap/cache/`
   - `public/uploads/`
7. Generate application key: `php artisan key:generate`
8. Buat symbolic link storage: `php artisan storage:link`

### File .htaccess (jika diperlukan)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## Development Guidelines

### Code Quality Standards
1. **Bahasa**: Gunakan Bahasa Indonesia untuk konten dan komentar code
2. **Laravel Best Practices**: Ikuti konvensi Laravel (PSR-4, naming, dll)
3. **Naming Convention**:
   - Controller: PascalCase (contoh: `BeritaController`)
   - Model: PascalCase singular (contoh: `Berita`)
   - Migration: snake_case (contoh: `create_berita_table`)
   - View: kebab-case (contoh: `berita-detail.blade.php`)
   - Route: kebab-case (contoh: `laporan-keuangan`)
4. **Eloquent ORM**: Gunakan relasi yang benar (hasMany, belongsTo, dll)
5. **Form Validation**: Gunakan Form Request classes
6. **No Duplicate Code**: DRY principle, gunakan components dan partials

### Dependencies
```json
// composer.json
{
    "require": {
        "php": "^8.4",
        "laravel/framework": "^11.0",
        "intervention/image": "^3.0"
    }
}

// package.json
{
    "devDependencies": {
        "tailwindcss": "^3.4",
        "alpinejs": "^3.14",
        "chart.js": "^4.4",
        "@tailwindcss/forms": "^0.5",
        "vite": "^5.0",
        "laravel-vite-plugin": "^1.0"
    }
}
```

---

## Todo List Pengembangan

### Tahap 1: Setup Project & Database
- [ ] Inisialisasi Laravel 11 project
- [ ] Setup Tailwind CSS dengan custom theme
- [ ] Konfigurasi database MySQL
- [ ] Buat semua migrations
- [ ] Buat semua models dengan relasi
- [ ] Buat seeders dengan data sample

### Tahap 2: Public Pages
- [ ] Implementasi layout public dengan navbar
- [ ] Halaman Beranda dengan statistik
- [ ] Halaman Profil BUMNag
- [ ] Halaman Statistik dengan charts
- [ ] Halaman Transparansi Keuangan
- [ ] Halaman Berita (index & detail)
- [ ] Halaman Pengumuman (index & detail)

### Tahap 3: Authentication System
- [ ] Halaman Login
- [ ] Login/Logout functionality
- [ ] Middleware proteksi admin routes
- [ ] Remember me functionality

### Tahap 4: Admin Panel
- [ ] Implementasi layout admin dengan sidebar
- [ ] Dashboard dengan statistik
- [ ] CRUD Profil BUMNag
- [ ] CRUD Laporan Keuangan
- [ ] CRUD Berita dengan upload gambar
- [ ] CRUD Pengumuman dengan lampiran

### Tahap 5: Responsive Design & UI Polish
- [ ] Test responsive di semua breakpoint
- [ ] Perbaiki layout yang pecah
- [ ] Implementasi hover states & transitions
- [ ] Implementasi loading states
- [ ] Implementasi empty states
- [ ] Implementasi form validation feedback

### Tahap 6: Testing & Finalisasi
- [ ] Test semua fitur CRUD
- [ ] Test authentication flow
- [ ] Test responsive design
- [ ] Generate file bumnag_madani.sql
- [ ] Dokumentasi deployment
- [ ] Code cleanup & optimization

---

## Recent Changes

### 2026-01-31: Update Copilot Instructions
- Perbarui color palette sesuai logo (cream, hijau, merah)
- Tambah detail database schema lengkap
- Tambah route definitions
- Tambah UI components guidelines
- Tambah todo list pengembangan
- Tambah deployment instructions yang lebih detail

### 2026-01-23: Initial Development
- Setup Laravel 11 dengan Tailwind CSS
- Implementasi dual layout (public navbar, admin sidebar)
- Authentication system dengan login/logout
- CRUD untuk Berita, Pengumuman, Laporan Keuangan, Profil BUMNag
- Breadcrumb navigation di semua halaman
- Admin user seeder (admin@bumnagmadani.id / admin123)
