# BUKU PANDUAN PENGGUNAAN

# Website BUMNag Madani Lubuk Malako

---

<p align="center">
  <strong>BADAN USAHA MILIK NAGARI MADANI LUBUK MALAKO</strong><br>
  Sistem Informasi Manajemen Keuangan dan Publikasi<br><br>
  <em>Versi Dokumen: 1.0</em><br>
  <em>Tanggal Pembaruan: 19 Februari 2026</em><br>
  <em>URL Website: https://bumnagmadani.com</em>
</p>

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
   - 1.1 [Tentang Dokumen Ini](#11-tentang-dokumen-ini)
   - 1.2 [Tentang Website BUMNag Madani](#12-tentang-website-bumnag-madani)
   - 1.3 [Spesifikasi Teknis](#13-spesifikasi-teknis)
   - 1.4 [Hak Akses Pengguna (Role)](#14-hak-akses-pengguna-role)
2. [Halaman Publik (Pengunjung)](#2-halaman-publik-pengunjung)
   - 2.1 [Beranda](#21-beranda)
   - 2.2 [Profil BUMNag](#22-profil-bumnag)
   - 2.3 [Statistik Keuangan](#23-statistik-keuangan)
   - 2.4 [Transparansi Keuangan](#24-transparansi-keuangan)
   - 2.5 [Berita](#25-berita)
   - 2.6 [Laporan Tahunan](#26-laporan-tahunan)
   - 2.7 [Galeri BUMNag](#27-galeri-bumnag)
   - 2.8 [Hubungi Kami](#28-hubungi-kami)
   - 2.9 [Tim Pengembang](#29-tim-pengembang)
3. [Autentikasi (Login & Lupa Password)](#3-autentikasi-login--lupa-password)
   - 3.1 [Login ke Sistem](#31-login-ke-sistem)
   - 3.2 [Lupa Password](#32-lupa-password)
   - 3.3 [Logout](#33-logout)
4. [Panel Admin (Super Admin & Admin)](#4-panel-admin-super-admin--admin)
   - 4.1 [Dashboard Admin](#41-dashboard-admin)
   - 4.2 [Kelola Profil BUMNag](#42-kelola-profil-bumnag)
   - 4.3 [Kelola Berita](#43-kelola-berita)
   - 4.4 [Kelola Kategori Berita](#44-kelola-kategori-berita)
   - 4.5 [Kelola Laporan Keuangan](#45-kelola-laporan-keuangan)
   - 4.6 [Kelola Laporan Tahunan](#46-kelola-laporan-tahunan)
   - 4.7 [Kelola Hero Slide](#47-kelola-hero-slide)
   - 4.8 [Kelola Galeri BUMNag](#48-kelola-galeri-bumnag)
   - 4.9 [Kelola Informasi Kontak](#49-kelola-informasi-kontak)
   - 4.10 [Kelola Pesan Masuk](#410-kelola-pesan-masuk)
   - 4.11 [Kelola Akun Pengguna](#411-kelola-akun-pengguna)
   - 4.12 [Ganti Password](#412-ganti-password)
   - 4.13 [Pertanyaan Keamanan](#413-pertanyaan-keamanan)
   - 4.14 [Error Logs (Khusus Super Admin)](#414-error-logs-khusus-super-admin)
5. [Panel Unit Usaha](#5-panel-unit-usaha)
   - 5.1 [Dashboard Unit](#51-dashboard-unit)
   - 5.2 [Kelola Laporan Keuangan Unit](#52-kelola-laporan-keuangan-unit)
6. [Panel Sub Unit Usaha](#6-panel-sub-unit-usaha)
   - 6.1 [Dashboard Sub Unit](#61-dashboard-sub-unit)
   - 6.2 [Kelola Laporan Keuangan Sub Unit](#62-kelola-laporan-keuangan-sub-unit)
7. [Contoh Alur Penggunaan Lengkap](#7-contoh-alur-penggunaan-lengkap)
   - 7.1 [Alur Login dan Menambahkan Berita](#71-alur-login-dan-menambahkan-berita)
   - 7.2 [Alur Menambahkan Laporan Keuangan Bulanan](#72-alur-menambahkan-laporan-keuangan-bulanan)
   - 7.3 [Alur Upload Laporan Tahunan](#73-alur-upload-laporan-tahunan)
   - 7.4 [Alur Mengelola Hero Slide](#74-alur-mengelola-hero-slide)
   - 7.5 [Alur Unit Usaha Melaporkan Keuangan](#75-alur-unit-usaha-melaporkan-keuangan)
   - 7.6 [Alur Melihat dan Membalas Pesan Masuk](#76-alur-melihat-dan-membalas-pesan-masuk)
   - 7.7 [Alur Pengunjung Mengirim Pesan](#77-alur-pengunjung-mengirim-pesan)
8. [Panduan Keamanan Akun](#8-panduan-keamanan-akun)
9. [Panduan Unggah File dan Media](#9-panduan-unggah-file-dan-media)
10. [FAQ (Pertanyaan yang Sering Diajukan)](#10-faq-pertanyaan-yang-sering-diajukan)
11. [Informasi Kontak Dukungan Teknis](#11-informasi-kontak-dukungan-teknis)

---

## 1. PENDAHULUAN

### 1.1 Tentang Dokumen Ini

Dokumen ini merupakan **Buku Panduan Penggunaan Resmi** untuk Website BUMNag Madani Lubuk Malako. Panduan ini ditujukan kepada seluruh pengguna sistem, meliputi:

- **Pengunjung umum** yang mengakses informasi publik
- **Super Admin** yang mengelola seluruh konten dan sistem
- **Admin** yang mengelola konten dan data operasional
- **Operator Unit Usaha** yang menginput laporan keuangan unit
- **Operator Sub Unit Usaha** yang menginput laporan keuangan sub unit

Panduan ini mencakup penjelasan lengkap tentang setiap fitur yang tersedia, langkah-langkah penggunaan secara detail, serta contoh alur kerja (workflow) dari awal hingga akhir proses.

### 1.2 Tentang Website BUMNag Madani

Website BUMNag Madani Lubuk Malako adalah **Sistem Informasi Manajemen** berbasis web yang dirancang untuk:

1. **Menampilkan profil organisasi** — Sejarah, visi & misi, dan struktur organisasi BUMNag Madani Lubuk Malako kepada publik
2. **Mengelola dan mempublikasikan berita** — Berita terkini seputar kegiatan dan program BUMNag
3. **Mencatat dan melaporkan keuangan** — Pencatatan pendapatan dan pengeluaran per unit usaha secara bulanan
4. **Transparansi keuangan** — Menyediakan akses publik terhadap ringkasan laporan keuangan dan dokumen laporan tahunan
5. **Menyediakan galeri foto** — Dokumentasi kegiatan dalam bentuk galeri visual
6. **Menerima pesan dari masyarakat** — Formulir kontak untuk komunikasi dua arah antara BUMNag dan masyarakat

### 1.3 Spesifikasi Teknis

| Komponen | Keterangan |
|----------|------------|
| **Platform** | Aplikasi Web (Browser-based) |
| **Framework** | Laravel 12 |
| **Bahasa Backend** | PHP 8.2+ |
| **Database** | MySQL 8.0+ |
| **Frontend** | Tailwind CSS, Alpine.js, Chart.js |
| **PDF Generator** | DomPDF |
| **Browser yang Didukung** | Google Chrome, Mozilla Firefox, Microsoft Edge, Safari (versi terbaru) |
| **Responsif** | Mendukung Desktop, Tablet, dan Smartphone |

### 1.4 Hak Akses Pengguna (Role)

Website ini menerapkan **4 tingkatan hak akses** yang mengatur siapa dapat melakukan apa di dalam sistem:

| No | Role | Kode | Deskripsi Akses |
|----|------|------|-----------------|
| 1 | **Super Admin** | `super_admin` | Akses penuh ke seluruh fitur sistem, termasuk Error Logs dan manajemen teknis. Hanya ada 1 akun Super Admin. |
| 2 | **Admin** | `admin` | Akses ke seluruh fitur pengelolaan konten: berita, laporan keuangan, laporan tahunan, hero slide, galeri, profil organisasi, informasi kontak, dan pesan masuk. Tidak dapat mengakses Error Logs. |
| 3 | **Operator Unit Usaha** | `unit` | Akses terbatas untuk menginput laporan keuangan **hanya untuk unit usaha yang ditugaskan**. Dapat melihat laporan sub unit di bawahnya. Tidak dapat mengedit data yang diinput oleh Admin. |
| 4 | **Operator Sub Unit Usaha** | `sub_unit` | Akses paling terbatas. Hanya dapat menginput laporan keuangan **untuk sub unit usaha yang ditugaskan**. Tidak dapat mengedit data yang diinput oleh Admin atau Operator Unit. |

**Catatan Penting:**
- Setiap role memiliki **dashboard terpisah** yang disesuaikan dengan kebutuhan dan hak aksesnya
- **Admin dan Super Admin** menggunakan navigasi **sidebar** (menu samping kiri)
- **Unit dan Sub Unit** juga menggunakan navigasi **sidebar** yang lebih sederhana
- **Pengunjung umum** menggunakan navigasi **navbar horizontal** (menu atas)

---

## 2. HALAMAN PUBLIK (PENGUNJUNG)

Halaman publik adalah halaman-halaman yang dapat diakses oleh **siapa saja tanpa perlu login**. Halaman-halaman ini menampilkan informasi resmi BUMNag Madani kepada masyarakat umum.

**Navigasi Publik (Navbar):**

Menu navigasi terletak di bagian atas halaman (sticky/tetap terlihat saat scroll) dengan urutan:

| Menu | URL | Keterangan |
|------|-----|------------|
| Beranda | `/` | Halaman utama |
| Profil | `/profil` | Informasi organisasi |
| Statistik | `/statistik` | Grafik keuangan |
| Transparansi | `/transparansi` | Laporan keuangan publik |
| Berita | `/berita` | Daftar berita |
| Laporan Tahunan | `/laporan-tahunan` | Dokumen tahunan |
| Hubungi Kami | `/hubungi-kami` | Formulir kontak |
| Login Admin | `/login` | Masuk ke panel admin |

Pada tampilan **mobile/smartphone**, menu navigasi akan berubah menjadi **hamburger menu** (ikon tiga garis horizontal) yang dapat diklik untuk menampilkan menu secara vertikal.

---

### 2.1 Beranda

**URL:** `https://bumnagmadani.com/` atau `https://bumnagmadani.com`

Halaman beranda merupakan **halaman utama** website yang menampilkan ringkasan seluruh informasi penting BUMNag Madani. Halaman ini terdiri dari beberapa bagian (section):

#### A. Hero Slider (Banner Utama)

- Menampilkan **slide gambar/video** secara fullscreen dengan judul dan subjudul
- Slide berganti otomatis setiap **6 detik**
- Terdapat navigasi titik (dots) di bagian bawah slider untuk berpindah slide secara manual
- Setiap slide dapat memiliki **tombol CTA** (Call-to-Action) yang mengarah ke halaman tertentu
- Mendukung media berupa **gambar** dan **video**

#### B. Ringkasan Statistik Keuangan

- Menampilkan **total pendapatan**, **total pengeluaran**, dan **laba/rugi** untuk tahun berjalan
- Data disajikan dalam format kartu (card) dengan angka yang diformat dalam Rupiah
- Memberikan gambaran singkat kondisi keuangan BUMNag kepada masyarakat

#### C. Berita Terbaru (Carousel)

- Menampilkan **8 berita terbaru** yang sudah dipublikasikan
- Disajikan dalam format carousel horizontal yang dapat digeser (swipe)
- Setiap kartu berita menampilkan: gambar, judul, kategori, dan tanggal publikasi
- Klik pada kartu berita untuk membaca artikel lengkap

#### D. Laporan Tahunan Terbaru

- Menampilkan **4 laporan tahunan terbaru** yang sudah dipublikasikan
- Setiap kartu menampilkan: cover image, judul, tahun, dan deskripsi singkat
- Tersedia tombol untuk membaca detail atau mengunduh dokumen PDF

#### E. Galeri Foto

- Menampilkan **8 foto terbaru** dari galeri BUMNag
- Disajikan dalam format slider/carousel
- Klik pada foto untuk melihat ukuran penuh

#### F. Statistik Ringkas

- Menampilkan **jumlah total berita** dan **jumlah total laporan** yang tersedia di website

---

### 2.2 Profil BUMNag

**URL:** `https://bumnagmadani.com/profil`

Halaman ini menampilkan **informasi lengkap tentang organisasi** BUMNag Madani Lubuk Malako, meliputi:

| Section | Konten |
|---------|--------|
| **Identitas** | Nama BUMNag, Nama Nagari, Alamat lengkap, Nomor Telepon, Email, Website |
| **Logo** | Logo resmi BUMNag Madani |
| **Sejarah** | Narasi sejarah pendirian dan perkembangan BUMNag |
| **Visi** | Pernyataan visi organisasi |
| **Misi** | Daftar misi organisasi |
| **Struktur Organisasi** | Daftar pengurus dengan jabatan, nama, dan foto. Ditampilkan dalam format kartu yang rapi|

---

### 2.3 Statistik Keuangan

**URL:** `https://bumnagmadani.com/statistik`

Halaman statistik menyajikan **dashboard visual** yang menampilkan data keuangan BUMNag dalam bentuk grafik dan tabel interaktif. Halaman ini dirancang untuk memberikan gambaran menyeluruh tentang kondisi keuangan organisasi.

#### Fitur yang Tersedia:

**1. Filter Tahun**
- Pengguna dapat memilih tahun yang ingin dilihat melalui dropdown
- Secara default menampilkan data tahun berjalan
- Daftar tahun tersedia berdasarkan data yang sudah diinput

**2. Kartu Ringkasan (Summary Cards)**
- **Total Pendapatan** — Jumlah seluruh pendapatan pada tahun terpilih
- **Total Pengeluaran** — Jumlah seluruh pengeluaran pada tahun terpilih
- **Laba/Rugi** — Selisih pendapatan dan pengeluaran (ditampilkan hijau jika laba, merah jika rugi)

**3. Pertumbuhan Tahunan (Year-over-Year Growth)**
- Perbandingan pendapatan dan pengeluaran dengan tahun sebelumnya
- Ditampilkan dalam persentase pertumbuhan

**4. Rasio Keuangan**
- **Rasio Pengeluaran** (Expense Ratio) — Persentase pengeluaran terhadap pendapatan
- **Margin Laba** (Profit Margin) — Persentase laba terhadap pendapatan

**5. Proyeksi Tahunan**
- Estimasi pendapatan, pengeluaran, dan laba untuk sisa tahun berjalan
- Dihitung berdasarkan rata-rata bulan yang sudah terdata

**6. Grafik Bulanan (Bar/Line Chart)**
- Grafik interaktif menampilkan **pendapatan, pengeluaran, dan laba/rugi** per bulan
- Menggunakan Chart.js yang dapat di-hover untuk melihat nilai detail

**7. Grafik Proporsi Per Unit (Pie Chart)**
- Diagram lingkaran menampilkan kontribusi masing-masing unit usaha
- Setiap unit memiliki warna yang berbeda

**8. Tabel Rekap Per Unit**
- Tabel rinci menampilkan pendapatan, pengeluaran, dan laba/rugi per unit usaha
- Termasuk total keseluruhan

**9. Grafik Proporsi Pendapatan vs Pengeluaran**
- Visualisasi perbandingan antara total pendapatan dan total pengeluaran

**10. Detail Bulanan**
- Klik pada bulan tertentu untuk melihat **breakdown detail per unit dan sub unit** pada bulan tersebut
- URL: `/statistik/{bulan}/{tahun}`

---

### 2.4 Transparansi Keuangan

**URL:** `https://bumnagmadani.com/transparansi`

Halaman transparansi memberikan akses publik terhadap **data keuangan BUMNag yang lebih rinci** dalam format tabel dan dokumen PDF yang dapat diunduh.

#### Fitur yang Tersedia:

**1. Filter Tahun**
- Dropdown untuk memilih tahun yang ingin ditampilkan

**2. Tabel Laporan Bulanan**
- Menampilkan data keuangan per bulan untuk tahun yang dipilih
- Kolom: Bulan, Pendapatan, Pengeluaran, Laba/Rugi

**3. Tabel Laporan Per Unit Usaha**
- Breakdown keuangan per unit usaha untuk tahun terpilih

**4. Statistik Keseluruhan**
- Total pendapatan, pengeluaran, dan laba/rugi tahunan

**5. Download Laporan PDF**
Website menyediakan **3 jenis dokumen PDF** yang dapat diunduh:

| Jenis PDF | Deskripsi | URL |
|-----------|-----------|-----|
| **PDF Bulanan** | Laporan satu bulan tertentu (semua unit) | `/transparansi/download/{bulan}/{tahun}` |
| **PDF Tahunan** | Laporan satu tahun penuh (semua unit) | `/transparansi/download-tahunan/{tahun}` |
| **PDF Per Unit** | Laporan satu unit untuk satu tahun | `/transparansi/download-unit/{tahun}/{unit}` |

Semua dokumen PDF dihasilkan dalam format **landscape A4** untuk memudahkan pembacaan tabel data keuangan.

---

### 2.5 Berita

**URL:** `https://bumnagmadani.com/berita`

Halaman berita menampilkan **daftar berita dan artikel terkini** yang diterbitkan oleh BUMNag Madani.

#### A. Daftar Berita (Index)

- Menampilkan berita yang sudah dipublikasikan dengan pagination **9 berita per halaman**
- Di bagian atas terdapat **3 berita unggulan** (featured) yang ditampilkan lebih besar

**Filter dan Pencarian:**

| Filter | Cara Penggunaan |
|--------|-----------------|
| **Kategori** | Klik nama kategori pada sidebar atau gunakan URL: `/berita?kategori=nama-kategori` |
| **Pencarian** | Ketik kata kunci pada kolom pencarian. Sistem mencari di judul, konten, dan ringkasan berita |

**Informasi yang Ditampilkan Per Berita:**
- Gambar utama (featured image)
- Judul berita
- Kategori (dengan warna label)
- Ringkasan
- Tanggal publikasi
- Jumlah views (tayangan)

#### B. Detail Berita

**URL:** `https://bumnagmadani.com/berita/{slug}`

Halaman detail menampilkan artikel berita secara lengkap:

| Elemen | Keterangan |
|--------|------------|
| **Judul** | Judul lengkap berita |
| **Gambar Utama** | Featured image ditampilkan di bagian atas |
| **Kategori** | Label kategori dengan warna |
| **Tanggal Publikasi** | Tanggal berita dipublikasikan |
| **Tanggal Kegiatan** | Tanggal kegiatan/peristiwa terjadi (jika diisi) |
| **Penulis** | Nama penulis/admin yang mempublikasikan |
| **Konten** | Isi artikel lengkap dengan formatting (bold, italic, gambar, dll.) |
| **Galeri Gambar** | Kumpulan gambar tambahan terkait berita |
| **Lampiran** | File yang dapat diunduh (PDF, Excel, Word) jika tersedia |
| **Link Terkait** | Tautan ke sumber atau halaman terkait jika tersedia |
| **Berita Terkait** | 4 berita lain dari kategori yang sama sebagai rekomendasi |
| **Sidebar Kategori** | Daftar semua kategori dengan jumlah berita masing-masing |

#### C. Berita Per Kategori

**URL:** `https://bumnagmadani.com/berita/kategori/{slug}`

Menampilkan berita yang difilter berdasarkan kategori tertentu. Memiliki tampilan yang sama dengan halaman daftar berita, namun hanya menampilkan berita dari kategori yang dipilih.

---

### 2.6 Laporan Tahunan

**URL:** `https://bumnagmadani.com/laporan-tahunan`

Halaman ini menampilkan **dokumen laporan tahunan BUMNag** yang dapat diunduh oleh masyarakat.

#### A. Daftar Laporan Tahunan

- Menampilkan **12 laporan per halaman** dengan pagination
- Tersedia kolom **pencarian** untuk mencari berdasarkan judul atau tahun

**Statistik yang Ditampilkan:**
- Total laporan yang tersedia
- Total unduhan seluruh laporan
- Berapa tahun yang sudah memiliki laporan

**Informasi Per Laporan:**
- Cover image (gambar sampul)
- Judul laporan
- Tahun laporan
- Deskripsi singkat
- Jumlah unduhan

#### B. Detail Laporan Tahunan

**URL:** `https://bumnagmadani.com/laporan-tahunan/{slug}`

Menampilkan informasi lengkap tentang laporan tahunan, termasuk:
- Cover image
- Judul dan deskripsi lengkap
- Tahun laporan
- Tanggal publikasi
- Jumlah unduhan
- Tombol **Download PDF** untuk mengunduh dokumen laporan
- Navigasi ke laporan sebelumnya/berikutnya

#### C. Download Laporan

**URL:** `https://bumnagmadani.com/laporan-tahunan/{slug}/download`

Klik tombol **"Download"** akan mengunduh file PDF laporan tahunan. Sistem secara otomatis mencatat jumlah unduhan.

---

### 2.7 Galeri BUMNag

**URL:** `https://bumnagmadani.com/galeri-bumnag`

Halaman galeri menampilkan **kumpulan foto dokumentasi** kegiatan BUMNag Madani.

**Fitur:**
- Menampilkan **20 foto per halaman** dengan pagination
- **Filter pencarian** berdasarkan judul foto
- **Filter tahun** untuk menampilkan foto berdasarkan tahun
- Setiap foto menampilkan: gambar, judul, dan deskripsi singkat
- Klik foto untuk melihat dalam ukuran penuh (lightbox)

---

### 2.8 Hubungi Kami

**URL:** `https://bumnagmadani.com/hubungi-kami`

Halaman ini menyediakan **informasi kontak** dan **formulir pesan** bagi masyarakat yang ingin berkomunikasi dengan BUMNag Madani.

#### A. Informasi Kontak

Menampilkan informasi kontak resmi BUMNag:
- Nomor telepon
- Alamat email
- Alamat fisik lengkap
- Peta lokasi (Google Maps embed)
- Link media sosial: Facebook, Instagram, YouTube, TikTok, Twitter, WhatsApp

#### B. Formulir Kontak

| Field | Wajib Diisi | Keterangan |
|-------|-------------|------------|
| **Nama** | Ya | Nama lengkap pengirim (maks. 255 karakter) |
| **Organisasi** | Tidak | Nama organisasi/instansi (maks. 255 karakter) |
| **Email** | Ya | Alamat email yang valid (maks. 255 karakter) |
| **Subjek** | Ya | Perihal pesan (maks. 255 karakter) |
| **Pesan** | Ya | Isi pesan (maks. 1.500 karakter) |

**Setelah mengirim pesan:**
- Sistem menampilkan notifikasi bahwa pesan berhasil dikirim
- Pesan akan masuk ke **kotak masuk admin** untuk ditindaklanjuti
- Semua pesan masuk akan ditandai sebagai "belum dibaca" hingga admin membukanya

---

### 2.9 Tim Pengembang

**URL:** `https://bumnagmadani.com/tim-pengembang`

Halaman ini menampilkan informasi tentang **tim pengembang** yang membangun website BUMNag Madani, meliputi nama, NIM, program studi, jabatan dalam tim, foto, dan tautan ke media sosial/portofolio masing-masing.

---

## 3. AUTENTIKASI (LOGIN & LUPA PASSWORD)

### 3.1 Login ke Sistem

**URL:** `https://bumnagmadani.com/login`

#### Langkah-Langkah Login:

**Langkah 1:** Buka halaman login melalui menu **"Login Admin"** pada navbar, atau kunjungi URL `/login` secara langsung.

**Langkah 2:** Masukkan kredensial akun:

| Field | Keterangan |
|-------|------------|
| **Email** | Alamat email akun yang terdaftar |
| **Password** | Kata sandi akun |
| **Ingat Saya** | Centang opsional agar sesi login bertahan lebih lama |

**Langkah 3:** Klik tombol **"Masuk"**.

**Langkah 4:** Sistem akan mengarahkan Anda ke **dashboard** sesuai dengan role akun:

| Role | Halaman Tujuan Setelah Login |
|------|------------------------------|
| Super Admin | `/admin` (Dashboard Admin) |
| Admin | `/admin` (Dashboard Admin) |
| Unit Usaha | `/unit` (Dashboard Unit) |
| Sub Unit Usaha | `/sub-unit` (Dashboard Sub Unit) |

**Akun Default Sistem:**

| Akun | Email | Password | Role |
|------|-------|----------|------|
| Admin Utama | `admin@bumnagmadani.id` | `admin123` | Super Admin |
| Operator | `operator@bumnagmadani.id` | `operator123` | Admin |

> **⚠️ PERINGATAN KEAMANAN:** Segera ubah password default setelah login pertama kali! Lihat panduan di [Bagian 4.12 Ganti Password](#412-ganti-password).

**Jika Login Gagal:**
- Pastikan email dan password sudah benar (perhatikan huruf besar/kecil)
- Pastikan tidak ada spasi tambahan sebelum atau sesudah email/password
- Jika lupa password, gunakan fitur **Lupa Password** (lihat Bagian 3.2)

---

### 3.2 Lupa Password

**URL:** `https://bumnagmadani.com/lupa-password`

Sistem pemulihan password menggunakan **Pertanyaan Keamanan** (bukan email), sehingga proses pemulihan dapat dilakukan secara offline tanpa memerlukan akses email.

#### Proses Pemulihan Password (3 Tahap):

**Tahap 1: Verifikasi Email**
1. Klik link **"Lupa password?"** pada halaman login
2. Masukkan **alamat email** akun yang akan dipulihkan
3. Klik **"Lanjutkan"**
4. Sistem memeriksa apakah email terdaftar dan memiliki pertanyaan keamanan

> **Catatan:** Terdapat batasan **5 percobaan per menit** per alamat IP untuk mencegah penyalahgunaan.

**Tahap 2: Menjawab Pertanyaan Keamanan**
1. Sistem menampilkan **pertanyaan keamanan** yang telah Anda atur sebelumnya
2. Masukkan **jawaban** yang sesuai (tidak peka huruf besar/kecil)
3. Klik **"Verifikasi Jawaban"**

> **Catatan:** Maksimal **3 percobaan**. Setelah 3 kali salah, akun akan **diblokir selama 5 menit**.

**Contoh Pertanyaan Keamanan yang Tersedia:**
- Siapa nama ibu kandung Anda?
- Apa nama sekolah dasar Anda?
- Apa nama hewan peliharaan pertama Anda?
- Di kota mana Anda dilahirkan?
- Apa makanan favorit Anda?
- Siapa nama sahabat masa kecil Anda?

**Tahap 3: Buat Password Baru**
1. Jika jawaban benar, Anda akan diarahkan ke halaman **Reset Password**
2. Masukkan **password baru** (minimal 8 karakter)
3. Masukkan ulang password baru pada field **Konfirmasi Password**
4. Klik **"Ubah Password"**
5. Sistem akan mengarahkan Anda ke halaman login dengan notifikasi sukses

> **Catatan:** Token reset password hanya berlaku selama **10 menit**.

---

### 3.3 Logout

Untuk keluar dari sistem:

1. Klik **nama/avatar Anda** di bagian kanan atas panel admin
2. Pada dropdown yang muncul, klik **"Keluar"**
3. Anda akan diarahkan kembali ke halaman login

---

## 4. PANEL ADMIN (SUPER ADMIN & ADMIN)

Panel Admin menggunakan tampilan **sidebar** (menu samping kiri) yang dapat dilipat (collapse) pada tampilan mobile. Sidebar berisi menu navigasi yang dikelompokkan berdasarkan fungsi.

**Struktur Menu Sidebar Admin:**

```
📊 Dashboard
── Konten ──
📰 Kelola Berita
📄 Laporan Tahunan
── Keuangan ──
💰 Laporan Keuangan
── Media ──
🖼️ Hero Slide
📷 Galeri BUMNag
── Akun ──
👥 Kelola Akun Unit
── Pengaturan ──
🔴 Error Logs (hanya Super Admin)
🏛️ Profil BUMNag
📞 Info Kontak
✉️ Pesan Masuk
```

**Elemen Header (Bagian Atas):**
- Tombol hamburger (mobile) untuk membuka/menutup sidebar
- Judul halaman aktif
- Link **"Lihat Website"** untuk membuka website publik di tab baru
- **User dropdown** berisi: nama, email, ganti password, pertanyaan keamanan, dan tombol keluar

---

### 4.1 Dashboard Admin

**URL:** `https://bumnagmadani.com/admin`

Dashboard adalah halaman utama setelah login yang memberikan **ringkasan statistik** seluruh data di dalam sistem.

#### Kartu Statistik:

| Statistik | Keterangan |
|-----------|------------|
| **Total Berita** | Jumlah seluruh berita (draft + published) |
| **Berita Published** | Jumlah berita yang sudah dipublikasikan |
| **Total Laporan Tahunan** | Jumlah seluruh laporan tahunan |
| **Laporan Published** | Jumlah laporan yang sudah dipublikasikan |
| **Total Laporan Keuangan** | Jumlah pencatatan laporan keuangan bulanan |
| **Pesan Belum Dibaca** | Jumlah pesan dari form Hubungi Kami yang belum dibaca |

#### Daftar Terbaru:

- **5 berita terbaru** — Menampilkan judul, status, dan tanggal dibuat
- **5 laporan tahunan terbaru** — Menampilkan judul, tahun, dan status

#### Grafik Keuangan:

- Grafik pendapatan dan pengeluaran tahun berjalan dalam format bar/line chart bulanan
- Total pendapatan, pengeluaran, dan laba/rugi untuk tahun berjalan

---

### 4.2 Kelola Profil BUMNag

**URL:** `https://bumnagmadani.com/admin/profil`

Menu ini digunakan untuk **mengedit informasi profil organisasi** yang ditampilkan pada halaman Profil publik. Data profil bersifat singleton (hanya ada satu record).

#### Field yang Dapat Diedit:

| Field | Wajib | Batas | Keterangan |
|-------|-------|-------|------------|
| **Nama BUMNag** | Ya | 255 karakter | Nama resmi BUMNag |
| **Nama Nagari** | Ya | 255 karakter | Nama Nagari asal |
| **Alamat** | Ya | 1.000 karakter | Alamat lengkap kantor |
| **Telepon** | Tidak | 50 karakter | Nomor telepon kantor |
| **Email** | Tidak | - | Email resmi organisasi |
| **Website** | Tidak | - | URL website resmi |
| **Sejarah** | Tidak | 10.000 karakter | Narasi sejarah organisasi |
| **Visi** | Tidak | 5.000 karakter | Pernyataan visi organisasi |
| **Misi** | Tidak | 5.000 karakter | Pernyataan misi organisasi |
| **Logo** | Tidak | 5 MB | File gambar JPG/JPEG/PNG |
| **Struktur Organisasi** | Tidak | - | Data dinamis: jabatan, nama, foto per anggota |

#### Kelola Struktur Organisasi:

Struktur organisasi dikelola secara **dinamis** — Anda dapat menambah, mengedit, atau menghapus anggota pengurus:

1. Klik **"Tambah Anggota"** untuk menambahkan baris baru
2. Isi field **Jabatan** (contoh: Direktur, Sekretaris, Bendahara)
3. Isi field **Nama** lengkap
4. Upload **Foto** anggota (maks. 2 MB per foto)
5. Untuk menghapus anggota, klik tombol hapus (ikon X) pada baris yang bersangkutan
6. Klik **"Simpan"** untuk menyimpan seluruh perubahan

---

### 4.3 Kelola Berita

**URL:** `https://bumnagmadani.com/admin/berita`

Menu ini menyediakan **fitur CRUD lengkap** (Create, Read, Update, Delete) untuk mengelola berita/artikel yang dipublikasikan di website.

#### A. Daftar Berita (Index)

Halaman ini menampilkan semua berita yang ada di sistem. Tersedia beberapa fitur filter dan navigasi:

**Filter yang Tersedia:**

| Filter | Opsi | Fungsi |
|--------|------|--------|
| **Status** | Draft, Published, Scheduled | Filter berdasarkan status publikasi |
| **Kategori** | Semua kategori aktif | Filter berdasarkan kategori berita |
| **Featured** | Ya/Tidak | Filter berita unggulan |
| **Pinned** | Ya/Tidak | Filter berita yang dipin |
| **Arsip** | Ya/Tidak | Tampilkan berita yang sudah di-softdelete |
| **Pencarian** | Teks bebas | Cari berdasarkan judul atau konten |

**Kartu Statistik:**
- Total Published, Total Draft, Total Scheduled, Total Views, Total Arsip

**Aksi Tersedia Per Berita:**

| Aksi | Keterangan |
|------|------------|
| **Edit** | Buka form edit berita |
| **Toggle Featured** | Tandai/batalkan sebagai berita unggulan |
| **Toggle Pinned** | Pin/unpin berita (berita di-pin tampil paling atas) |
| **Hapus** | Soft delete (pindahkan ke arsip, bisa di-restore) |
| **Force Delete** | Hapus permanen (tidak bisa dikembalikan) |
| **Restore** | Kembalikan berita dari arsip |

#### B. Tambah Berita Baru

**URL:** `https://bumnagmadani.com/admin/berita/create`

**Langkah-Langkah Menambah Berita:**

**Langkah 1:** Klik tombol **"Tambah Berita"** pada halaman daftar berita.

**Langkah 2:** Isi formulir berita:

| Field | Wajib | Batas | Keterangan |
|-------|-------|-------|------------|
| **Judul Berita** | Ya | 255 karakter | Judul harus menarik dan informatif. Terdapat counter karakter. |
| **Kategori** | Tidak | - | Pilih dari daftar kategori yang tersedia |
| **Tanggal Kegiatan** | Tidak | - | Tanggal peristiwa/kegiatan yang diberitakan |
| **Ringkasan** | Tidak | 1.000 karakter | Ringkasan singkat yang tampil di daftar berita. Jika dikosongkan, sistem otomatis mengambil dari awal konten. |
| **Konten Berita** | Ya | - | Isi artikel menggunakan **editor Summernote** (WYSIWYG) yang mendukung: bold, italic, underline, heading, list, link, gambar, tabel, dan formatting lainnya. |
| **Gambar Utama** | Tidak | 2 MB | File gambar JPG/JPEG/PNG/WebP untuk thumbnail |
| **Galeri Gambar** | Tidak | 2 MB/file | Upload multiple gambar tambahan |
| **Lampiran** | Tidak | 10 MB | File dokumen PDF/DOC/DOCX/XLS/XLSX |
| **Link URL** | Tidak | - | Tautan ke sumber eksternal |
| **Link Text** | Tidak | - | Teks untuk ditampilkan pada link |
| **Status** | Ya | - | **Draft** (belum dipublikasikan) atau **Published** (langsung tayang) |
| **Tanggal Publikasi** | Kondisional | - | Wajib jika berita dijadwalkan |
| **Berita Unggulan** | Tidak | - | Centang untuk menandai sebagai featured |
| **Berita Dipin** | Tidak | - | Centang untuk menampilkan di posisi teratas |
| **Penjadwalan** | Tidak | - | Centang untuk menjadwalkan publikasi pada tanggal tertentu |
| **SEO: Meta Title** | Tidak | 70 karakter | Judul untuk mesin pencari |
| **SEO: Meta Description** | Tidak | 160 karakter | Deskripsi untuk mesin pencari |
| **SEO: Meta Keywords** | Tidak | 255 karakter | Kata kunci untuk mesin pencari |

**Langkah 3:** Klik tombol **"Simpan"** untuk menyimpan berita.

**Langkah 4:** Jika status "Published", berita akan langsung tampil di halaman publik.

#### C. Edit Berita

**URL:** `https://bumnagmadani.com/admin/berita/{id}/edit`

Proses edit sama dengan proses tambah berita, dengan tambahan fitur:
- **Pratinjau gambar** yang sudah diupload sebelumnya
- **Kelola galeri gambar** — hapus gambar individual dari galeri
- **Ganti lampiran** yang sudah ada

#### D. Arsip dan Restore Berita

Ketika berita dihapus (soft delete):
- Berita dipindahkan ke **arsip** dan tidak tampil di halaman publik
- Untuk melihat berita yang diarsipkan, aktifkan filter **"Arsip"** pada daftar berita
- Klik **"Restore"** untuk mengembalikan berita
- Klik **"Hapus Permanen"** untuk menghapus secara permanen (data tidak bisa dikembalikan)

---

### 4.4 Kelola Kategori Berita

**URL:** `https://bumnagmadani.com/admin/kategori-berita`

Menu ini digunakan untuk mengelola **kategori/tag** untuk pengelompokan berita.

#### Field Kategori:

| Field | Wajib | Keterangan |
|-------|-------|------------|
| **Nama** | Ya | Nama kategori (maks. 200 karakter) |
| **Slug** | Otomatis | URL-friendly name, dibuat otomatis dari nama |
| **Deskripsi** | Tidak | Deskripsi singkat kategori |
| **Warna** | Tidak | Kode warna hex (contoh: #86ae5f) untuk label |
| **Icon** | Tidak | Nama icon yang digunakan |
| **Status** | Ya | Aktif atau Tidak Aktif |
| **Urutan** | Ya | Angka urutan tampil (semakin kecil = semakin atas) |

#### Fitur Tambahan:

- **Toggle Status** — Aktifkan/nonaktifkan kategori tanpa menghapusnya
- **Drag & Drop Reorder** — Ubah urutan kategori dengan cara drag and drop
- **Proteksi Hapus** — Kategori yang masih memiliki berita **tidak dapat dihapus**. Pindahkan berita ke kategori lain terlebih dahulu.

---

### 4.5 Kelola Laporan Keuangan

**URL:** `https://bumnagmadani.com/admin/laporan-keuangan`

Menu ini merupakan fitur inti untuk **mencatat pendapatan dan pengeluaran bulanan** per unit usaha dan sub unit usaha.

#### A. Daftar Laporan Keuangan

**Filter yang Tersedia:**

| Filter | Fungsi |
|--------|--------|
| **Tahun** | Filter berdasarkan tahun laporan |
| **Bulan** | Filter berdasarkan bulan laporan |
| **Unit Usaha** | Filter berdasarkan unit usaha tertentu |

**Kartu Rekap:**
Menampilkan total pendapatan, pengeluaran, dan laba/rugi berdasarkan filter yang aktif.

#### B. Tambah Laporan Keuangan

**URL:** `https://bumnagmadani.com/admin/laporan-keuangan/create`

**Langkah-Langkah:**

**Langkah 1:** Klik tombol **"Tambah Laporan"**.

**Langkah 2:** Isi formulir:

| Field | Wajib | Keterangan |
|-------|-------|------------|
| **Bulan** | Ya | Pilih bulan dari dropdown (Januari – Desember) |
| **Tahun** | Ya | Masukkan tahun (2020 – 2099). Bisa tahun lampau untuk pencatatan mundur. |
| **Unit Usaha** | Ya | Pilih unit usaha dari dropdown |
| **Sub Unit** | Kondisional | Muncul otomatis jika unit yang dipilih memiliki sub unit. Wajib dipilih jika tersedia. |
| **Pendapatan (Rp)** | Ya | Nominal pendapatan dalam Rupiah (bilangan bulat, minimal 0) |
| **Pengeluaran (Rp)** | Ya | Nominal pengeluaran dalam Rupiah (bilangan bulat, minimal 0) |
| **Keterangan** | Tidak | Catatan tambahan (maks. 2.000 karakter) |

**Langkah 3:** Perhatikan **Estimasi Laba/Rugi** yang tampil secara otomatis dan real-time saat Anda mengetik nilai pendapatan dan pengeluaran.

**Langkah 4:** Klik **"Simpan Laporan"**.

> **Catatan Penting:** Sistem melakukan pengecekan duplikasi — **tidak dapat menyimpan 2 laporan untuk kombinasi unit + sub unit + bulan + tahun yang sama**. Jika sudah ada, sistem akan menampilkan pesan error.

#### C. Export PDF

Klik tombol **"Export PDF"** pada halaman daftar untuk mengunduh laporan dalam format PDF landscape A4. Laporan dapat difilter berdasarkan bulan, tahun, dan unit sebelum diekspor.

#### D. Activity Log (Riwayat Perubahan)

**URL:** `https://bumnagmadani.com/admin/laporan-keuangan/activity`

Menampilkan **riwayat lengkap** semua perubahan yang dilakukan pada data laporan keuangan, meliputi:
- Siapa yang mengubah
- Apa yang diubah (nilai lama → nilai baru)
- Kapan perubahan dilakukan

---

### 4.6 Kelola Laporan Tahunan

**URL:** `https://bumnagmadani.com/admin/laporan-tahunan`

Menu ini digunakan untuk mengunggah **dokumen laporan tahunan BUMNag** dalam format PDF.

#### A. Daftar Laporan Tahunan

Menampilkan semua laporan tahunan dengan informasi:
- Judul, tahun, status (Draft/Published)
- Jumlah unduhan
- Aksi: Edit, Hapus, Restore (jika diarsipkan)

**Kartu Statistik:**
- Total laporan, Published, Draft, Total unduhan, Diarsipkan

#### B. Tambah Laporan Tahunan

| Field | Wajib | Batas | Keterangan |
|-------|-------|-------|------------|
| **Tahun** | Ya | Unik | Tahun periode laporan (4 digit). Satu tahun hanya boleh 1 laporan. |
| **Judul** | Ya | 255 karakter | Judul dokumen laporan |
| **Deskripsi** | Tidak | 2.000 karakter | Ringkasan isi laporan |
| **Cover Image** | Tidak | 5 MB | Gambar sampul (JPG/JPEG/PNG/WebP) |
| **File Laporan** | Ya (buat baru) | 20 MB | Dokumen PDF laporan tahunan |
| **Status** | Ya | - | Draft atau Published |
| **Tanggal Publikasi** | Tidak | - | Tanggal dipublikasikan |
| **SEO: Meta Title** | Tidak | 70 karakter | Judul untuk mesin pencari |
| **SEO: Meta Description** | Tidak | 160 karakter | Deskripsi untuk mesin pencari |

#### C. Soft Delete dan Restore

Sama seperti berita — laporan yang dihapus masuk ke arsip dan dapat di-restore atau dihapus permanen.

---

### 4.7 Kelola Hero Slide

**URL:** `https://bumnagmadani.com/admin/hero-slide`

Hero Slide adalah **banner/slider utama** yang tampil di halaman beranda. Mendukung gambar dan video.

#### Field Hero Slide:

| Field | Wajib | Batas | Keterangan |
|-------|-------|-------|------------|
| **Judul** | Ya | 255 karakter | Teks judul yang tampil di atas slide |
| **Subjudul** | Tidak | 1.000 karakter | Teks deskripsi di bawah judul |
| **Tipe Media** | Ya | - | Pilih **Gambar** atau **Video** |
| **File Media** | Ya (buat baru) | Gambar: 10 MB, Video: 100 MB | Upload file gambar (JPG/PNG/WebP) atau video (MP4/WebM) |
| **URL Tombol** | Tidak | - | Link tujuan tombol CTA |
| **Teks Tombol** | Tidak | 255 karakter | Teks yang tampil pada tombol CTA |
| **Tampilkan Logo** | Tidak | - | Centang untuk menampilkan logo BUMNag di slide |
| **Urutan** | Ya | - | Angka urutan tampil slide |
| **Status** | Ya | - | Aktif atau Tidak Aktif |

#### Fitur Tambahan:

- **Toggle Status** — Aktifkan/nonaktifkan slide tanpa menghapus
- **Drag & Drop Reorder** — Ubah urutan slide dengan drag and drop
- **Preview** — Pratinjau tampilan slide sebelum disimpan

---

### 4.8 Kelola Galeri BUMNag

**URL:** `https://bumnagmadani.com/admin/galeri-bumnag`

Menu ini digunakan untuk mengelola foto-foto dokumentasi kegiatan BUMNag.

#### Field Galeri:

| Field | Wajib | Batas | Keterangan |
|-------|-------|-------|------------|
| **Judul** | Ya | 255 karakter | Judul/caption foto |
| **Deskripsi** | Tidak | 2.000 karakter | Keterangan foto |
| **Foto** | Ya (buat baru) | 2 MB | File gambar JPG/JPEG/PNG |
| **Status** | Ya | - | Aktif atau Tidak Aktif |

#### Fitur Tambahan:

- **Toggle Status** — Tampilkan/sembunyikan foto tanpa menghapus
- **Drag & Drop Reorder** — Ubah urutan tampil foto
- **Soft Delete & Restore** — Arsipkan foto, kembalikan saat diperlukan
- **Optimasi Otomatis** — Sistem otomatis mengoptimasi ukuran gambar saat upload

---

### 4.9 Kelola Informasi Kontak

**URL:** `https://bumnagmadani.com/admin/kontak-info`

Menu edit-only untuk memperbarui **informasi kontak** yang ditampilkan pada halaman Hubungi Kami dan footer website.

#### Field yang Dapat Diedit:

| Field | Keterangan |
|-------|------------|
| **Telepon** | Nomor telepon kantor BUMNag |
| **Email** | Alamat email resmi |
| **Alamat** | Alamat fisik lengkap (mendukung format teks panjang) |
| **Google Maps Embed** | Kode embed peta Google Maps (mendukung teks panjang) |
| **Facebook** | URL halaman Facebook |
| **Instagram** | URL profil Instagram |
| **YouTube** | URL channel YouTube |
| **TikTok** | URL profil TikTok |
| **Twitter** | URL profil Twitter |
| **WhatsApp** | Nomor WhatsApp (format: 628xxxxxxxxx) |

---

### 4.10 Kelola Pesan Masuk

**URL:** `https://bumnagmadani.com/admin/pesan-kontak`

Menu ini menampilkan semua **pesan yang dikirim masyarakat** melalui formulir Hubungi Kami.

#### Fitur yang Tersedia:

**Filter:**

| Filter | Opsi | Fungsi |
|--------|------|--------|
| **Status** | Belum Dibaca, Sudah Dibaca, Sudah Dibalas | Filter berdasarkan status pesan |
| **Pencarian** | Teks bebas | Cari berdasarkan nama, email, subjek, atau isi pesan |

**Kartu Statistik:**
- Total pesan, Belum dibaca, Sudah dibaca, Sudah dibalas

**Aksi yang Tersedia:**

| Aksi | Keterangan |
|------|------------|
| **Lihat Detail** | Buka detail pesan lengkap. Pesan otomatis ditandai sebagai "sudah dibaca". |
| **Tandai Dibaca** | Tandai pesan sebagai sudah dibaca tanpa membuka detail |
| **Tandai Semua Dibaca** | Tandai seluruh pesan yang belum dibaca sekaligus |
| **Hapus** | Hapus pesan secara permanen |

---

### 4.11 Kelola Akun Pengguna

**URL:** `https://bumnagmadani.com/admin/users`

Menu ini digunakan untuk mengelola **akun operator Unit Usaha dan Sub Unit Usaha**. Admin **tidak dapat** mengedit akun admin lain melalui menu ini.

#### A. Daftar Akun

Menampilkan semua akun Unit dan Sub Unit yang terdaftar, dengan informasi:
- Nama, Email, Role, Unit/Sub Unit yang ditugaskan

#### B. Tambah Akun Baru

| Field | Wajib | Keterangan |
|-------|-------|------------|
| **Nama** | Ya | Nama lengkap pengguna |
| **Email** | Ya | Alamat email unik (digunakan untuk login) |
| **Password** | Ya | Minimal 6 karakter, harus dikonfirmasi |
| **Role** | Ya | Pilih: **Unit Usaha** atau **Sub Unit Usaha** |
| **Unit Usaha** | Ya | Pilih unit usaha yang ditugaskan |
| **Sub Unit** | Kondisional | Muncul jika role = Sub Unit. Dropdown sub unit ditampilkan secara dinamis berdasarkan unit yang dipilih. |

> **Catatan:** Sistem mencegah pembuatan **akun duplikat** — satu unit/sub unit hanya boleh memiliki 1 akun.

#### C. Reset Password Akun

Jika operator lupa password, admin dapat mereset password melalui tombol **"Reset Password"**. Password akan direset ke format: **`awalan_email` + `123`**.

Contoh: Jika email akun adalah `transportasi@bumnagmadani.id`, maka password akan direset menjadi `transportasi123`.

---

### 4.12 Ganti Password

**URL:** `https://bumnagmadani.com/admin/ganti-password`

Fitur ini tersedia di semua role (Admin, Unit, Sub Unit) untuk mengubah password akun masing-masing.

#### Langkah-Langkah:

1. Masukkan **Password Saat Ini** (untuk verifikasi)
2. Masukkan **Password Baru** (minimal 8 karakter)
3. Masukkan **Konfirmasi Password Baru** (harus sama dengan password baru)
4. Klik **"Ubah Password"**

> **Catatan Penting:** Setelah password diubah, Anda akan **otomatis logout** dan harus login kembali dengan password baru.

---

### 4.13 Pertanyaan Keamanan

**URL:** `https://bumnagmadani.com/admin/pertanyaan-keamanan`

Menu ini digunakan untuk **mengatur atau mengubah pertanyaan keamanan** yang digunakan untuk proses pemulihan password (Lupa Password).

#### Langkah-Langkah:

1. Masukkan **Password Saat Ini** (untuk verifikasi identitas)
2. Pilih **Pertanyaan Keamanan** dari daftar dropdown:
   - Siapa nama ibu kandung Anda?
   - Apa nama sekolah dasar Anda?
   - Apa nama hewan peliharaan pertama Anda?
   - Di kota mana Anda dilahirkan?
   - Apa makanan favorit Anda?
   - Siapa nama sahabat masa kecil Anda?
3. Masukkan **Jawaban** (2 – 200 karakter)
4. Klik **"Simpan"**

> **Catatan:** Jawaban disimpan dalam format huruf kecil (case-insensitive), sehingga "Jakarta", "jakarta", dan "JAKARTA" dianggap sama.

> **⚠️ PERINGATAN:** Pastikan Anda **mengingat jawaban** pertanyaan keamanan. Jika lupa jawaban DAN lupa password, akun hanya dapat dipulihkan oleh Super Admin.

---

### 4.14 Error Logs (Khusus Super Admin)

**URL:** `https://bumnagmadani.com/admin/error-logs`

Menu ini **hanya tersedia untuk Super Admin** dan digunakan untuk memantau **error/kesalahan teknis** yang terjadi di website.

#### Fitur:

**Filter:**

| Filter | Fungsi |
|--------|--------|
| **Level** | Pilih level error: emergency, alert, critical, error, warning, notice, info, debug |
| **Rentang Tanggal** | Filter berdasarkan tanggal mulai dan tanggal akhir |
| **Pencarian** | Cari berdasarkan pesan error, exception class, URL, atau nama file |
| **Status** | Filter hanya yang belum dibaca |

**Kartu Statistik:**
- Total error, Belum dibaca, Error hari ini, Error minggu ini

**Aksi yang Tersedia:**

| Aksi | Keterangan |
|------|------------|
| **Lihat Detail** | Informasi lengkap error: level, pesan, file, line, stack trace, URL, IP, dan lain-lain |
| **Tandai Semua Dibaca** | Tandai seluruh error sebagai sudah dibaca |
| **Hapus** | Hapus satu error |
| **Hapus Semua** | Hapus seluruh log error |

---

## 5. PANEL UNIT USAHA

Panel Unit Usaha ditujukan untuk **operator yang ditugaskan mengelola laporan keuangan satu unit usaha** tertentu. Operator unit memiliki akses terbatas dibandingkan admin.

### 5.1 Dashboard Unit

**URL:** `https://bumnagmadani.com/unit`

Dashboard unit menampilkan:

| Elemen | Keterangan |
|--------|------------|
| **Statistik Keuangan** | Total pendapatan, pengeluaran, dan laba/rugi unit untuk tahun berjalan |
| **Tabel Per Sub Unit** | Breakdown keuangan per sub unit (jika unit memiliki sub unit) |
| **Laporan Langsung** | Laporan yang diinput langsung di level unit (tanpa sub unit) |
| **Grafik Bulanan** | Chart pendapatan dan pengeluaran per bulan selama setahun |
| **10 Laporan Terbaru** | Daftar 10 laporan keuangan yang paling baru diinput |

---

### 5.2 Kelola Laporan Keuangan Unit

**URL:** `https://bumnagmadani.com/unit/laporan-keuangan`

#### Fitur:

- **Melihat** semua laporan milik unit (termasuk laporan sub unit di bawahnya)
- **Menambah** laporan baru (hanya untuk unit secara langsung, tanpa sub unit)
- **Mengedit** laporan yang **diinput oleh operator unit sendiri**
- **Menghapus** laporan yang **diinput oleh operator unit sendiri**

**Filter:** Tahun, Bulan, Sub Unit

#### Batasan Penting:

| Situasi | Aksi yang Dapat Dilakukan |
|---------|---------------------------|
| Laporan diinput oleh **operator sendiri** | ✅ Lihat, ✅ Edit, ✅ Hapus |
| Laporan diinput oleh **Admin** | ✅ Lihat, ❌ Edit, ❌ Hapus |
| Laporan milik **sub unit** di bawahnya | ✅ Lihat, ❌ Edit, ❌ Hapus |

> **Catatan:** Jika admin sudah menginput data untuk periode/unit tertentu, sistem akan menampilkan pesan: *"Data sudah diinputkan oleh Admin. Anda hanya dapat melihat data ini."*

---

## 6. PANEL SUB UNIT USAHA

Panel Sub Unit memiliki akses **paling terbatas**, hanya untuk menginput laporan keuangan sub unit yang ditugaskan.

### 6.1 Dashboard Sub Unit

**URL:** `https://bumnagmadani.com/sub-unit`

Dashboard sub unit menampilkan:
- Statistik keuangan sub unit untuk tahun berjalan
- Grafik pendapatan dan pengeluaran bulanan
- 10 laporan terbaru

---

### 6.2 Kelola Laporan Keuangan Sub Unit

**URL:** `https://bumnagmadani.com/sub-unit/laporan-keuangan`

#### Fitur dan Batasan:

- **Melihat** hanya laporan milik sub unit sendiri
- **Menambah** laporan baru untuk sub unit sendiri
- **Mengedit** laporan yang **diinput oleh diri sendiri**
- **Menghapus** laporan yang **diinput oleh diri sendiri**

| Situasi | Aksi |
|---------|------|
| Laporan diinput oleh **diri sendiri** | ✅ Lihat, ✅ Edit, ✅ Hapus |
| Laporan diinput oleh **Admin** | ✅ Lihat, ❌ Edit, ❌ Hapus |
| Laporan diinput oleh **Operator Unit** | ✅ Lihat, ❌ Edit, ❌ Hapus |

> **Catatan:** Sistem secara spesifik menampilkan informasi siapa yang menginput data sehingga operator tahu mengapa tidak dapat mengedit.

---

## 7. CONTOH ALUR PENGGUNAAN LENGKAP

Bagian ini memberikan **panduan langkah demi langkah** untuk skenario penggunaan umum, mulai dari login hingga menyelesaikan tugas tertentu.

---

### 7.1 Alur Login dan Menambahkan Berita

**Skenario:** Admin ingin mempublikasikan berita baru tentang kegiatan BUMNag.

**Langkah 1 — Buka Halaman Login:**
```
Buka browser → Ketik: https://bumnagmadani.com/login → Enter
```

**Langkah 2 — Masukkan Kredensial:**
```
Email    : admin@bumnagmadani.id
Password : [password Anda]
Centang  : ☑ Ingat Saya (opsional)
Klik     : [Masuk]
```

**Langkah 3 — Navigasi ke Menu Berita:**
```
Sidebar kiri → Klik "Kelola Berita" (di bawah section "Konten")
```

**Langkah 4 — Buka Form Tambah Berita:**
```
Klik tombol [+ Tambah Berita] di pojok kanan atas halaman
```

**Langkah 5 — Isi Informasi Berita:**
```
Judul           : BUMNag Madani Gelar Rapat Kerja Tahunan 2026
Kategori        : Pilih "Kegiatan" (atau kategori yang sesuai)
Tanggal Kegiatan: 19/02/2026
Ringkasan       : BUMNag Madani Lubuk Malako menggelar rapat kerja tahunan
                  yang membahas program kerja dan target capaian tahun 2026.
```

**Langkah 6 — Tulis Konten Berita:**
```
Gunakan editor Summernote untuk menulis isi berita:
- Klik Bold (B) untuk teks tebal
- Klik Italic (I) untuk teks miring
- Klik ikon gambar untuk menyisipkan gambar ke dalam konten
- Klik ikon link untuk menambahkan hyperlink
```

**Langkah 7 — Upload Gambar Utama:**
```
Klik area upload "Gambar Utama" → Pilih file gambar dari komputer
(Format: JPG/PNG/WebP, Ukuran maks: 2 MB)
```

**Langkah 8 — Atur Status Publikasi:**
```
Status : Pilih "Published" (jika ingin langsung tayang)
         Pilih "Draft" (jika masih ingin diedit nanti)
```

**Langkah 9 — Simpan:**
```
Klik tombol [Simpan] di bagian bawah form
```

**Langkah 10 — Verifikasi:**
```
Buka tab baru → Ketik: https://bumnagmadani.com/berita
Pastikan berita baru tampil di halaman publik (jika status Published)
```

---

### 7.2 Alur Menambahkan Laporan Keuangan Bulanan

**Skenario:** Admin mencatat pendapatan dan pengeluaran Unit Jasa Transportasi untuk bulan Januari 2026.

**Langkah 1 — Login ke Panel Admin:**
```
Buka https://bumnagmadani.com/login → Masuk dengan akun admin
```

**Langkah 2 — Navigasi ke Laporan Keuangan:**
```
Sidebar kiri → Klik "Laporan Keuangan" (di bawah section "Keuangan")
```

**Langkah 3 — Buka Form Tambah:**
```
Klik tombol [+ Tambah Laporan]
```

**Langkah 4 — Isi Data Laporan:**
```
Bulan        : Pilih "Januari"
Tahun        : 2026
Unit Usaha   : Pilih "Jasa Transportasi"
Sub Unit     : Pilih sub unit (jika muncul), atau biarkan kosong
Pendapatan   : 15000000  (Rp 15.000.000)
Pengeluaran  : 8500000   (Rp 8.500.000)
Keterangan   : Pendapatan dari sewa kendaraan operasional.
               Pengeluaran meliputi BBM, perawatan kendaraan, dan gaji supir.
```

**Langkah 5 — Cek Estimasi Laba/Rugi:**
```
Sistem otomatis menampilkan:
"Estimasi Laba/Rugi: Rp 6.500.000" (warna hijau = laba)

Pastikan angka sesuai sebelum menyimpan.
```

**Langkah 6 — Simpan:**
```
Klik tombol [Simpan Laporan]
```

**Langkah 7 — Verifikasi di Transparansi Publik:**
```
Buka https://bumnagmadani.com/transparansi → Pilih tahun 2026
Data Januari untuk Unit Jasa Transportasi harus sudah tampil.
```

---

### 7.3 Alur Upload Laporan Tahunan

**Skenario:** Admin mengunggah dokumen Laporan Tahunan BUMNag tahun 2025.

**Langkah 1 — Navigasi:**
```
Sidebar kiri → Klik "Laporan Tahunan" (di bawah section "Konten")
```

**Langkah 2 — Buka Form Tambah:**
```
Klik tombol [+ Tambah Laporan]
```

**Langkah 3 — Isi Data:**
```
Tahun             : 2025
Judul             : Laporan Tahunan BUMNag Madani Lubuk Malako Tahun 2025
Deskripsi         : Dokumen laporan tahunan resmi yang memuat kinerja keuangan,
                    program kerja, dan capaian BUMNag Madani selama tahun 2025.
Cover Image       : Upload gambar sampul (maks. 5 MB)
File Laporan      : Upload file PDF laporan (maks. 20 MB)
Status            : Published
Tanggal Publikasi : 19/02/2026
```

**Langkah 4 — Simpan:**
```
Klik [Simpan]
```

**Langkah 5 — Verifikasi:**
```
Buka https://bumnagmadani.com/laporan-tahunan
Dokumen harus tampil dan bisa diunduh oleh masyarakat.
```

---

### 7.4 Alur Mengelola Hero Slide

**Skenario:** Admin ingin menambahkan banner baru pada slider halaman beranda.

**Langkah 1 — Navigasi:**
```
Sidebar kiri → Klik "Hero Slide" (di bawah section "Media")
```

**Langkah 2 — Buka Form Tambah:**
```
Klik tombol [+ Tambah Slide]
```

**Langkah 3 — Isi Data Slide:**
```
Judul           : Selamat Datang di BUMNag Madani
Subjudul        : Mengelola aset nagari untuk kesejahteraan masyarakat
                  Lubuk Malako
Tipe Media      : Pilih "Gambar"
File Media      : Upload gambar banner (resolusi disarankan: 1920x1080 px)
URL Tombol      : /profil
Teks Tombol     : Lihat Profil Kami
Tampilkan Logo  : ☑ (centang jika ingin logo tampil di slide)
Urutan          : 1 (angka paling kecil = tampil pertama)
Status          : Aktif
```

**Langkah 4 — Simpan dan Cek:**
```
Klik [Simpan]
Buka https://bumnagmadani.com → Slide baru harus tampil di banner utama
```

---

### 7.5 Alur Unit Usaha Melaporkan Keuangan

**Skenario:** Operator Unit Jasa Transportasi menginput laporan keuangan bulanan.

**Langkah 1 — Login:**
```
Buka https://bumnagmadani.com/login
Email    : transportasi@bumnagmadani.id
Password : [password]
Klik     : [Masuk]
→ Otomatis diarahkan ke Dashboard Unit
```

**Langkah 2 — Cek Dashboard:**
```
Perhatikan statistik keuangan unit di dashboard.
Grafik bulanan menampilkan pendapatan dan pengeluaran.
```

**Langkah 3 — Navigasi ke Input Laporan:**
```
Sidebar kiri → Klik "Laporan Keuangan"
Klik tombol [+ Tambah Laporan]
```

**Langkah 4 — Isi Data:**
```
Bulan        : Pilih bulan yang akan dilaporkan
Tahun        : Tahun yang sesuai
Pendapatan   : Masukkan total pendapatan unit bulan ini
Pengeluaran  : Masukkan total pengeluaran unit bulan ini
Keterangan   : Catatan tambahan jika diperlukan
```

> **Catatan:** Unit Usaha **tidak perlu memilih unit** karena sistem otomatis mendeteksi unit yang ditugaskan pada akun.

**Langkah 5 — Simpan dan Verifikasi:**
```
Klik [Simpan Laporan]
Laporan akan langsung tampil di daftar dan masuk ke rekap keuangan keseluruhan.
```

---

### 7.6 Alur Melihat dan Membalas Pesan Masuk

**Skenario:** Admin memeriksa pesan baru yang masuk dari masyarakat.

**Langkah 1 — Cek Notifikasi:**
```
Perhatikan badge angka merah di menu "Pesan Masuk" pada sidebar.
Angka menunjukkan jumlah pesan yang belum dibaca.
```

**Langkah 2 — Buka Daftar Pesan:**
```
Sidebar kiri → Klik "Pesan Masuk" (di bawah section "Pengaturan")
```

**Langkah 3 — Filter Status:**
```
Klik filter "Belum Dibaca" untuk melihat hanya pesan baru.
```

**Langkah 4 — Buka Detail Pesan:**
```
Klik pada baris pesan yang ingin dibaca.
→ Halaman detail menampilkan: nama pengirim, email, organisasi,
  subjek, isi pesan, dan waktu pengiriman.
→ Pesan otomatis ditandai sebagai "sudah dibaca".
```

**Langkah 5 — Tindak Lanjut:**
```
Gunakan informasi kontak pengirim (email) untuk membalas
pesan melalui email/WhatsApp secara langsung.
```

---

### 7.7 Alur Pengunjung Mengirim Pesan

**Skenario:** Warga masyarakat ingin menyampaikan pertanyaan kepada BUMNag.

**Langkah 1 — Buka Halaman Hubungi Kami:**
```
Dari halaman mana saja → Klik menu "Hubungi Kami" di navbar atas
Atau ketik langsung: https://bumnagmadani.com/hubungi-kami
```

**Langkah 2 — Isi Formulir Kontak:**
```
Nama       : Ahmad Syahrial
Organisasi : Kelompok Tani Makmur Jaya (opsional)
Email      : ahmad.syahrial@gmail.com
Subjek     : Pertanyaan Mengenai Program Simpan Pinjam
Pesan      : Assalamualaikum, saya ingin bertanya mengenai
             syarat dan ketentuan program simpan pinjam
             BUMNag Madani. Mohon informasinya. Terima kasih.
```

**Langkah 3 — Kirim:**
```
Klik tombol [Kirim Pesan]
→ Muncul notifikasi hijau: "Pesan Anda berhasil dikirim!"
```

**Langkah 4 — Tunggu Balasan:**
```
Tim admin BUMNag akan menerima pesan dan menghubungi
melalui email yang Anda cantumkan.
```

---

## 8. PANDUAN KEAMANAN AKUN

Berikut adalah **praktik keamanan terbaik** yang harus diikuti oleh seluruh pengguna sistem:

### 8.1 Password yang Kuat

| Kriteria | Rekomendasi |
|----------|-------------|
| **Panjang minimal** | 8 karakter (wajib sistem), disarankan 12+ karakter |
| **Kombinasi karakter** | Huruf besar + huruf kecil + angka + simbol |
| **Contoh password kuat** | `BuMn@g2026!Aman` |
| **Hindari** | Nama, tanggal lahir, "password123", "admin123" |

### 8.2 Keamanan Login

- **Segera ganti password default** setelah menerima akun baru
- **Jangan berbagi password** dengan orang lain
- **Gunakan fitur "Ingat Saya"** hanya di perangkat pribadi yang aman
- **Selalu logout** setelah selesai menggunakan sistem, terutama di perangkat bersama
- **Jangan simpan password** di browser umum/perangkat bersama

### 8.3 Pertanyaan Keamanan

- **SEGERA atur pertanyaan keamanan** setelah login pertama kali (Menu: Pertanyaan Keamanan)
- Pilih pertanyaan yang **hanya Anda yang tahu jawabannya**
- **Jangan gunakan jawaban yang mudah ditebak** (seperti "Indonesia" untuk kota lahir)
- **Ingat jawaban Anda** — jika lupa pertanyaan keamanan DAN password, diperlukan bantuan Super Admin
- Jawaban bersifat **case-insensitive** (tidak peka huruf besar/kecil)

### 8.4 Akses Sistem

- Akses website **hanya melalui URL resmi**: `https://bumnagmadani.com`
- **Pastikan URL menggunakan HTTPS** (gembok hijau di browser)
- **Jangan klik link mencurigakan** yang meminta login ke URL yang bukan domain resmi
- Laporkan aktivitas mencurigakan kepada Super Admin

---

## 9. PANDUAN UNGGAH FILE DAN MEDIA

### 9.1 Ketentuan Upload Gambar

| Konteks Upload | Format | Ukuran Maks | Resolusi Disarankan |
|----------------|--------|-------------|---------------------|
| **Logo BUMNag** | JPG, JPEG, PNG | 5 MB | 500 x 500 px (persegi) |
| **Gambar Berita** | JPG, JPEG, PNG, WebP | 2 MB | 1200 x 800 px (landscape) |
| **Galeri Berita** | JPG, JPEG, PNG, WebP | 2 MB per file | 1200 x 800 px |
| **Hero Slide (Gambar)** | JPG, PNG, WebP | 10 MB | 1920 x 1080 px (Full HD) |
| **Cover Laporan Tahunan** | JPG, JPEG, PNG, WebP | 5 MB | 800 x 1100 px (portrait) |
| **Galeri BUMNag** | JPG, JPEG, PNG | 2 MB | 1200 x 800 px |
| **Foto Struktur Organisasi** | JPG, JPEG, PNG | 2 MB per foto | 500 x 500 px (persegi) |

### 9.2 Ketentuan Upload Dokumen

| Konteks Upload | Format | Ukuran Maks |
|----------------|--------|-------------|
| **Laporan Tahunan (PDF)** | PDF | 20 MB |
| **Lampiran Berita** | PDF, DOC, DOCX, XLS, XLSX | 10 MB |

### 9.3 Ketentuan Upload Video

| Konteks Upload | Format | Ukuran Maks |
|----------------|--------|-------------|
| **Hero Slide (Video)** | MP4, WebM | 100 MB |

### 9.4 Tips Upload:

1. **Kompres gambar** sebelum upload menggunakan tools online (seperti TinyPNG) untuk mempercepat loading website
2. **Gunakan format WebP** jika memungkinkan — ukuran file lebih kecil dengan kualitas yang sama
3. **Beri nama file yang deskriptif** sebelum upload (contoh: `rapat-kerja-2026.jpg` bukan `IMG_20260219.jpg`)
4. **Pastikan koneksi internet stabil** saat mengupload file berukuran besar
5. **Video untuk Hero Slide** sebaiknya berdurasi **10-30 detik** dan dioptimasi untuk web

---

## 10. FAQ (PERTANYAAN YANG SERING DIAJUKAN)

### Umum

**T: Siapa yang dapat melihat website ini?**
J: Website publik (halaman beranda, profil, berita, statistik, transparansi, laporan tahunan, galeri, dan hubungi kami) dapat diakses oleh **siapa saja** tanpa perlu login.

**T: Bagaimana cara mengakses panel admin?**
J: Kunjungi `https://bumnagmadani.com/login` dan masuk dengan akun yang telah diberikan oleh administrator.

**T: Apakah website ini responsif (bisa dibuka di HP)?**
J: Ya, seluruh halaman website (publik dan admin) dirancang responsif dan dapat diakses dari desktop, tablet, maupun smartphone.

### Login & Password

**T: Saya lupa password, bagaimana cara resetnya?**
J: Gunakan fitur **Lupa Password** di halaman login. Anda perlu menjawab pertanyaan keamanan yang telah Anda atur sebelumnya. Lihat detail di [Bagian 3.2](#32-lupa-password).

**T: Saya belum mengatur pertanyaan keamanan, apakah bisa reset password?**
J: Tidak bisa melalui fitur Lupa Password. Hubungi **Super Admin** untuk mereset password secara manual.

**T: Password saya direset oleh admin, apa password barunya?**
J: Password default setelah reset adalah **awalan email + "123"**. Contoh: email `transportasi@bumnagmadani.id` → password: `transportasi123`. **Segera ganti** setelah login.

### Berita

**T: Berita yang saya buat tidak muncul di halaman publik, kenapa?**
J: Pastikan **status berita** sudah diubah ke **"Published"**. Berita dengan status "Draft" tidak akan ditampilkan di halaman publik.

**T: Bisakah saya mengembalikan berita yang sudah dihapus?**
J: Ya, jika menggunakan tombol **Hapus** biasa (soft delete), berita masuk ke arsip dan dapat di-**Restore**. Jika sudah menggunakan **Hapus Permanen** (force delete), data tidak dapat dikembalikan.

**T: Berapa ukuran maksimal gambar untuk berita?**
J: Gambar utama dan galeri berita masing-masing maksimal **2 MB** per file. Format yang didukung: JPG, JPEG, PNG, dan WebP.

### Laporan Keuangan

**T: Saya tidak bisa mengedit laporan keuangan, kenapa?**
J: Kemungkinan laporan tersebut **diinput oleh pengguna dengan role lebih tinggi** (misalnya Admin). Operator Unit dan Sub Unit hanya dapat mengedit laporan yang mereka input sendiri.

**T: Saya mendapat error "duplikat periode", apa maksudnya?**
J: Sudah ada laporan untuk kombinasi **unit + sub unit + bulan + tahun** yang sama. Setiap kombinasi hanya boleh memiliki 1 laporan. Edit laporan yang sudah ada jika ingin mengubah data.

**T: Bagaimana cara melihat riwayat perubahan laporan keuangan?**
J: Buka menu **Laporan Keuangan** → klik tombol **"Activity Log"** untuk melihat seluruh riwayat perubahan data.

### Teknis

**T: Website menampilkan error 500 / Internal Server Error, apa yang harus dilakukan?**
J: Laporkan kepada tim teknis/Super Admin. Super Admin dapat memeriksa detail error melalui menu **Error Logs** di panel admin.

**T: Gambar yang saya upload tidak tampil, kenapa?**
J: Periksa apakah: (1) Format file sesuai ketentuan, (2) Ukuran file tidak melebihi batas, (3) Koneksi internet stabil saat mengupload. Jika masih bermasalah, coba upload ulang.

---

## 11. INFORMASI KONTAK DUKUNGAN TEKNIS

Jika Anda mengalami kendala teknis atau membutuhkan bantuan lebih lanjut, silakan hubungi:

| Kontak | Keterangan |
|--------|------------|
| **Super Admin** | Hubungi melalui internal organisasi |
| **Tim Pengembang** | Lihat halaman Tim Pengembang: `https://bumnagmadani.com/tim-pengembang` |
| **Repository** | https://github.com/MIkhsanPasaribu/bumnag-madani-lubukmalako |

---

<p align="center">
  <strong>— Akhir Dokumen —</strong><br><br>
  <em>Buku Panduan Penggunaan Website BUMNag Madani Lubuk Malako</em><br>
  <em>Versi 1.0 — 19 Februari 2026</em><br>
  <em>Hak Cipta © 2026 BUMNag Madani Lubuk Malako. Seluruh Hak Dilindungi.</em>
</p>
