<?php

namespace App\Http\Controllers\SubUnit;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

/**
 * Dashboard untuk akun Sub Unit Usaha
 * Menampilkan ringkasan keuangan sub unit
 */
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $subUnit = $user->subUnitUsaha;
        $unit = $user->unitUsaha;

        if (!$subUnit) {
            abort(403, 'Akun tidak terkait dengan sub unit usaha.');
        }

        $tahun = now()->year;

        // Statistik keuangan sub unit ini
        $laporan = LaporanKeuangan::where('sub_unit_id', $subUnit->id)
            ->tahun($tahun)
            ->get();

        $totalPendapatan = $laporan->sum('pendapatan');
        $totalPengeluaran = $laporan->sum('pengeluaran');
        $totalLabaRugi = $totalPendapatan - $totalPengeluaran;
        $jumlahLaporan = $laporan->count();

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
        $laporanTerbaru = LaporanKeuangan::where('sub_unit_id', $subUnit->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->limit(10)
            ->get();

        return view('subunit.dashboard', compact(
            'unit', 'subUnit', 'tahun', 'totalPendapatan', 'totalPengeluaran',
            'totalLabaRugi', 'jumlahLaporan', 'chartData', 'laporanTerbaru'
        ));
    }
}
