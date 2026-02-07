<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman statistik keuangan publik
 * Menggunakan data dari LaporanKeuangan (per unit/sub-unit, bulanan/tahunan)
 */
class StatistikController extends Controller
{
    /**
     * Menampilkan halaman statistik dengan grafik Chart.js
     */
    public function index(Request $request)
    {
        // Tahun yang tersedia
        $tahunTersedia = LaporanKeuangan::getTahunTersedia();

        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }

        // Tahun yang dipilih
        $tahunTerpilih = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        $tahunSebelumnya = $tahunTerpilih - 1;

        // Rekap bulanan (chart + tabel)
        $rekapBulanan = LaporanKeuangan::getRekapTahunan($tahunTerpilih);

        // Statistik keseluruhan tahun ini
        $statistik = LaporanKeuangan::getStatistikTahunan($tahunTerpilih);
        $statistik['jumlah_bulan'] = count($rekapBulanan);

        // Data tahun lalu untuk perbandingan YoY
        $statsLastYear = LaporanKeuangan::getStatistikTahunan($tahunSebelumnya);

        // Growth YoY
        $growth = [
            'pendapatan' => $statsLastYear['total_pendapatan'] > 0
                ? (($statistik['total_pendapatan'] - $statsLastYear['total_pendapatan']) / $statsLastYear['total_pendapatan']) * 100
                : 0,
            'pengeluaran' => $statsLastYear['total_pengeluaran'] > 0
                ? (($statistik['total_pengeluaran'] - $statsLastYear['total_pengeluaran']) / $statsLastYear['total_pengeluaran']) * 100
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
        $jumlahBulan = count($rekapBulanan);
        $avgMonthlyIncome = $jumlahBulan > 0 ? $statistik['total_pendapatan'] / $jumlahBulan : 0;
        $avgMonthlyExpense = $jumlahBulan > 0 ? $statistik['total_pengeluaran'] / $jumlahBulan : 0;
        $remainingMonths = 12 - $jumlahBulan;

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
            'pendapatan' => array_column($rekapBulanan, 'total_pendapatan'),
            'pengeluaran' => array_column($rekapBulanan, 'total_pengeluaran'),
            'laba_rugi' => array_column($rekapBulanan, 'laba_rugi'),
        ];

        // Data per unit untuk pie chart
        $units = UnitUsaha::aktif()->ordered()->get();
        $unitChartData = [];
        $unitColors = ['#3b82f6', '#86ae5f', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'];
        foreach ($units as $i => $unit) {
            $unitStats = LaporanKeuangan::getStatistikTahunan($tahunTerpilih);
            $unitData = LaporanKeuangan::where('tahun', $tahunTerpilih)->where('unit_id', $unit->id)->get();
            $unitChartData[] = [
                'nama' => $unit->nama,
                'warna' => $unitColors[$i % count($unitColors)],
                'pendapatan' => (float) $unitData->sum('pendapatan'),
                'pengeluaran' => (float) $unitData->sum('pengeluaran'),
            ];
        }

        // Data per unit untuk rekap tabel
        $rekapPerUnit = [];
        foreach ($units as $unit) {
            $rekapPerUnit[] = [
                'unit' => $unit,
                'data' => LaporanKeuangan::getRekapTahunanPerUnit($tahunTerpilih, $unit->id),
                'statistik' => [
                    'total_pendapatan' => (float) LaporanKeuangan::tahun($tahunTerpilih)->unit($unit->id)->sum('pendapatan'),
                    'total_pengeluaran' => (float) LaporanKeuangan::tahun($tahunTerpilih)->unit($unit->id)->sum('pengeluaran'),
                ],
            ];
            $rekapPerUnit[count($rekapPerUnit) - 1]['statistik']['total_laba_rugi'] =
                $rekapPerUnit[count($rekapPerUnit) - 1]['statistik']['total_pendapatan'] -
                $rekapPerUnit[count($rekapPerUnit) - 1]['statistik']['total_pengeluaran'];
        }

        // Proporsi pendapatan vs pengeluaran
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
            'unitChartData',
            'rekapPerUnit',
            'proporsiData'
        ));
    }

    /**
     * Menampilkan detail keuangan per bulan (breakdown per unit/sub-unit)
     */
    public function detail(int $bulan, int $tahun)
    {
        if ($bulan < 1 || $bulan > 12) {
            abort(404);
        }

        // Rekap per unit untuk bulan ini
        $rekapPerUnit = LaporanKeuangan::getRekapPerUnit($bulan, $tahun);

        // Rekap total bulan ini
        $rekap = LaporanKeuangan::getRekapBulanan($bulan, $tahun);

        // Semua laporan detail bulan ini
        $laporan = LaporanKeuangan::with(['unit', 'subUnit'])
            ->bulan($bulan, $tahun)
            ->orderBy('unit_id')
            ->orderBy('sub_unit_id')
            ->get();

        return view('public.statistik-detail', compact('rekapPerUnit', 'rekap', 'laporan', 'bulan', 'tahun'));
    }

    /**
     * Widget Embeddable - Untuk di-embed di website lain
     */
    public function widget()
    {
        $tahun = date('Y');
        $statistik = LaporanKeuangan::getStatistikTahunan($tahun);

        $stats = [
            'tahun' => $tahun,
            'pendapatan' => $statistik['total_pendapatan'],
            'pengeluaran' => $statistik['total_pengeluaran'],
            'laba' => $statistik['total_laba_rugi'],
            'laporan' => $statistik['jumlah_laporan'],
        ];

        return view('public.widget', compact('stats'));
    }
}
