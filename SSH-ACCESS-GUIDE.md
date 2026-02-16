# 🔐 Setup SSH dari Terminal Lokal Windows ke cPanel

## Panduan Lengkap Akses SSH dari PowerShell/Terminal Windows

---

## 📋 Prerequisites

Anda sudah punya:
- ✅ Private key: `id_rsa_bumnag`
- ✅ Public key: `id_rsa_bumnag.pub`
- ✅ Username cPanel: `bump2384`
- ✅ Domain: `bumnagmadani.com`
- ✅ Password cPanel: `m39a6i3S1fp362`

---

## 🔧 STEP 1: Upload Public Key ke cPanel

### Via cPanel SSH Access Manager:

1. **Login ke cPanel**
   - URL: https://bumnagmadani.com:2083
   - Username: `bump2384`
   - Password: `m39a6i3S1fp362`

2. **Buka SSH Access**
   - Cari menu **"SSH Access"** di cPanel
   - Atau **"Manage SSH Keys"**

3. **Import Public Key**
   - Klik **"Manage SSH Keys"**
   - Klik **"Import Key"**
   - Public Key Name: `bumnag_key`
   - Paste isi file `id_rsa_bumnag.pub`:
     ```
     ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCidohDmMS/B7xE+Rd1nmZK+ZjBhu0kVw+sdWuDIjX9Fi+8KZ/95Ysh1t07s7RGZLzfdCrhgz7s7cpQ7W/WDqrb1F/WUdrZXD9D7z/8L+aAkWM0ag1wXHAsA2zrICPMZiFlH99NTKgSd+gBYWlN1kmbgc4zWwXprBdVdN1CFLzxrmIYH/6f36UsQxHlotHY7g1SSs3F6/wzcoh8XrFXv28c2iF7iMc8RTo0DVSGVD96ozP6BDM+ChZzuTn8LLaCzcGnyhNrqe4ecAWzrxWABYplMAmKlr4Bdvya1w387qZjl1y6GBaVQJvVKdpF5wumxCYASagVFAYKbOAw1Vj8wI+n
     ```
   - Klik **"Import"**

4. **Authorize Key**
   - Setelah import, klik **"Manage"** pada key `bumnag_key`
   - Klik **"Authorize"**
   - Key akan ter-copy ke `~/.ssh/authorized_keys`

5. **Verifikasi**
   - Pastikan status key: **"authorized"**

---

## 🖥️ STEP 2: Setup SSH di Windows Lokal

### A. Pindahkan SSH Key ke Folder .ssh

Buka PowerShell dan jalankan:

```powershell
# Buat folder .ssh jika belum ada
New-Item -ItemType Directory -Force -Path "$env:USERPROFILE\.ssh"

# Copy private key ke .ssh
Copy-Item "D:\Website\bumnag-madani-lubukmalako\id_rsa_bumnag" "$env:USERPROFILE\.ssh\id_rsa_bumnag"

# Set permission (read only untuk user)
icacls "$env:USERPROFILE\.ssh\id_rsa_bumnag" /inheritance:r /grant:r "$($env:USERNAME):(R)"

# Verifikasi
Get-ChildItem "$env:USERPROFILE\.ssh" | Select-Object Name
```

---

### B. Buat SSH Config File

```powershell
# Edit SSH config
notepad "$env:USERPROFILE\.ssh\config"
```

Paste konfigurasi ini (atau tambahkan jika file sudah ada):

```
# BUMNag Madani Server
Host bumnag
    HostName bumnagmadani.com
    User bump2384
    Port 22
    IdentityFile ~/.ssh/id_rsa_bumnag
    IdentitiesOnly yes
    StrictHostKeyChecking no
```

**Simpan** file config (`CTRL+S`, `ALT+F4`)

---

### C. Test Koneksi SSH

```powershell
# Test koneksi
ssh bumnag "echo 'SSH Connection Successful!'"
```

**Jika berhasil**, akan muncul: `SSH Connection Successful!`

**Jika password diminta**, artinya key belum ter-authorize di cPanel (ulangi STEP 1).

---

## 🚀 STEP 3: Deploy Update ke Server

Setelah SSH berhasil, deploy update dengan command berikut:

### Via Terminal Lokal (PowerShell):

```powershell
# SSH ke server dan deploy
ssh bumnag
```

Setelah masuk server, jalankan:

```bash
# Masuk ke folder project
cd ~/public_html/bumnag-madani-lubukmalako

# Pull update terbaru dari GitHub
git pull origin main

# Run migrations baru (jika ada)
php artisan migrate --force

# Seed data baru (jika ada)
php artisan db:seed --class=HeroSlideSeeder --force

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan config:cache
php artisan route:cache

# Exit SSH
exit
```

---

## 📦 STEP 4: Deployment Update Otomatis (One-Liner)

Setelah SSH setup, deploy bisa dilakukan dari PowerShell lokal Anda:

```powershell
# Single command deployment
ssh bumnag "cd ~/public_html/bumnag-madani-lubukmalako && git pull origin main && php artisan migrate --force && php artisan config:clear && php artisan cache:clear && php artisan config:cache && echo 'Deployment Successful!'"
```

---

## ✅ STEP 5: Verifikasi Website

Buka browser:
```
https://bumnagmadani.com
```

- ✅ Halaman muncul dengan styling lengkap
- ✅ Hero slides baru tampil (jika ada)
- ✅ Fitur baru berfungsi

---

## 🔄 Workflow Update Masa Depan

Setiap kali ada update code:

### 1. Di Lokal (Windows):
```powershell
cd D:\Website\bumnag-madani-lubukmalako

# Pull changes
git pull origin main

# Build assets
npm run build

# Commit build
git add public/build -f
git commit -m "🎨 Update build assets"
git push
```

### 2. Deploy ke Server:
```powershell
# Single command
ssh bumnag "cd ~/public_html/bumnag-madani-lubukmalako && git pull origin main && php artisan migrate --force && php artisan config:clear && php artisan cache:clear && php artisan config:cache"
```

### 3. Test:
```
https://bumnagmadani.com
```

---

## 🛠️ Troubleshooting

### SSH Key Permission Denied:
```powershell
# Fix permission
icacls "$env:USERPROFILE\.ssh\id_rsa_bumnag" /inheritance:r /grant:r "$($env:USERNAME):(R)"
```

### Masih Minta Password:
1. Pastikan public key sudah di-**authorize** di cPanel
2. Cek `~/.ssh/authorized_keys` di server
3. Restart SSH daemon (hubungi hosting support)

### Git Pull Conflict:
```bash
cd ~/public_html/bumnag-madani-lubukmalako
git reset --hard origin/main
git pull origin main
```

### Cache Issue:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
rm -rf bootstrap/cache/*.php
```

---

## 📞 Quick Reference

**SSH dari PowerShell:**
```powershell
ssh bumnag
```

**Deploy Update:**
```powershell
ssh bumnag "cd ~/public_html/bumnag-madani-lubukmalako && git pull && php artisan migrate --force && php artisan cache:clear && php artisan config:cache"
```

**Check Status:**
```powershell
ssh bumnag "cd ~/public_html/bumnag-madani-lubukmalako && git status && php artisan --version"
```

**View Logs:**
```powershell
ssh bumnag "tail -50 ~/public_html/bumnag-madani-lubukmalako/storage/logs/laravel.log"
```

---

## 🎯 Keuntungan Setup ini:

- ✅ Deploy update dalam **1 command**
- ✅ Tidak perlu login cPanel setiap kali
- ✅ Tidak perlu password SSH berulang
- ✅ Bisa run command remote dari PowerShell lokal
- ✅ Automation-ready (bisa dibuat script)

---

**Last Updated:** February 7, 2026  
**Author:** GitHub Copilot  
**Project:** BUMNag Madani Lubuk Malako
