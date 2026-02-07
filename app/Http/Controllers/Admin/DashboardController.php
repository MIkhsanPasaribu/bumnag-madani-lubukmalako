<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LaporanKeuangan;
use App\Models\LaporanTahunan;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

/**
 * Controller untuk dashboard admin
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik ringkasan
     */
    public function index()
    {
        // Statistik total
        $totalBerita = Berita::count();
        $totalBeritaPublished = Berita::published()->count();
        $totalLaporanTahunan = LaporanTahunan::count();
        $totalLaporanPublished = LaporanTahunan::published()->count();
        $totalLaporanKeuangan = LaporanKeuangan::count();
        $totalPesanBelumDibaca = PesanKontak::belumDibaca()->count();
        
        // Berita terbaru (5)
        $beritaTerbaru = Berita::latest()->take(5)->get();
        
        // Laporan Tahunan terbaru (5)
        $laporanTerbaru = LaporanTahunan::latest()->take(5)->get();
        
        // Statistik keuangan tahun ini dari LaporanKeuangan
        $tahunIni = date('Y');
        $statistikKeuangan = LaporanKeuangan::getStatistikTahunan($tahunIni);
        
        // Data untuk chart mini dari rekap bulanan
        $rekapBulanan = LaporanKeuangan::getRekapTahunan($tahunIni);
        $chartData = [
            'labels' => array_column($rekapBulanan, 'nama_bulan'),
            'pendapatan' => array_column($rekapBulanan, 'total_pendapatan'),
            'pengeluaran' => array_column($rekapBulanan, 'total_pengeluaran'),
        ];
        
        return view('admin.dashboard', compact(
            'totalBerita',
            'totalBeritaPublished',
            'totalLaporanTahunan',
            'totalLaporanPublished',
            'totalLaporanKeuangan',
            'totalPesanBelumDibaca',
            'beritaTerbaru',
            'laporanTerbaru',
            'statistikKeuangan',
            'chartData',
            'tahunIni'
        ));
    }
}
