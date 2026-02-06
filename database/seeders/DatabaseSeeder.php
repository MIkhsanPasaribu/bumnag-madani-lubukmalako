<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Main seeder untuk BUMNag Madani Lubuk Malako
 * Menjalankan semua seeder dalam urutan yang benar
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder dalam urutan yang benar (users dulu, baru konten)
        $this->call([
            AdminUserSeeder::class,
            ProfilBumnagSeeder::class,
            KategoriBeritaSeeder::class,  // Kategori berita dulu sebelum berita
            BeritaSeeder::class,
            LaporanTahunanSeeder::class,
            KategoriTransaksiSeeder::class,  // Kategori dulu sebelum transaksi
            TransaksiKasSeeder::class,
            KontakInfoSeeder::class,
        ]);
    }
}
