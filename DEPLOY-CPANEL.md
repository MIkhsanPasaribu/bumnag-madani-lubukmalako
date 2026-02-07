# 🚀 DEPLOYMENT VIA TERMINAL cPANEL

## Karena SSH dari luar di-block, gunakan Terminal built-in cPanel

---

## 📝 LANGKAH LENGKAP

### 1️⃣ Buka Terminal cPanel

1. Login ke cPanel: **https://bumnagmadani.com:2083**
2. Username: `bump2384`
3. Password: `m39a6i3S1fp362`
4. Cari menu **"Terminal"** (biasanya di kategori Advanced)
5. Klik untuk membuka terminal

Terminal akan muncul dengan prompt:
```
bump2384@embaloh:~$
```

---

### 2️⃣ Buat Database MySQL (WAJIB!)

**Via cPanel:**
1. Buka **MySQL Database Wizard**
2. Step 1 - Database Name: `bumnag_madani`
3. Step 2 - Username: `admin` (akan jadi `bump2384_admin`)
4. Step 3 - Password: Buat password kuat (CATAT!)
5. Step 4 - Privileges: Centang **ALL PRIVILEGES**
6. Finish

**CATAT INFO INI:**
- Database: `bump2384_bumnag_madani`
- Username: `bump2384_admin`
- Password: `[password yang kamu buat]`

---

### 3️⃣ Jalankan Deployment Script

Copy-paste **SEMUA COMMAND INI** ke Terminal cPanel:

```bash
# Download deployment script dari GitHub
cd ~/public_html
curl -O https://raw.githubusercontent.com/MIkhsanPasaribu/bumnag-madani-lubukmalako/main/deploy-cpanel.sh

# Set permission
chmod +x deploy-cpanel.sh

# Jalankan deployment
./deploy-cpanel.sh
```

Script akan otomatis:
- ✅ Clone repository dari GitHub
- ✅ Setup .env file
- ✅ Install Composer dependencies
- ✅ Install NPM dependencies
- ✅ Build production assets
- ✅ Set file permissions
- ✅ Run database migrations
- ✅ (Optional) Seed data sample
- ✅ Create storage link
- ✅ Optimize Laravel cache

---

### 4️⃣ Edit File .env

Script akan pause dan minta Anda edit .env. Jalankan:

```bash
nano ~/public_html/bumnag-madani-lubukmalako/.env
```

**Edit baris berikut:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bumnagmadani.com

DB_DATABASE=bump2384_bumnag_madani
DB_USERNAME=bump2384_admin
DB_PASSWORD=password_database_yang_kamu_buat_tadi
```

**Simpan:**
- Tekan `CTRL + X`
- Tekan `Y`
- Tekan `Enter`

Tekan Enter di terminal untuk melanjutkan deployment.

---

### 5️⃣ Set Document Root via cPanel

1. Di cPanel, buka **Domains**
2. Klik **Manage** pada `bumnagmadani.com`
3. Set **Document Root** ke:
   ```
   public_html/bumnag-madani-lubukmalako/public
   ```
4. **Save**

**ATAU via .htaccess (jika tidak bisa ubah document root):**

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

### 6️⃣ Test Website

Buka browser:
- **Homepage:** https://bumnagmadani.com
- **Admin Login:** https://bumnagmadani.com/login
  - Email: `admin@bumnagmadani.id`
  - Password: `admin123`

**✅ DEPLOYMENT SELESAI!**

---

## 🔄 UPDATE DI MASA DEPAN

Jika ada update code di GitHub:

```bash
cd ~/public_html/bumnag-madani-lubukmalako
git pull origin main
composer install --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🛠️ TROUBLESHOOTING

### Error 500 Internal Server Error:
```bash
cd ~/public_html/bumnag-madani-lubukmalako
php artisan config:clear
php artisan cache:clear
chmod -R 755 storage bootstrap/cache
tail -50 storage/logs/laravel.log
```

### Database Connection Error:
```bash
# Test koneksi
php artisan migrate:status

# Cek .env
cat .env | grep DB_
```

### Composer/NPM Not Found:
```bash
# Check path
which composer
which npm

# Gunakan path lengkap jika perlu
/usr/local/bin/composer install
/usr/local/bin/npm install
```

### Permission Denied:
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs public/uploads
```

---

## 📞 INFO

**Login Default:**
- URL: https://bumnagmadani.com/login
- Email: admin@bumnagmadani.id
- Password: admin123

**⚠️ PENTING: Ganti password setelah login pertama!**

---

**Last Updated:** February 7, 2026
