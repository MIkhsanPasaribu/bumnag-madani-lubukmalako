<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;

class KeuanganController extends Controller
{
    public function statistik()
    {
        $laporanTahunan = LaporanKeuangan::published()
            ->selectRaw('tahun, SUM(pendapatan) as total_pendapatan, SUM(pengeluaran) as total_pengeluaran, SUM(laba_rugi) as total_laba_rugi')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        $laporanBulanan = LaporanKeuangan::published()
            ->where('tahun', date('Y'))
            ->orderBy('id')
            ->get();

        $totalAset = LaporanKeuangan::published()->latest()->first()?->aset ?? 0;
        $totalModal = LaporanKeuangan::published()->latest()->first()?->modal ?? 0;

        return view('keuangan.statistik', compact('laporanTahunan', 'laporanBulanan', 'totalAset', 'totalModal'));
    }

    public function transparansi()
    {
        $laporanKeuangan = LaporanKeuangan::published()
            ->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('keuangan.transparansi', compact('laporanKeuangan'));
    }
}
