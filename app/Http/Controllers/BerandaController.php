<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\ProfilBumnag;
use App\Models\TransaksiKas;
use App\Models\GaleriBumnag;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman beranda publik
 */
class BerandaController extends Controller
{
    /**
     * Menampilkan halaman beranda dengan statistik dan konten terbaru
     */
    public function index()
    {
        // Profil BUMNag
        $profil = ProfilBumnag::getProfil();
        
        // Berita terbaru (3 berita)
        $beritaTerbaru = Berita::published()
            ->latest()
            ->take(3)
            ->get();
        
        // Pengumuman aktif (4 pengumuman)
        $pengumumanAktif = Pengumuman::aktif()
            ->byPrioritas()
            ->take(4)
            ->get();
        
        // Statistik keuangan tahun ini dari TransaksiKas
        $tahunIni = date('Y');
        $dataTransaksi = TransaksiKas::tahun($tahunIni)->get();
        
        // Rekap bulanan untuk menghitung jumlah bulan yang ada data
        $rekapBulanan = TransaksiKas::getRekapTahunan($tahunIni);
        
        $statistikKeuangan = [
            'total_pendapatan' => $dataTransaksi->sum('uang_masuk'),
            'total_pengeluaran' => $dataTransaksi->sum('uang_keluar'),
            'total_laba_rugi' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
            'jumlah_transaksi' => $dataTransaksi->count(),
            'jumlah_laporan' => count($rekapBulanan), // Jumlah bulan yang ada transaksi
        ];
        
        // Galeri BUMNag untuk slider (8 foto terbaru)
        $galeriFoto = GaleriBumnag::aktif()->ordered()->limit(8)->get();
        
        // Transaksi terbaru
        $transaksiTerbaru = TransaksiKas::terbaru()->first();
        
        // Jumlah total
        $totalBerita = Berita::published()->count();
        $totalPengumuman = Pengumuman::aktif()->count();
        $totalLaporan = TransaksiKas::count();
        
        return view('public.beranda', compact(
            'profil',
            'beritaTerbaru',
            'pengumumanAktif',
            'statistikKeuangan',
            'galeriFoto',
            'transaksiTerbaru',
            'totalBerita',
            'totalPengumuman',
            'totalLaporan',
            'tahunIni'
        ));
    }
}
