<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    /**
     * Seed hero slides dengan data sample
     */
    public function run(): void
    {
        $adminId = User::where('role', 'super_admin')->first()?->id
            ?? User::where('role', 'admin')->first()?->id
            ?? 1;

        $slides = [
            [
                'judul' => 'Selamat Datang di BUMNag Madani',
                'subjudul' => 'Badan Usaha Milik Nagari yang berkomitmen untuk mengembangkan ekonomi nagari dan meningkatkan kesejahteraan masyarakat Lubuk Malako.',
                'tipe_media' => 'gambar',
                'media_path' => 'default_hero_1.jpg',
                'url_tombol' => '/profil',
                'teks_tombol' => 'Tentang Kami',
                'urutan' => 1,
                'status' => 'aktif',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Transparansi Keuangan',
                'subjudul' => 'Pengelolaan keuangan yang transparan dan akuntabel untuk kemajuan nagari.',
                'tipe_media' => 'gambar',
                'media_path' => 'default_hero_2.jpg',
                'url_tombol' => '/transparansi',
                'teks_tombol' => 'Lihat Laporan',
                'urutan' => 2,
                'status' => 'aktif',
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Membangun Ekonomi Nagari',
                'subjudul' => 'Unit usaha yang berkualitas untuk kesejahteraan masyarakat Lubuk Malako.',
                'tipe_media' => 'gambar',
                'media_path' => 'default_hero_3.jpg',
                'url_tombol' => '/berita',
                'teks_tombol' => 'Berita Terbaru',
                'urutan' => 3,
                'status' => 'aktif',
                'created_by' => $adminId,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['judul' => $slide['judul']],
                $slide
            );
        }
    }
}
