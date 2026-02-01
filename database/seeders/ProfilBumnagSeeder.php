<?php

namespace Database\Seeders;

use App\Models\ProfilBumnag;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk data profil BUMNag Madani Lubuk Malako
 */
class ProfilBumnagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilBumnag::create([
            'nama_bumnag' => 'BUMNag Madani',
            'nama_nagari' => 'Lubuk Malako',
            'alamat' => 'Jl. Nagari Lubuk Malako, Kec. Sangir Jujuan, Kab. Solok Selatan, Sumatera Barat 27782',
            'telepon' => '0755-xxxxxxx',
            'email' => 'bumnagmadani@gmail.com',
            'website' => 'https://bumnagmadani.id',
            'sejarah' => 'Badan Usaha Milik Nagari (BUMNag) Madani Lubuk Malako didirikan pada tahun 2020 sebagai upaya untuk mengembangkan potensi ekonomi nagari dan meningkatkan kesejahteraan masyarakat Lubuk Malako. BUMNag ini merupakan hasil musyawarah nagari yang melibatkan seluruh elemen masyarakat.

BUMNag Madani bergerak di berbagai bidang usaha yang sesuai dengan potensi lokal, termasuk pengelolaan pariwisata, pertanian, perdagangan, dan jasa. Dengan semangat gotong royong dan profesionalisme, BUMNag Madani terus berkembang menjadi motor penggerak ekonomi nagari yang mandiri dan berkelanjutan.',
            'visi' => 'Mewujudkan BUMNag Madani sebagai pilar ekonomi nagari yang mandiri, profesional, dan berkelanjutan untuk kesejahteraan masyarakat Lubuk Malako.',
            'misi' => 'Mengembangkan usaha ekonomi produktif berbasis potensi lokal
Meningkatkan pelayanan publik kepada masyarakat nagari
Menciptakan lapangan kerja dan pemberdayaan ekonomi masyarakat
Mengelola aset nagari secara profesional dan transparan
Membangun kemitraan dengan berbagai pihak untuk pengembangan usaha
Menerapkan prinsip tata kelola yang baik (good governance)',
            'struktur_organisasi' => [
                // Pimpinan Nagari
                [
                    'jabatan' => 'Bamus',
                    'nama' => 'Febramadhani',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Penasehat',
                    'nama' => 'Abdul Reda',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Ketua KAN',
                    'nama' => 'Riono Pendri',
                    'foto' => null,
                ],
                // Pengawas
                [
                    'jabatan' => 'Pengawas',
                    'nama' => 'Abdul Khairi',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Pengawas',
                    'nama' => 'Syaiful',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Pengawas',
                    'nama' => 'Mardinas',
                    'foto' => null,
                ],
                // Pengurus Inti
                [
                    'jabatan' => 'Direktur',
                    'nama' => 'Suherdian Antoni',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Sekretaris',
                    'nama' => 'Andiko',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Bendahara',
                    'nama' => 'Gustiya Eka Putri',
                    'foto' => null,
                ],
                // Kepala Unit
                [
                    'jabatan' => 'Kepala Unit Kebun',
                    'nama' => 'Andi Gusbarya',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Kepala Unit Jasa',
                    'nama' => 'Marfriend Efri Hendra',
                    'foto' => null,
                ],
                // Mandor
                [
                    'jabatan' => 'Mandor Panen',
                    'nama' => 'Afdhal Saputra',
                    'foto' => null,
                ],
                [
                    'jabatan' => 'Mandor Rawat',
                    'nama' => 'Ilham Firdaus',
                    'foto' => null,
                ],
                // Staf
                [
                    'jabatan' => 'Staf',
                    'nama' => 'Efri Maryono',
                    'foto' => null,
                ],
            ],
            'logo' => 'logo.png',
        ]);
    }
}
