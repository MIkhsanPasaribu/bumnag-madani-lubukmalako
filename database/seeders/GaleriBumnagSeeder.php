<?php

namespace Database\Seeders;

use App\Models\GaleriBumnag;
use Illuminate\Database\Seeder;

class GaleriBumnagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeri = [
            [
                'judul' => 'Tim BUMNag Madani Lubuk Malako 2026',
                'deskripsi' => 'Foto bersama seluruh anggota dan pejabat BUMNag Madani Lubuk Malako periode 2026',
                'foto' => 'sample-team-1.jpg',
                'urutan' => 1,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
            [
                'judul' => 'Rapat Koordinasi BUMNag',
                'deskripsi' => 'Rapat koordinasi bulanan membahas program kerja dan evaluasi kinerja',
                'foto' => 'sample-team-2.jpg',
                'urutan' => 2,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
            [
                'judul' => 'Tim Inti BUMNag Madani',
                'deskripsi' => 'Foto formal tim inti BUMNag Madani Lubuk Malako',
                'foto' => 'sample-team-3.jpg',
                'urutan' => 3,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
            [
                'judul' => 'Kegiatan Sosial BUMNag',
                'deskripsi' => 'Kegiatan sosial kemasyarakatan yang diadakan oleh BUMNag Madani',
                'foto' => 'sample-team-4.jpg',
                'urutan' => 4,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
            [
                'judul' => 'Workshop Pengembangan SDM',
                'deskripsi' => 'Kegiatan workshop untuk pengembangan sumber daya manusia BUMNag',
                'foto' => 'sample-workshop.jpg',
                'urutan' => 5,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
            [
                'judul' => 'Launching Program BUMNag',
                'deskripsi' => 'Peluncuran program unggulan BUMNag Madani untuk masyarakat',
                'foto' => 'sample-launching.jpg',
                'urutan' => 6,
                'status' => 'aktif',
                'uploaded_by' => 1,
            ],
        ];

        foreach ($galeri as $item) {
            GaleriBumnag::create($item);
        }
    }
}
