<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk sample berita BUMNag
 */
class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        $beritaList = [
            [
                'judul' => 'BUMNag Madani Gelar Pelatihan Kewirausahaan untuk Pemuda Nagari',
                'konten' => '<p>Dalam rangka meningkatkan kapasitas wirausaha muda di Nagari Lubuk Malako, BUMNag Madani menggelar pelatihan kewirausahaan selama tiga hari.</p>
<p>Pelatihan ini diikuti oleh 30 pemuda dari berbagai jorong di Nagari Lubuk Malako. Materi yang diberikan meliputi dasar-dasar kewirausahaan, manajemen keuangan, pemasaran digital, dan akses permodalan.</p>
<p>"Kami berharap pelatihan ini dapat membekali pemuda nagari dengan keterampilan berwirausaha sehingga dapat menciptakan lapangan kerja di nagari sendiri," ujar Direktur BUMNag Madani.</p>
<p>Pelatihan ini merupakan bagian dari program pemberdayaan ekonomi masyarakat yang menjadi salah satu fokus utama BUMNag Madani tahun ini.</p>',
                'ringkasan' => 'BUMNag Madani mengadakan pelatihan kewirausahaan untuk 30 pemuda Nagari Lubuk Malako selama tiga hari.',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(2),
            ],
            [
                'judul' => 'Launching Unit Usaha Wisata Alam Bukik Gadang',
                'konten' => '<p>BUMNag Madani resmi meluncurkan unit usaha baru di bidang pariwisata, yaitu Wisata Alam Bukik Gadang.</p>
<p>Wisata Alam Bukik Gadang menawarkan keindahan pemandangan alam perbukitan dengan berbagai fasilitas seperti camping ground, spot foto instagramable, dan kedai kuliner tradisional.</p>
<p>Lokasi wisata ini dapat ditempuh dengan perjalanan 15 menit dari pusat nagari menggunakan kendaraan roda dua maupun roda empat.</p>
<p>Dengan dibukanya wisata ini, diharapkan dapat meningkatkan pendapatan asli nagari dan membuka lapangan kerja baru bagi masyarakat setempat.</p>',
                'ringkasan' => 'BUMNag Madani meluncurkan unit usaha wisata alam baru yaitu Wisata Alam Bukik Gadang dengan berbagai fasilitas menarik.',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(5),
            ],
            [
                'judul' => 'Rapat Koordinasi BUMNag se-Kecamatan Sangir Jujuan',
                'konten' => '<p>BUMNag Madani Lubuk Malako menjadi tuan rumah rapat koordinasi BUMNag se-Kecamatan Sangir Jujuan.</p>
<p>Rapat yang dihadiri oleh 12 Direktur BUMNag se-kecamatan ini membahas berbagai hal penting, termasuk pertukaran pengalaman pengelolaan usaha, peluang kerjasama antar BUMNag, dan rencana pembentukan asosiasi BUMNag tingkat kecamatan.</p>
<p>Camat Sangir Jujuan yang turut hadir mengapresiasi inisiatif ini dan berharap sinergi antar BUMNag dapat memperkuat ekonomi nagari di wilayah kecamatan.</p>',
                'ringkasan' => 'BUMNag Madani menjadi tuan rumah rapat koordinasi BUMNag se-Kecamatan Sangir Jujuan yang dihadiri 12 Direktur BUMNag.',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(10),
            ],
            [
                'judul' => 'Distribusi Pupuk Bersubsidi untuk Petani Nagari',
                'konten' => '<p>Unit Pertanian BUMNag Madani kembali mendistribusikan pupuk bersubsidi kepada petani di Nagari Lubuk Malako.</p>
<p>Sebanyak 500 sak pupuk urea dan NPK telah didistribusikan kepada 150 petani yang terdaftar dalam kelompok tani binaan BUMNag.</p>
<p>Program distribusi pupuk subsidi ini merupakan kerjasama antara BUMNag Madani dengan Dinas Pertanian Kabupaten Solok Selatan untuk memastikan ketersediaan pupuk dengan harga terjangkau bagi petani.</p>',
                'ringkasan' => 'Unit Pertanian BUMNag Madani mendistribusikan 500 sak pupuk bersubsidi kepada 150 petani di Nagari Lubuk Malako.',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(15),
            ],
            [
                'judul' => 'Laporan Keuangan Semester I Tahun 2026 Telah Dipublikasikan',
                'konten' => '<p>Sebagai wujud transparansi pengelolaan keuangan, BUMNag Madani telah mempublikasikan laporan keuangan semester pertama tahun 2026.</p>
<p>Laporan ini mencakup seluruh transaksi pendapatan dan pengeluaran dari semua unit usaha BUMNag sepanjang Januari hingga Juni 2026.</p>
<p>Masyarakat dapat mengakses laporan keuangan ini melalui website resmi BUMNag Madani atau langsung ke kantor BUMNag.</p>
<p>BUMNag Madani berkomitmen untuk terus menjalankan prinsip keterbukaan dan akuntabilitas dalam pengelolaan dana masyarakat.</p>',
                'ringkasan' => 'BUMNag Madani mempublikasikan laporan keuangan semester I tahun 2026 sebagai wujud transparansi pengelolaan.',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(20),
            ],
        ];

        foreach ($beritaList as $berita) {
            Berita::create([
                ...$berita,
                'penulis_id' => $admin->id,
                'gambar' => null,
                'views' => rand(10, 150),
            ]);
        }
    }
}
