<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\LaporanKeuangan;
use App\Models\Pengumuman;
use App\Models\ProfilBumnag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin BUMNag',
            'email' => 'admin@bumnagmadani.id',
        ]);

        ProfilBumnag::create([
            'nama_bumnag' => 'BUMNag Madani Lubuk Malako',
            'sejarah' => 'BUMNag Madani Lubuk Malako didirikan pada tahun 2020 dengan tujuan untuk memajukan perekonomian masyarakat nagari melalui pengelolaan usaha yang profesional dan berkelanjutan. Sebagai badan usaha milik nagari, BUMNag berkomitmen untuk memberikan kontribusi nyata bagi kesejahteraan masyarakat Lubuk Malako. Berdiri atas dasar semangat gotong royong dan kemandirian ekonomi, BUMNag Madani telah menjadi motor penggerak ekonomi lokal yang mengelola berbagai unit usaha strategis.',
            'visi' => 'Menjadi Badan Usaha Milik Nagari yang profesional, mandiri, dan berkontribusi nyata dalam meningkatkan kesejahteraan masyarakat Lubuk Malako.',
            'misi' => "1. Mengelola usaha secara profesional, transparan, dan akuntabel\n2. Meningkatkan pendapatan asli nagari melalui diversifikasi usaha\n3. Memberdayakan potensi ekonomi lokal dan sumber daya masyarakat\n4. Memberikan pelayanan terbaik kepada masyarakat\n5. Membangun kemitraan strategis dengan berbagai pihak",
            'struktur_organisasi' => "Direktur: H. Ahmad Yani, S.E.\nSekretaris: Dewi Sartika, S.Pd.\nBendahara: Ir. Budi Santoso\nKepala Unit Usaha: Rini Wulandari, S.M.",
            'alamat' => 'Jl. Raya Lubuk Malako No. 123, Kecamatan Lubuk Malako, Kabupaten Solok Selatan, Sumatera Barat',
            'telepon' => '(0755) 123456',
            'email' => 'info@bumnagmadani.id',
            'website' => 'https://bumnagmadani.id',
            'tahun_berdiri' => 2020,
        ]);

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        foreach ([2023, 2024, 2025] as $tahun) {
            foreach ($bulanList as $index => $bulan) {
                if ($tahun == 2025 && $index >= 1) break;
                
                $pendapatan = rand(50000000, 150000000);
                $pengeluaran = rand(30000000, 100000000);
                
                LaporanKeuangan::create([
                    'periode' => "Laporan Bulanan $bulan $tahun",
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'pendapatan' => $pendapatan,
                    'pengeluaran' => $pengeluaran,
                    'laba_rugi' => $pendapatan - $pengeluaran,
                    'aset' => rand(500000000, 1000000000),
                    'kewajiban' => rand(50000000, 200000000),
                    'modal' => rand(300000000, 500000000),
                    'keterangan' => "Laporan keuangan periode $bulan $tahun telah diaudit dan disetujui.",
                    'is_published' => true,
                ]);
            }
        }

        $beritaData = [
            [
                'judul' => 'BUMNag Madani Raih Penghargaan BUMNag Terbaik Tingkat Provinsi',
                'ringkasan' => 'BUMNag Madani Lubuk Malako berhasil meraih penghargaan sebagai BUMNag terbaik tingkat Provinsi Sumatera Barat tahun 2025.',
                'konten' => "BUMNag Madani Lubuk Malako kembali menorehkan prestasi membanggakan dengan meraih penghargaan sebagai Badan Usaha Milik Nagari terbaik tingkat Provinsi Sumatera Barat tahun 2025.\n\nPenghargaan ini diberikan oleh Gubernur Sumatera Barat dalam acara Hari Jadi Provinsi Sumatera Barat yang diselenggarakan di Padang.\n\nDirektur BUMNag Madani, H. Ahmad Yani, S.E., mengucapkan terima kasih kepada seluruh masyarakat Lubuk Malako yang telah mendukung kemajuan BUMNag.\n\n\"Penghargaan ini adalah hasil kerja keras seluruh tim dan dukungan masyarakat. Kami akan terus berkomitmen untuk memberikan yang terbaik bagi nagari,\" ujar H. Ahmad Yani.",
                'kategori' => 'Prestasi',
                'penulis' => 'Admin BUMNag',
            ],
            [
                'judul' => 'Pembukaan Unit Usaha Baru: Toko Sembako Nagari',
                'ringkasan' => 'BUMNag Madani membuka unit usaha baru berupa toko sembako yang menyediakan kebutuhan pokok bagi masyarakat dengan harga terjangkau.',
                'konten' => "BUMNag Madani Lubuk Malako resmi membuka unit usaha baru berupa Toko Sembako Nagari yang berlokasi di pusat Nagari Lubuk Malako.\n\nToko ini menyediakan berbagai kebutuhan pokok sehari-hari seperti beras, minyak goreng, gula, telur, dan kebutuhan rumah tangga lainnya dengan harga yang lebih terjangkau dibandingkan toko konvensional.\n\n\"Kami berharap dengan adanya toko sembako ini, masyarakat dapat memenuhi kebutuhan sehari-hari dengan lebih mudah dan ekonomis,\" kata Kepala Unit Usaha, Rini Wulandari, S.M.\n\nToko Sembako Nagari buka setiap hari mulai pukul 07.00 - 21.00 WIB.",
                'kategori' => 'Usaha',
                'penulis' => 'Admin BUMNag',
            ],
            [
                'judul' => 'Pelatihan Kewirausahaan untuk Pemuda Nagari',
                'ringkasan' => 'BUMNag Madani mengadakan pelatihan kewirausahaan gratis untuk pemuda Nagari Lubuk Malako dalam rangka mendorong semangat berwirausaha.',
                'konten' => "Dalam upaya mendorong semangat kewirausahaan di kalangan pemuda, BUMNag Madani Lubuk Malako mengadakan pelatihan kewirausahaan gratis bagi pemuda Nagari Lubuk Malako.\n\nPelatihan ini diikuti oleh 50 peserta dan berlangsung selama 3 hari dengan materi meliputi pengenalan dunia usaha, manajemen keuangan sederhana, pemasaran digital, dan praktik langsung pembuatan rencana bisnis.\n\nNarasumber dalam pelatihan ini adalah para praktisi bisnis dari berbagai bidang serta pengurus BUMNag Madani.\n\n\"Kami ingin pemuda nagari memiliki bekal untuk mandiri secara ekonomi. Dengan keterampilan berwirausaha, mereka bisa menciptakan lapangan kerja, bukan hanya mencari kerja,\" jelas Direktur BUMNag.",
                'kategori' => 'Kegiatan',
                'penulis' => 'Admin BUMNag',
            ],
        ];

        foreach ($beritaData as $index => $data) {
            Berita::create([
                ...$data,
                'slug' => Str::slug($data['judul']),
                'is_published' => true,
                'published_at' => now()->subDays($index * 7),
                'views' => rand(50, 500),
            ]);
        }

        $pengumumanData = [
            [
                'judul' => 'Rapat Umum Pemegang Saham Tahunan (RUPST) 2025',
                'isi' => 'Diberitahukan kepada seluruh pemegang saham BUMNag Madani Lubuk Malako bahwa RUPST 2025 akan dilaksanakan pada hari Sabtu, 15 Februari 2025 pukul 09.00 WIB bertempat di Aula Kantor Wali Nagari Lubuk Malako. Agenda: Laporan Pertanggungjawaban Pengurus, Pembagian SHU, dan Rencana Kerja 2025.',
                'prioritas' => 'tinggi',
                'tanggal_mulai' => now()->addDays(7),
                'tanggal_selesai' => now()->addDays(7),
            ],
            [
                'judul' => 'Pendaftaran Anggota Baru BUMNag',
                'isi' => 'BUMNag Madani Lubuk Malako membuka pendaftaran anggota baru bagi warga Nagari Lubuk Malako yang ingin bergabung menjadi pemegang saham. Pendaftaran dibuka mulai tanggal 1 - 31 Januari 2025 di Kantor BUMNag. Syarat: KTP Nagari Lubuk Malako, mengisi formulir, dan menyetor modal awal sesuai ketentuan.',
                'prioritas' => 'sedang',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(30),
            ],
            [
                'judul' => 'Jadwal Pelayanan Hari Libur Nasional',
                'isi' => 'Diberitahukan bahwa selama hari libur nasional, pelayanan di Kantor BUMNag Madani tetap buka dengan jam operasional terbatas yaitu pukul 08.00 - 12.00 WIB. Untuk Toko Sembako Nagari tetap buka seperti biasa.',
                'prioritas' => 'rendah',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(60),
            ],
        ];

        foreach ($pengumumanData as $data) {
            Pengumuman::create([
                ...$data,
                'is_active' => true,
            ]);
        }
    }
}
