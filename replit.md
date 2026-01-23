# BUMNag Madani Lubuk Malako

Website resmi Badan Usaha Milik Nagari Madani Lubuk Malako.

## Overview
Website ini dibangun menggunakan Laravel 11 dengan PHP 8.4. Menampilkan profil organisasi, laporan keuangan, berita, dan pengumuman dengan desain modern Bento-style.

## Fitur Utama
- **Beranda**: Dashboard dengan statistik keuangan, berita terbaru, dan pengumuman
- **Profil BUMNag**: Sejarah, visi, misi, struktur organisasi, dan kontak
- **Statistik Laporan Keuangan**: Grafik pendapatan, pengeluaran, dan laba/rugi
- **Transparansi Keuangan**: Daftar laporan keuangan yang dapat diakses publik
- **Berita**: Artikel berita dan informasi kegiatan BUMNag
- **Pengumuman**: Pengumuman penting dari BUMNag

## Struktur Proyek
```
app/
├── Http/Controllers/    # Controllers (Beranda, Profil, Keuangan, Berita, Pengumuman)
├── Models/              # Models (ProfilBumnag, LaporanKeuangan, Berita, Pengumuman)
config/                  # Konfigurasi Laravel
database/
├── migrations/          # Database migrations
├── seeders/             # Data sample
├── bumnag_madani.sql    # SQL export untuk MySQL/cPanel
public/
├── images/logo.png      # Logo BUMNag
├── build/               # Compiled CSS/JS
resources/
├── css/app.css          # Tailwind CSS dengan custom theme BUMNag
├── views/               # Blade templates
routes/web.php           # Route definitions
```

## Color Palette (dari Logo)
- **Olive/Hijau Kekuningan**: #A5A71C (primary)
- **Merah Tua**: #8B1A1A (secondary)
- **Cream**: #F5F3E8 (background)
- **Abu-abu**: #4A4A4A (text)

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

# Seed sample data
php artisan db:seed
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
5. Atau jalankan `php artisan db:seed` untuk data sample
6. Set document root ke folder `public/`

## Database
- Development: SQLite (database/database.sqlite)
- Production: MySQL (gunakan file bumnag_madani.sql)

## Recent Changes
- 2026-01-23: Initial development
  - Setup Laravel 11 dengan Tailwind CSS
  - Implementasi semua fitur: Profil, Keuangan, Berita, Pengumuman
  - Desain Bento-style dengan color palette dari logo
  - Export SQL untuk deployment cPanel
