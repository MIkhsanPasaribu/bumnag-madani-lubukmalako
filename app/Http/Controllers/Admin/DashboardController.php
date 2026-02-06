<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LaporanTahunan;
use App\Models\TransaksiKas;
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
        $totalTransaksi = TransaksiKas::count();
        
        // Berita terbaru (5)
        $beritaTerbaru = Berita::latest()->take(5)->get();
        
        // Laporan Tahunan terbaru (5)
        $laporanTerbaru = LaporanTahunan::latest()->take(5)->get();
        
        // Statistik keuangan tahun ini dari TransaksiKas
        $tahunIni = date('Y');
        $dataTransaksi = TransaksiKas::tahun($tahunIni)->get();
        $statistikKeuangan = [
            'total_pendapatan' => $dataTransaksi->sum('uang_masuk'),
            'total_pengeluaran' => $dataTransaksi->sum('uang_keluar'),
            'total_laba_rugi' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
            'jumlah_transaksi' => $dataTransaksi->count(),
        ];
        
        // Data untuk chart mini dari rekap bulanan
        $rekapBulanan = TransaksiKas::getRekapTahunan($tahunIni);
        $chartData = [
            'labels' => array_column($rekapBulanan, 'nama_bulan'),
            'pendapatan' => array_column($rekapBulanan, 'total_masuk'),
            'pengeluaran' => array_column($rekapBulanan, 'total_keluar'),
        ];
        
        return view('admin.dashboard', compact(
            'totalBerita',
            'totalBeritaPublished',
            'totalLaporanTahunan',
            'totalLaporanPublished',
            'totalTransaksi',
            'beritaTerbaru',
            'laporanTerbaru',
            'statistikKeuangan',
            'chartData',
            'tahunIni'
        ));
    }
}
