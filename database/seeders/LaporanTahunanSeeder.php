<?php

namespace Database\Seeders;

use App\Models\LaporanTahunan;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk data sample Laporan Tahunan BUMNag
 */
class LaporanTahunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        
        $laporanData = [
            [
                'tahun' => 2025,
                'judul' => 'Laporan Tahunan BUMNag Madani Lubuk Malako 2025',
                'deskripsi' => 'Laporan pertanggungjawaban dan kinerja BUMNag Madani Lubuk Malako untuk tahun anggaran 2025. Laporan ini mencakup ringkasan keuangan, pencapaian program, dan rencana pengembangan.',
                'status' => 'published',
                'download_count' => 45,
                'meta_title' => 'Laporan Tahunan BUMNag 2025',
                'meta_description' => 'Download laporan tahunan BUMNag Madani Lubuk Malako tahun 2025. Transparansi pengelolaan keuangan dan program.',
            ],
            [
                'tahun' => 2024,
                'judul' => 'Laporan Tahunan BUMNag Madani Lubuk Malako 2024',
                'deskripsi' => 'Laporan kinerja dan pertanggungjawaban BUMNag Madani tahun 2024. Memuat informasi mengenai pendapatan, pengeluaran, program kerja, dan evaluasi tahunan.',
                'status' => 'published',
                'download_count' => 128,
                'meta_title' => 'Laporan Tahunan BUMNag 2024',
                'meta_description' => 'Download laporan tahunan BUMNag Madani Lubuk Malako tahun 2024. Transparansi dan akuntabilitas pengelolaan BUMNag.',
            ],
            [
                'tahun' => 2023,
                'judul' => 'Laporan Tahunan BUMNag Madani Lubuk Malako 2023',
                'deskripsi' => 'Dokumen pertanggungjawaban tahunan BUMNag Madani tahun 2023. Berisi laporan keuangan, capaian program, dan rencana strategis kedepan.',
                'status' => 'published',
                'download_count' => 256,
                'meta_title' => 'Laporan Tahunan BUMNag 2023',
                'meta_description' => 'Laporan tahunan BUMNag Madani Lubuk Malako 2023. Lihat kinerja dan transparansi pengelolaan keuangan BUMNag.',
            ],
        ];

        foreach ($laporanData as $data) {
            LaporanTahunan::create([
                ...$data,
                'uploaded_by' => $admin?->id,
                'tanggal_publikasi' => now()->subMonths(12 - ($data['tahun'] - 2023) * 12)->startOfYear()->addMonth(),
            ]);
        }
    }
}
