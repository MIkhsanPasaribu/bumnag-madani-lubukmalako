# BUMNag Madani Lubuk Malako

Website resmi Badan Usaha Milik Nagari Madani Lubuk Malako.

## Overview
Website ini dibangun menggunakan Laravel 11 dengan PHP 8.4. Menampilkan profil organisasi, laporan keuangan, berita, dan pengumuman dengan desain modern Bento-style.

## Fitur Utama

### Public Area (dengan Top Navbar)
- **Beranda**: Dashboard dengan statistik keuangan, berita terbaru, dan pengumuman
- **Profil BUMNag**: Sejarah, visi, misi, struktur organisasi, dan kontak
- **Statistik Laporan Keuangan**: Grafik pendapatan, pengeluaran, dan laba/rugi
- **Transparansi Keuangan**: Daftar laporan keuangan yang dapat diakses publik
- **Berita**: Artikel berita dan informasi kegiatan BUMNag
- **Pengumuman**: Pengumuman penting dari BUMNag

### Admin Panel (dengan Sidebar Navigation)
- **Dashboard**: Statistik dan ringkasan konten
- **Kelola Berita**: CRUD berita dengan upload gambar
- **Kelola Pengumuman**: CRUD pengumuman dengan prioritas dan lampiran
- **Kelola Laporan Keuangan**: CRUD laporan bulanan dengan dokumen PDF
- **Kelola Profil BUMNag**: Edit informasi organisasi

## Arsitektur

### Dual Layout System
- `layouts/public.blade.php`: Layout untuk pengunjung dengan top navbar
- `layouts/admin.blade.php`: Layout untuk admin dengan sidebar navigation

### Breadcrumb Navigation
Semua halaman memiliki breadcrumb navigation untuk navigasi yang lebih baik.

## Struktur Proyek
```
app/
├── Http/Controllers/
│   ├── Auth/LoginController.php      # Authentication
│   ├── Admin/                         # Admin Controllers
│   │   ├── DashboardController.php
│   │   ├── BeritaController.php
│   │   ├── PengumumanController.php
│   │   ├── KeuanganController.php
│   │   └── ProfilController.php
│   └── ...                            # Public Controllers
├── Models/                            # Eloquent Models
config/                                # Konfigurasi Laravel
database/
├── migrations/                        # Database migrations
├── seeders/
│   ├── DatabaseSeeder.php             # Main seeder
│   └── AdminUserSeeder.php            # Admin user seeder
public/
├── images/logo.png                    # Logo BUMNag
├── build/                             # Compiled CSS/JS
resources/
├── css/app.css                        # Tailwind CSS dengan custom theme
├── views/
│   ├── layouts/
│   │   ├── public.blade.php           # Public layout dengan top navbar
│   │   └── admin.blade.php            # Admin layout dengan sidebar
│   ├── auth/login.blade.php           # Login page
│   ├── admin/                         # Admin views
│   └── ...                            # Public views
routes/web.php                         # Route definitions
```

## Color Palette (dari Logo)
- **Olive/Hijau Kekuningan**: #A5A71C (primary)
- **Merah Tua**: #8B1A1A (secondary)
- **Cream**: #FAFAF5 (background)
- **Abu-abu**: #374151 (text)

## Authentication

### Login Admin
- URL: `/login`
- Email: `admin@bumnagmadani.id`
- Password: `admin123`

### Protected Routes
Semua route dengan prefix `/admin` dilindungi oleh middleware `auth`.

## Development
```bash
# Install dependencies
composer install
npm install

# Build assets
npm run build

# Run server
php artisan serve --host=0.0.0.0 --port=5000

# Run migrations
php artisan migrate

# Seed sample data (includes admin user)
php artisan db:seed

# Create only admin user
php artisan db:seed --class=AdminUserSeeder
```

## Deployment ke cPanel
1. Upload semua file ke hosting cPanel
2. Import `database/bumnag_madani.sql` ke MySQL via phpMyAdmin
3. Update `.env` dengan kredensial database MySQL:
   ```
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=nama_database
   DB_USERNAME=username_db
   DB_PASSWORD=password_db
   ```
4. Jalankan `php artisan migrate` (jika menggunakan migrations)
5. Jalankan `php artisan db:seed` untuk data sample dan admin user
6. Set document root ke folder `public/`
7. Pastikan folder `storage` dan `bootstrap/cache` writable

## Database
- Development: SQLite (database/database.sqlite)
- Production: MySQL (gunakan file bumnag_madani.sql)

## Recent Changes
- 2026-01-23: Implementasi Admin Panel
  - Dual layout: public dengan top navbar, admin dengan sidebar
  - Authentication system dengan login/logout
  - CRUD untuk Berita, Pengumuman, Laporan Keuangan, Profil BUMNag
  - Breadcrumb navigation di semua halaman
  - Admin user seeder (admin@bumnagmadani.id / admin123)
  
- 2026-01-23: Initial development
  - Setup Laravel 11 dengan Tailwind CSS
  - Implementasi semua fitur publik
  - Desain Bento-style dengan color palette dari logo
