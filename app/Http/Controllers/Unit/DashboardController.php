<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

/**
 * Dashboard untuk akun Unit Usaha
 * Menampilkan ringkasan keuangan unit dan sub unit di bawahnya
 */
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $unit = $user->unitUsaha;

        if (!$unit) {
            abort(403, 'Akun tidak terkait dengan unit usaha.');
        }

        $tahun = now()->year;

        // Statistik keuangan unit ini
        $laporan = LaporanKeuangan::where('unit_id', $unit->id)->tahun($tahun)->get();
        $totalPendapatan = $laporan->sum('pendapatan');
        $totalPengeluaran = $laporan->sum('pengeluaran');
        $totalLabaRugi = $totalPendapatan - $totalPengeluaran;
        $jumlahLaporan = $laporan->count();

        // Rekap per sub unit (jika ada)
        $rekapSubUnit = [];
        $subUnits = $unit->getActiveSubUnits();
        foreach ($subUnits as $subUnit) {
            $subLaporan = $laporan->where('sub_unit_id', $subUnit->id);
            $rekapSubUnit[] = [
                'sub_unit' => $subUnit,
                'pendapatan' => $subLaporan->sum('pendapatan'),
                'pengeluaran' => $subLaporan->sum('pengeluaran'),
                'laba_rugi' => $subLaporan->sum('pendapatan') - $subLaporan->sum('pengeluaran'),
                'jumlah' => $subLaporan->count(),
            ];
        }

        // Laporan langsung unit (tanpa sub unit)
        $laporanLangsung = $laporan->whereNull('sub_unit_id');

        // Data chart bulanan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanData = $laporan->where('bulan', $i);
            $chartData[] = [
                'bulan' => LaporanKeuangan::$namaBulan[$i] ?? $i,
                'pendapatan' => $bulanData->sum('pendapatan'),
                'pengeluaran' => $bulanData->sum('pengeluaran'),
            ];
        }

        // Laporan terbaru
        $laporanTerbaru = LaporanKeuangan::where('unit_id', $unit->id)
            ->with('subUnit')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->limit(10)
            ->get();

        return view('unit.dashboard', compact(
            'unit', 'tahun', 'totalPendapatan', 'totalPengeluaran',
            'totalLabaRugi', 'jumlahLaporan', 'rekapSubUnit',
            'laporanLangsung', 'chartData', 'laporanTerbaru', 'subUnits'
        ));
    }
}
