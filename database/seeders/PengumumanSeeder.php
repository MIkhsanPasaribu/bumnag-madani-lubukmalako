<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk sample pengumuman BUMNag
 */
class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengumumanList = [
            [
                'judul' => 'Pendaftaran Anggota Koperasi BUMNag Madani Tahun 2026',
                'konten' => '<p>BUMNag Madani membuka pendaftaran anggota koperasi baru untuk tahun 2026.</p>
<p><strong>Syarat Pendaftaran:</strong></p>
<ul>
<li>Warga Nagari Lubuk Malako berusia minimal 17 tahun</li>
<li>Membawa fotokopi KTP dan KK</li>
<li>Simpanan pokok Rp 100.000</li>
<li>Simpanan wajib bulanan Rp 20.000</li>
</ul>
<p><strong>Manfaat Menjadi Anggota:</strong></p>
<ul>
<li>Akses pinjaman modal usaha</li>
<li>Pembagian SHU tahunan</li>
<li>Pelatihan kewirausahaan gratis</li>
<li>Prioritas dalam program pemberdayaan</li>
</ul>
<p>Pendaftaran dapat dilakukan di Kantor BUMNag Madani setiap hari kerja pukul 08.00-15.00 WIB.</p>',
                'prioritas' => 'tinggi',
                'tanggal_mulai' => now()->subDays(5),
                'tanggal_berakhir' => now()->addDays(25),
                'status' => 'aktif',
            ],
            [
                'judul' => 'Jadwal Pelayanan BUMNag Selama Bulan Ramadhan',
                'konten' => '<p>Sehubungan dengan bulan suci Ramadhan, BUMNag Madani menyesuaikan jadwal pelayanan sebagai berikut:</p>
<p><strong>Senin - Kamis:</strong> 08.00 - 14.00 WIB</p>
<p><strong>Jumat:</strong> 08.00 - 11.00 WIB</p>
<p><strong>Sabtu - Minggu:</strong> Libur</p>
<p>Pelayanan darurat tetap dapat menghubungi nomor hotline BUMNag di 0812-xxxx-xxxx.</p>
<p>Semoga Ramadhan tahun ini penuh berkah untuk kita semua.</p>',
                'prioritas' => 'sedang',
                'tanggal_mulai' => now()->subDays(10),
                'tanggal_berakhir' => now()->addDays(20),
                'status' => 'aktif',
            ],
            [
                'judul' => 'Lowongan Kerja: Staff Administrasi BUMNag Madani',
                'konten' => '<p>BUMNag Madani membuka lowongan untuk posisi Staff Administrasi.</p>
<p><strong>Kualifikasi:</strong></p>
<ul>
<li>Pendidikan minimal D3 semua jurusan</li>
<li>Mampu mengoperasikan komputer (Ms. Office)</li>
<li>Warga Nagari Lubuk Malako (diutamakan)</li>
<li>Usia maksimal 30 tahun</li>
<li>Teliti, jujur, dan bertanggung jawab</li>
</ul>
<p><strong>Berkas Lamaran:</strong></p>
<ul>
<li>Surat lamaran</li>
<li>Curriculum Vitae</li>
<li>Fotokopi ijazah terakhir</li>
<li>Fotokopi KTP</li>
<li>Pas foto 3x4 (2 lembar)</li>
</ul>
<p>Lamaran dikirim ke Kantor BUMNag Madani paling lambat tanggal yang tertera.</p>',
                'prioritas' => 'tinggi',
                'tanggal_mulai' => now(),
                'tanggal_berakhir' => now()->addDays(14),
                'status' => 'aktif',
            ],
            [
                'judul' => 'Pembagian Sembako untuk Warga Kurang Mampu',
                'konten' => '<p>Dalam rangka kepedulian sosial, BUMNag Madani akan mengadakan pembagian sembako untuk warga kurang mampu.</p>
<p><strong>Waktu:</strong> Sabtu, tanggal yang akan ditentukan</p>
<p><strong>Tempat:</strong> Balai Adat Nagari Lubuk Malako</p>
<p><strong>Sasaran:</strong> Warga yang terdaftar dalam data penerima bantuan sosial nagari</p>
<p>Bagi warga yang memenuhi kriteria namun belum terdaftar, silakan melapor ke kantor BUMNag dengan membawa surat keterangan tidak mampu dari jorong masing-masing.</p>',
                'prioritas' => 'sedang',
                'tanggal_mulai' => now()->addDays(3),
                'tanggal_berakhir' => now()->addDays(10),
                'status' => 'aktif',
            ],
            [
                'judul' => 'Pengumuman Hasil Seleksi Penerima Pinjaman Modal Usaha',
                'konten' => '<p>Berdasarkan hasil seleksi yang dilakukan oleh Tim Verifikasi BUMNag Madani, berikut adalah daftar penerima pinjaman modal usaha periode Januari 2026:</p>
<p>Total pemohon: 25 orang<br>
Disetujui: 18 orang<br>
Ditolak: 7 orang (karena tidak memenuhi persyaratan)</p>
<p>Bagi yang namanya tercantum dalam daftar penerima, silakan datang ke Kantor BUMNag untuk proses pencairan dengan membawa:</p>
<ul>
<li>KTP asli</li>
<li>Buku tabungan</li>
<li>Materai 10.000 (2 lembar)</li>
</ul>
<p>Bagi yang tidak lolos seleksi, tetap semangat dan dapat mengajukan kembali pada periode berikutnya.</p>',
                'prioritas' => 'rendah',
                'tanggal_mulai' => now()->subDays(3),
                'tanggal_berakhir' => null,
                'status' => 'aktif',
            ],
        ];

        foreach ($pengumumanList as $pengumuman) {
            Pengumuman::create($pengumuman);
        }
    }
}
