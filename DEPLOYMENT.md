# 🚀 Deployment Guide - BUMNag Madani Lubuk Malako

## Deployment via SSH + Git Clone (cPanel)

### Prerequisites
- SSH access aktif di cPanel
- Git installed di server
- PHP 8.4 & Composer installed
- Node.js & NPM installed
- MySQL database created

---

## 📝 Step-by-Step Deployment

### 1️⃣ SSH ke Server cPanel

**Via Terminal Windows (PowerShell/CMD):**
```bash
ssh bump2384@yourdomain.com
# atau
ssh bump2384@server-ip-address
```

**Via PuTTY (Windows):**
- Host: `yourdomain.com` atau IP server
- Port: `22`
- Username: `bump2384`
- Password: `m39a6i3S1fp362`

---

### 2️⃣ Persiapan Directory

```bash
# Masuk ke directory public_html atau home directory
cd ~/public_html

# Atau jika ingin deploy di subdomain/folder
cd ~/public_html/subdomain
```

---

### 3️⃣ Clone Repository dari GitHub

```bash
# Clone repository
git clone https://github.com/MIkhsanPasaribu/bumnag-madani-lubukmalako.git

# Masuk ke folder project
cd bumnag-madani-lubukmalako

# Checkout ke branch main (jika belum)
git checkout main
```

---

### 4️⃣ Setup Environment File

```bash
# Copy .env.example ke .env
cp .env.example .env

# Edit .env dengan nano atau vi
nano .env
```

**Edit konfigurasi berikut di .env:**
```env
APP_NAME="BUMNag Madani Lubuk Malako"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=user_database_anda
DB_PASSWORD=password_database_anda
```

**Simpan file:**
- Nano: `CTRL + X`, tekan `Y`, lalu `Enter`
- Vi: Tekan `ESC`, ketik `:wq`, tekan `Enter`

---

### 5️⃣ Buat Database MySQL

**Via cPanel MySQL Wizard:**
1. Login ke cPanel
2. Buka **MySQL Database Wizard**
3. Buat database baru (contoh: `bump2384_bumnag`)
4. Buat user database (contoh: `bump2384_admin`)
5. Set password
6. Berikan semua privileges
7. Catat nama database, username, dan password

**Via Terminal (opsional):**
```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE nama_database_anda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Buat user
CREATE USER 'user_database'@'localhost' IDENTIFIED BY 'password_database';

# Berikan privileges
GRANT ALL PRIVILEGES ON nama_database_anda.* TO 'user_database'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

### 6️⃣ Jalankan Deployment Script

```bash
# Berikan permission execute ke script
chmod +x deploy.sh

# Jalankan deployment script
./deploy.sh
```

**Script akan otomatis:**
- Install Composer dependencies
- Install NPM dependencies
- Build production assets
- Set file permissions
- Generate application key
- Run database migrations
- (Opsional) Seed database dengan data sample
- Create storage symlink
- Optimize Laravel (cache config, routes, views)

---

### 7️⃣ Set Document Root

**Opsi A: Via cPanel Domains Settings**
1. Login ke cPanel
2. Buka **Domains**
3. Klik **Manage** pada domain Anda
4. Set **Document Root** ke: `public_html/bumnag-madani-lubukmalako/public`
5. Save

**Opsi B: Via .htaccess di Root**
Jika tidak bisa ubah document root, buat file `.htaccess` di `public_html/`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ bumnag-madani-lubukmalako/public/$1 [L]
</IfModule>
```

---

### 8️⃣ Verifikasi Deployment

**Cek permission files:**
```bash
ls -la storage/
ls -la bootstrap/cache/
ls -la public/uploads/
```

**Test Laravel:**
```bash
php artisan --version
php artisan config:clear
php artisan cache:clear
```

**Akses website:**
- URL: `https://yourdomain.com`
- Admin Login: `https://yourdomain.com/login`
  - Email: `admin@bumnagmadani.id`
  - Password: `admin123`

---

## 🔄 Update Deployment (Pull Changes)

Ketika ada update code di GitHub:

```bash
# SSH ke server
ssh bump2384@yourdomain.com

# Masuk ke directory project
cd ~/public_html/bumnag-madani-lubukmalako

# Pull latest changes
git pull origin main

# Install dependencies jika ada perubahan
composer install --optimize-autoloader --no-dev

# Rebuild assets jika ada perubahan frontend
npm install
npm run build

# Run migrations jika ada migration baru
php artisan migrate --force

# Clear & optimize cache
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🛠️ Troubleshooting

### Permission Denied Error
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs
chmod -R 775 public/uploads
```

### 500 Internal Server Error
```bash
# Clear all cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Check error logs
tail -f storage/logs/laravel.log
```

### Storage Link Error
```bash
# Remove existing link
rm public/storage

# Create new link
php artisan storage:link
```

### Database Connection Error
- Cek kredensial database di `.env`
- Pastikan database sudah dibuat
- Cek DB_HOST (biasanya `localhost` atau `127.0.0.1`)
- Cek user database punya akses ke database

### Composer/NPM Not Found
```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check Node & NPM
node -v
npm -v
```

Jika tidak ada, hubungi hosting provider untuk install atau gunakan path lengkap:
```bash
/usr/local/bin/composer install
/usr/local/bin/npm install
```

---

## 📞 Support

Jika ada masalah deployment, cek:
1. Storage logs: `storage/logs/laravel.log`
2. Server error logs: `~/public_html/error_log`
3. cPanel Error Logs: cPanel > Metrics > Errors

---

## 🔐 Security Checklist

- [x] `APP_ENV=production`
- [x] `APP_DEBUG=false`
- [x] `.env` tidak ter-commit ke Git
- [x] File permissions correct (755/775)
- [x] Strong database password
- [x] HTTPS enabled
- [x] Ganti password admin default setelah first login

---

**Deployment Version:** 1.0  
**Last Updated:** February 7, 2026  
**Contact:** admin@bumnagmadani.id
