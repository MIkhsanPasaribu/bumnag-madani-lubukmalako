# 🚀 DEPLOYMENT MINIMAL - Tampilkan Halaman Depan

## Step-by-Step Deployment Sederhana (Tanpa Composer/NPM)

---

## ✅ STEP 1: Clone Repository

```bash
cd ~/public_html
git clone https://github.com/MIkhsanPasaribu/bumnag-madani-lubukmalako.git
cd bumnag-madani-lubukmalako
```

**Verifikasi:**
```bash
ls -la
```
Harus muncul folder: app, public, routes, dll.

---

## ✅ STEP 2: Setup File .env

```bash
cp .env.example .env
nano .env
```

**Edit baris berikut (gunakan panah keyboard untuk navigasi):**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bumnagmadani.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=bump2384_bumnag_madani
DB_USERNAME=bump2384_admin
DB_PASSWORD=Bumnagmadani123.
```

**Simpan:**
- Tekan `CTRL + X`
- Tekan `Y`
- Tekan `Enter`

**Verifikasi .env:**
```bash
cat .env | grep APP_URL
cat .env | grep DB_
```

---

## ✅ STEP 3: Set Permissions (Penting!)

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs
```

**Verifikasi:**
```bash
ls -la storage/
```

---

## ✅ STEP 4: Generate Application Key

```bash
php artisan key:generate --force
```

**Output:** `Application key set successfully.`

**Verifikasi:**
```bash
cat .env | grep APP_KEY
```
Harus terisi (bukan kosong).

---

## ✅ STEP 5: Set Document Root

**Via cPanel GUI:**
1. Buka cPanel
2. Menu **Domains** (atau **Addon Domains**)
3. Klik **Manage** pada `bumnagmadani.com`
4. Ubah **Document Root** ke:
   ```
   public_html/bumnag-madani-lubukmalako/public
   ```
5. **Save/Update**

**ATAU via .htaccess di ~/public_html:**
```bash
cd ~/public_html
nano .htaccess
```

Paste ini:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ bumnag-madani-lubukmalako/public/$1 [L]
</IfModule>
```

Simpan: `CTRL+X`, `Y`, `Enter`

---

## ✅ STEP 6: Test Halaman Depan

Buka browser dan akses:
```
https://bumnagmadani.com
```

**Jika muncul Laravel welcome page atau error 500:**
- ✅ File sudah ter-upload dengan benar
- ✅ Document root sudah benar
- Lanjut ke step berikutnya

---

## 🔧 STEP 7: Install Composer Dependencies (Manual)

Jika composer tidak ada di PATH, cari lokasi composer:

```bash
# Cari composer
which composer
/usr/local/bin/composer --version
/opt/cpanel/composer/bin/composer --version
php ~/composer.phar --version
```

**Jika ketemu, jalankan:**
```bash
cd ~/public_html/bumnag-madani-lubukmalako

# Ganti dengan path composer yang ketemu
/usr/local/bin/composer install --optimize-autoloader --no-dev

# ATAU jika tidak ada, download composer lokal:
curl -sS https://getcomposer.org/installer | php
php composer.phar install --optimize-autoloader --no-dev
```

---

## 🔧 STEP 8: Clear Cache & Test

```bash
cd ~/public_html/bumnag-madani-lubukmalako

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**Test lagi:**
```
https://bumnagmadani.com
```

---

## 🗄️ STEP 9: Setup Database (Optional - Untuk Fitur Lengkap)

```bash
cd ~/public_html/bumnag-madani-lubukmalako

# Run migrations
php artisan migrate --force

# Seed data (admin, sample data)
php artisan db:seed --force

# Create storage link
php artisan storage:link
```

---

## 🎨 STEP 10: Build Assets (Optional - Untuk Styling Lengkap)

Jika NPM ada:
```bash
# Cari npm
which npm
/usr/local/bin/npm --version

# Install & build
/usr/local/bin/npm install
/usr/local/bin/npm run build
```

---

## ✅ CHECKLIST MINIMAL

Agar halaman depan muncul, WAJIB:
- [x] Repository di-clone ke `~/public_html/bumnag-madani-lubukmalako`
- [x] File `.env` sudah ada dan terisi
- [x] `APP_KEY` sudah di-generate
- [x] Permission `storage/` dan `bootstrap/cache/` sudah di-set
- [x] Document root mengarah ke `public_html/bumnag-madani-lubukmalako/public`

Opsional (untuk fitur lengkap):
- [ ] Composer dependencies installed
- [ ] Database migrations dijalankan
- [ ] NPM build assets

---

## 🛠️ TROUBLESHOOTING CEPAT

### Error 500:
```bash
tail -50 ~/public_html/bumnag-madani-lubukmalako/storage/logs/laravel.log
```

### Permission Error:
```bash
chmod -R 755 ~/public_html/bumnag-madani-lubukmalako/storage
chmod -R 755 ~/public_html/bumnag-madani-lubukmalako/bootstrap/cache
```

### APP_KEY Not Set:
```bash
cd ~/public_html/bumnag-madani-lubukmalako
php artisan key:generate --force
```

### Composer Not Found:
```bash
# Download composer lokal
cd ~/public_html/bumnag-madani-lubukmalako
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev
```

---

## 📞 CONTACT

**Jika halaman depan sudah muncul:**
- ✅ Basic deployment berhasil!
- Login admin: https://bumnagmadani.com/login
  - Email: admin@bumnagmadani.id
  - Password: admin123

**Untuk troubleshooting:** Check `storage/logs/laravel.log`

---

**Last Updated:** February 7, 2026
