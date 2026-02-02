# BUMNag Madani Lubuk Malako

<p align="center">
  <img src="public/images/logo.png" width="200" alt="Logo BUMNag Madani">
</p>

Website resmi **Badan Usaha Milik Nagari Madani Lubuk Malako** - Menampilkan profil organisasi, laporan keuangan, berita, dan pengumuman dengan desain modern Bento Grid Style.

## 🛠️ Tech Stack

| Teknologi    | Versi   |
| ------------ | ------- |
| PHP          | ^8.4    |
| Laravel      | ^11.0   |
| MySQL        | 8.0+    |
| Tailwind CSS | ^3.4    |
| Alpine.js    | ^3.14   |
| Chart.js     | ^4.4    |
| Summernote   | ^0.8.20 |

## 🎨 Color Palette

| Warna             | Hex Code  | Penggunaan                |
| ----------------- | --------- | ------------------------- |
| Cream             | `#fffaed` | Background utama          |
| Hijau (Primary)   | `#86ae5f` | Tombol CTA, aksen positif |
| Merah (Secondary) | `#b71e42` | Highlight penting, alert  |

## ✨ Fitur

### 🌐 Public Area (Tanpa Login)

- **Beranda** - Dashboard publik dengan statistik keuangan, berita terbaru, pengumuman
- **Profil BUMNag** - Sejarah, visi misi, struktur organisasi
- **Statistik Keuangan** - Dashboard visual dengan charts pendapatan & pengeluaran
- **Transparansi Keuangan** - Laporan keuangan publik dengan filter periode
- **Berita** - Daftar berita dengan kategori, galeri, dan fitur terkait
- **Pengumuman** - Pengumuman penting dengan prioritas dan lampiran

### 🔐 Admin Panel

- **Dashboard** - Ringkasan statistik dan aktivitas terbaru
- **Kelola Profil** - Edit informasi BUMNag
- **Kelola Laporan Keuangan** - CRUD transaksi kas dengan kategori
- **Kelola Berita** - CRUD dengan rich editor, kategori, galeri, SEO
- **Kelola Pengumuman** - CRUD dengan prioritas dan scheduled publishing
- **Ekspor Data** - Excel export untuk laporan keuangan

## 🚀 Instalasi

### Persyaratan

- PHP >= 8.4
- Composer
- Node.js >= 18
- MySQL 8.0+

### Langkah Instalasi

```bash
# Clone repository
git clone https://github.com/username/bumnag-madani-lubukmalako.git
cd bumnag-madani-lubukmalako

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Konfigurasi database di .env
# DB_DATABASE=bumnag_madani
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat symbolic link untuk storage
php artisan storage:link

# Build assets
npm run build

# Jalankan server development
php artisan serve
```

### Akses Admin

| Field    | Value                   |
| -------- | ----------------------- |
| URL      | `/login`                |
| Email    | `admin@bumnagmadani.id` |
| Password | `admin123`              |

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/     # Controller untuk public & admin
│   ├── Models/               # Eloquent models
│   └── Exports/              # Excel export classes
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Data seeders
├── public/
│   ├── images/               # Logo dan asset statis
│   └── uploads/              # File upload (berita, dokumen)
├── resources/
│   ├── css/                  # Tailwind CSS
│   ├── js/                   # Alpine.js
│   └── views/
│       ├── layouts/          # Layout public & admin
│       ├── components/       # Blade components
│       ├── public/           # Halaman publik
│       └── admin/            # Halaman admin
└── routes/
    └── web.php               # Route definitions
```

## 🗄️ Database Schema

### Tabel Utama

- `users` - Admin users
- `profil_bumnag` - Profil organisasi
- `berita` - Berita dengan kategori, galeri, SEO
- `pengumuman` - Pengumuman dengan prioritas
- `transaksi_kas` - Transaksi keuangan
- `kategori_transaksi` - Kategori transaksi

## 📦 Deployment ke cPanel

1. Upload semua file ke hosting (kecuali `node_modules`, `.git`)
2. Buat database MySQL via cPanel
3. Import database atau jalankan migration
4. Update `.env` dengan kredensial production
5. Set document root ke folder `public/`
6. Pastikan folder `storage/` dan `bootstrap/cache/` writable (chmod 775)
7. Jalankan `php artisan storage:link`

### File .htaccess (jika diperlukan)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

## 🔧 Development

```bash
# Development dengan hot reload
npm run dev

# Build untuk production
npm run build

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 Changelog

### v1.0.0 (Februari 2026)

- Initial release
- Public pages: Beranda, Profil, Statistik, Transparansi, Berita, Pengumuman
- Admin panel dengan CRUD lengkap
- Sistem autentikasi
- Rich text editor (Summernote)
- Kategori berita dengan filter
- Galeri gambar untuk berita
- Scheduled publishing
- SEO meta tags
- Export laporan keuangan ke Excel

## 📄 License

Proyek ini dikembangkan untuk **BUMNag Madani Lubuk Malako**.

---

<p align="center">
  Dibangun dengan ❤️ menggunakan <a href="https://laravel.com">Laravel</a> & <a href="https://tailwindcss.com">Tailwind CSS</a>
</p>
