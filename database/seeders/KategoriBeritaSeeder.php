<?php

namespace Database\Seeders;

use App\Models\KategoriBerita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk data kategori berita default
 */
class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Umum',
                'slug' => 'umum',
                'deskripsi' => 'Berita dan informasi umum seputar BUMNag Madani',
                'warna' => '#86ae5f', // Primary color
                'icon' => 'newspaper',
                'is_active' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'Ekonomi',
                'slug' => 'ekonomi',
                'deskripsi' => 'Berita terkait kegiatan ekonomi dan usaha BUMNag',
                'warna' => '#3b82f6', // Blue
                'icon' => 'chart-bar',
                'is_active' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Program',
                'slug' => 'program',
                'deskripsi' => 'Informasi program-program BUMNag untuk masyarakat',
                'warna' => '#8b5cf6', // Purple
                'icon' => 'clipboard-list',
                'is_active' => true,
                'urutan' => 3,
            ],
            [
                'nama' => 'Kegiatan',
                'slug' => 'kegiatan',
                'deskripsi' => 'Dokumentasi kegiatan dan acara BUMNag',
                'warna' => '#f59e0b', // Amber
                'icon' => 'calendar',
                'is_active' => true,
                'urutan' => 4,
            ],
            [
                'nama' => 'Pertanian',
                'slug' => 'pertanian',
                'deskripsi' => 'Berita seputar bidang pertanian dan perkebunan',
                'warna' => '#10b981', // Emerald
                'icon' => 'sun',
                'is_active' => true,
                'urutan' => 5,
            ],
            [
                'nama' => 'Peternakan',
                'slug' => 'peternakan',
                'deskripsi' => 'Berita seputar bidang peternakan',
                'warna' => '#ef4444', // Red
                'icon' => 'sparkles',
                'is_active' => true,
                'urutan' => 6,
            ],
            [
                'nama' => 'Wisata',
                'slug' => 'wisata',
                'deskripsi' => 'Berita seputar potensi wisata nagari',
                'warna' => '#06b6d4', // Cyan
                'icon' => 'map',
                'is_active' => true,
                'urutan' => 7,
            ],
            [
                'nama' => 'Sosial',
                'slug' => 'sosial',
                'deskripsi' => 'Berita kegiatan sosial dan kemasyarakatan',
                'warna' => '#ec4899', // Pink
                'icon' => 'heart',
                'is_active' => true,
                'urutan' => 8,
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBerita::updateOrCreate(
                ['slug' => $kategori['slug']],
                $kategori
            );
        }

        $this->command->info('Kategori berita berhasil di-seed: ' . count($kategoris) . ' kategori');
    }
}
