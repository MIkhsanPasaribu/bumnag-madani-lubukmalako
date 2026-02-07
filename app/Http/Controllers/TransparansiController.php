<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use App\Exports\LaporanKeuanganExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller untuk halaman transparansi keuangan publik
 * Menampilkan rekap dan download laporan keuangan
 */
class TransparansiController extends Controller
{
    /**
     * Menampilkan daftar laporan keuangan yang dipublikasikan
     */
    public function index(Request $request)
    {
        // Tahun yang tersedia
        $tahunTersedia = LaporanKeuangan::getTahunTersedia();
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }

        // Filter
        $tahunFilter = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));

        // Rekap bulanan untuk tahun terpilih
        $rekapBulanan = LaporanKeuangan::getRekapTahunan($tahunFilter);

        // Statistik keseluruhan
        $statistik = LaporanKeuangan::getStatistikTahunan($tahunFilter);

        // Unit usaha
        $units = UnitUsaha::aktif()->ordered()->get();

        // Rekap per unit
        $rekapPerUnit = [];
        foreach ($units as $unit) {
            $unitData = LaporanKeuangan::tahun($tahunFilter)->unit($unit->id)->get();
            $rekapPerUnit[] = [
                'unit' => $unit,
                'total_pendapatan' => (float) $unitData->sum('pendapatan'),
                'total_pengeluaran' => (float) $unitData->sum('pengeluaran'),
                'total_laba_rugi' => (float) $unitData->sum('pendapatan') - (float) $unitData->sum('pengeluaran'),
            ];
        }

        return view('public.transparansi', compact(
            'rekapBulanan',
            'tahunTersedia',
            'tahunFilter',
            'statistik',
            'units',
            'rekapPerUnit'
        ));
    }

    /**
     * Download PDF per bulan (gabungan semua unit)
     */
    public function downloadPdf(int $bulan, int $tahun)
    {
        $laporan = LaporanKeuangan::with(['unit', 'subUnit'])
            ->bulan($bulan, $tahun)
            ->orderBy('unit_id')
            ->orderBy('sub_unit_id')
            ->get();

        $rekap = [
            'periode' => LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun,
            'unit_nama' => null,
            'total_pendapatan' => (float) $laporan->sum('pendapatan'),
            'total_pengeluaran' => (float) $laporan->sum('pengeluaran'),
            'total_laba_rugi' => (float) $laporan->sum('pendapatan') - (float) $laporan->sum('pengeluaran'),
            'jumlah_laporan' => $laporan->count(),
        ];

        $rekapPerUnit = $this->buildRekapPerUnit($laporan);

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact('laporan', 'rekap', 'rekapPerUnit', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_keuangan_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . $tahun . '.pdf');
    }

    /**
     * Download PDF per tahun (gabungan semua unit)
     */
    public function downloadPdfTahunan(int $tahun)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $laporan = LaporanKeuangan::with(['unit', 'subUnit'])
            ->tahun($tahun)
            ->orderBy('bulan')
            ->orderBy('unit_id')
            ->orderBy('sub_unit_id')
            ->get();

        $rekap = [
            'periode' => 'Tahun ' . $tahun,
            'unit_nama' => null,
            'total_pendapatan' => (float) $laporan->sum('pendapatan'),
            'total_pengeluaran' => (float) $laporan->sum('pengeluaran'),
            'total_laba_rugi' => (float) $laporan->sum('pendapatan') - (float) $laporan->sum('pengeluaran'),
            'jumlah_laporan' => $laporan->count(),
        ];

        $rekapPerUnit = $this->buildRekapPerUnit($laporan);
        $bulan = null;

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact('laporan', 'rekap', 'rekapPerUnit', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_keuangan_tahun_' . $tahun . '.pdf');
    }

    /**
     * Download PDF per unit
     */
    public function downloadPdfUnit(int $tahun, int $unitId)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $unit = UnitUsaha::findOrFail($unitId);

        $laporan = LaporanKeuangan::with(['unit', 'subUnit'])
            ->tahun($tahun)
            ->unit($unitId)
            ->orderBy('bulan')
            ->orderBy('sub_unit_id')
            ->get();

        $rekap = [
            'periode' => 'Tahun ' . $tahun,
            'unit_nama' => $unit->nama,
            'total_pendapatan' => (float) $laporan->sum('pendapatan'),
            'total_pengeluaran' => (float) $laporan->sum('pengeluaran'),
            'total_laba_rugi' => (float) $laporan->sum('pendapatan') - (float) $laporan->sum('pengeluaran'),
            'jumlah_laporan' => $laporan->count(),
        ];

        $rekapPerUnit = [];
        $bulan = null;

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact('laporan', 'rekap', 'rekapPerUnit', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_keuangan_' . $tahun . '_' . strtolower(str_replace(' ', '_', $unit->nama)) . '.pdf');
    }

    /**
     * Download Excel per bulan
     */
    public function downloadExcel(int $bulan, int $tahun)
    {
        $filename = 'Laporan_Keuangan_' . LaporanKeuangan::$namaBulan[$bulan] . '_' . $tahun . '.xlsx';

        return Excel::download(new LaporanKeuanganExport($bulan, $tahun), $filename);
    }

    /**
     * Download Excel per tahun
     */
    public function downloadExcelTahunan(int $tahun)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        return Excel::download(new LaporanKeuanganExport(null, $tahun), 'Laporan_Keuangan_Tahun_' . $tahun . '.xlsx');
    }

    /**
     * Download Excel per unit
     */
    public function downloadExcelUnit(int $tahun, int $unitId)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $unit = UnitUsaha::findOrFail($unitId);
        $filename = 'Laporan_Keuangan_' . $tahun . '_' . str_replace(' ', '_', $unit->nama) . '.xlsx';

        return Excel::download(new LaporanKeuanganExport(null, $tahun, $unitId), $filename);
    }

    /**
     * Helper: build rekap per unit dari collection
     */
    private function buildRekapPerUnit($laporan): array
    {
        $result = [];
        foreach ($laporan->groupBy('unit_id') as $group) {
            $unit = $group->first()->unit;
            $result[] = [
                'nama_unit' => $unit->nama ?? '-',
                'total_pendapatan' => (float) $group->sum('pendapatan'),
                'total_pengeluaran' => (float) $group->sum('pengeluaran'),
                'total_laba_rugi' => (float) $group->sum('pendapatan') - (float) $group->sum('pengeluaran'),
            ];
        }
        return $result;
    }
}
