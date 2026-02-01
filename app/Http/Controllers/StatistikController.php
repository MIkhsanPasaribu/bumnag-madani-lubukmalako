<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKas;
use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman statistik keuangan publik
 */
class StatistikController extends Controller
{
    /**
     * Menampilkan halaman statistik dengan grafik Chart.js
     */
    public function index(Request $request)
    {
        // Tahun yang tersedia dari transaksi kas
        $tahunTersedia = TransaksiKas::getTahunTersedia();
        
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }
        
        // Tahun yang dipilih
        $tahunTerpilih = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        $tahunSebelumnya = $tahunTerpilih - 1;
        
        // Rekap tahunan dari transaksi kas
        $rekapBulanan = TransaksiKas::getRekapTahunan($tahunTerpilih);
        
        // Statistik keseluruhan tahun ini
        $dataTransaksi = TransaksiKas::tahun($tahunTerpilih)->get();
        $statistik = [
            'total_pendapatan' => $dataTransaksi->sum('uang_masuk'),
            'total_pengeluaran' => $dataTransaksi->sum('uang_keluar'),
            'total_laba_rugi' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
            'jumlah_laporan' => count($rekapBulanan),
            'jumlah_transaksi' => $dataTransaksi->count(),
        ];
        
        // Data tahun lalu untuk perbandingan
        $dataLastYear = TransaksiKas::tahun($tahunSebelumnya)->get();
        $statsLastYear = [
            'pendapatan' => $dataLastYear->sum('uang_masuk'),
            'pengeluaran' => $dataLastYear->sum('uang_keluar'),
            'laba' => $dataLastYear->sum('uang_masuk') - $dataLastYear->sum('uang_keluar'),
        ];
        
        // Growth YoY
        $growth = [
            'pendapatan' => $statsLastYear['pendapatan'] > 0 
                ? (($statistik['total_pendapatan'] - $statsLastYear['pendapatan']) / $statsLastYear['pendapatan']) * 100 
                : 0,
            'pengeluaran' => $statsLastYear['pengeluaran'] > 0 
                ? (($statistik['total_pengeluaran'] - $statsLastYear['pengeluaran']) / $statsLastYear['pengeluaran']) * 100 
                : 0,
        ];
        
        // Rasio keuangan
        $rasio = [
            'expense_ratio' => $statistik['total_pendapatan'] > 0 
                ? ($statistik['total_pengeluaran'] / $statistik['total_pendapatan']) * 100 
                : 0,
            'profit_margin' => $statistik['total_pendapatan'] > 0 
                ? ($statistik['total_laba_rugi'] / $statistik['total_pendapatan']) * 100 
                : 0,
        ];
        
        // Proyeksi berdasarkan tren
        $avgMonthlyIncome = count($rekapBulanan) > 0 
            ? $statistik['total_pendapatan'] / count($rekapBulanan) 
            : 0;
        $avgMonthlyExpense = count($rekapBulanan) > 0 
            ? $statistik['total_pengeluaran'] / count($rekapBulanan) 
            : 0;
        $remainingMonths = 12 - count($rekapBulanan);
        
        $proyeksi = [
            'pendapatan_tahunan' => $statistik['total_pendapatan'] + ($avgMonthlyIncome * $remainingMonths),
            'pengeluaran_tahunan' => $statistik['total_pengeluaran'] + ($avgMonthlyExpense * $remainingMonths),
            'laba_proyeksi' => ($statistik['total_pendapatan'] + ($avgMonthlyIncome * $remainingMonths)) 
                            - ($statistik['total_pengeluaran'] + ($avgMonthlyExpense * $remainingMonths)),
            'avg_monthly_income' => $avgMonthlyIncome,
            'avg_monthly_expense' => $avgMonthlyExpense,
        ];
        
        // Data untuk chart bulanan
        $chartData = [
            'labels' => array_column($rekapBulanan, 'nama_bulan'),
            'pendapatan' => array_column($rekapBulanan, 'total_masuk'),
            'pengeluaran' => array_column($rekapBulanan, 'total_keluar'),
            'laba_rugi' => array_column($rekapBulanan, 'selisih'),
        ];
        
        // Data untuk pie chart kategori
        $kategoriPengeluaran = KategoriTransaksi::keluar()
            ->aktif()
            ->get()
            ->map(function ($kat) use ($tahunTerpilih) {
                $total = TransaksiKas::where('kategori_id', $kat->id)
                    ->tahun($tahunTerpilih)
                    ->sum('uang_keluar');
                return [
                    'nama' => $kat->nama,
                    'warna' => $kat->warna,
                    'total' => $total,
                ];
            })
            ->filter(fn($item) => $item['total'] > 0)
            ->values()
            ->toArray();
        
        $kategoriPemasukan = KategoriTransaksi::masuk()
            ->aktif()
            ->get()
            ->map(function ($kat) use ($tahunTerpilih) {
                $total = TransaksiKas::where('kategori_id', $kat->id)
                    ->tahun($tahunTerpilih)
                    ->sum('uang_masuk');
                return [
                    'nama' => $kat->nama,
                    'warna' => $kat->warna,
                    'total' => $total,
                ];
            })
            ->filter(fn($item) => $item['total'] > 0)
            ->values()
            ->toArray();
        
        // Data untuk doughnut chart proporsi
        $proporsiData = [
            'labels' => ['Pendapatan', 'Pengeluaran'],
            'data' => [$statistik['total_pendapatan'], $statistik['total_pengeluaran']],
            'colors' => ['#86ae5f', '#b71e42'],
        ];
        
        return view('public.statistik', compact(
            'tahunTersedia',
            'tahunTerpilih',
            'tahunSebelumnya',
            'statistik',
            'statsLastYear',
            'growth',
            'rasio',
            'proyeksi',
            'chartData',
            'rekapBulanan',
            'kategoriPengeluaran',
            'kategoriPemasukan',
            'proporsiData'
        ));
    }
    
    /**
     * Menampilkan detail buku kas per bulan
     */
    public function detail(int $bulan, int $tahun)
    {
        // Validasi bulan
        if ($bulan < 1 || $bulan > 12) {
            abort(404);
        }
        
        // Ambil transaksi bulan tersebut
        $transaksi = TransaksiKas::with('kategori')
            ->bulan($bulan, $tahun)
            ->urut()
            ->get();
        
        // Rekap bulan
        $rekap = TransaksiKas::getRekapBulanan($bulan, $tahun);
        
        return view('public.statistik-detail', compact('transaksi', 'rekap', 'bulan', 'tahun'));
    }
    
    /**
     * Widget Embeddable - Untuk di-embed di website lain
     */
    public function widget()
    {
        $tahun = date('Y');
        $dataTransaksi = TransaksiKas::tahun($tahun)->get();
        
        $stats = [
            'tahun' => $tahun,
            'pendapatan' => $dataTransaksi->sum('uang_masuk'),
            'pengeluaran' => $dataTransaksi->sum('uang_keluar'),
            'laba' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
            'transaksi' => $dataTransaksi->count(),
        ];
        
        return view('public.widget', compact('stats'));
    }
}
