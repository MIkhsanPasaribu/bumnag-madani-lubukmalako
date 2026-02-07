<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\LaporanTahunan;
use App\Models\ProfilBumnag;
use App\Models\LaporanKeuangan;
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
            ->orderBy('tanggal_publikasi', 'desc')
            ->take(3)
            ->get();
        
        // Laporan Tahunan terbaru (4 laporan)
        $laporanTerbaru = LaporanTahunan::published()
            ->orderBy('tahun', 'desc')
            ->take(4)
            ->get();
        
        // Statistik keuangan tahun ini dari LaporanKeuangan
        $tahunIni = date('Y');
        $statistikKeuangan = LaporanKeuangan::getStatistikTahunan($tahunIni);
        $rekapBulanan = LaporanKeuangan::getRekapTahunan($tahunIni);
        $statistikKeuangan['jumlah_bulan'] = count($rekapBulanan);
        
        // Galeri BUMNag untuk slider (8 foto terbaru)
        $galeriFoto = GaleriBumnag::aktif()->ordered()->limit(8)->get();
        
        // Jumlah total
        $totalBerita = Berita::published()->count();
        $totalLaporan = LaporanTahunan::published()->count();
        
        return view('public.beranda', compact(
            'profil',
            'beritaTerbaru',
            'laporanTerbaru',
            'statistikKeuangan',
            'galeriFoto',
            'totalBerita',
            'totalLaporan',
            'tahunIni'
        ));
    }
}
