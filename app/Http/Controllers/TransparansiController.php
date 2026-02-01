<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKas;
use App\Exports\TransaksiKasExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller untuk halaman transparansi keuangan publik
 */
class TransparansiController extends Controller
{
    /**
     * Menampilkan daftar laporan keuangan yang dipublikasikan
     */
    public function index(Request $request)
    {
        // Tahun yang tersedia
        $tahunTersedia = TransaksiKas::getTahunTersedia();
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }
        
        // Filter
        $tahunFilter = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        
        // Rekap bulanan untuk tahun terpilih
        $rekapBulanan = TransaksiKas::getRekapTahunan($tahunFilter);
        
        // Statistik keseluruhan tahun terpilih
        $dataTransaksi = TransaksiKas::tahun($tahunFilter)->get();
        $statistik = [
            'total_pendapatan' => $dataTransaksi->sum('uang_masuk'),
            'total_pengeluaran' => $dataTransaksi->sum('uang_keluar'),
            'total_laba_rugi' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
            'jumlah_transaksi' => $dataTransaksi->count(),
        ];
        
        return view('public.transparansi', compact(
            'rekapBulanan',
            'tahunTersedia',
            'tahunFilter',
            'statistik'
        ));
    }
    
    /**
     * Download PDF Buku Kas per bulan
     */
    public function downloadPdf(int $bulan, int $tahun)
    {
        $transaksi = TransaksiKas::bulan($bulan, $tahun)
            ->urut()
            ->get();
        
        $rekap = TransaksiKas::getRekapBulanan($bulan, $tahun);
        
        $pdf = Pdf::loadView('pdf.buku-kas', compact('transaksi', 'rekap', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');
        
        $filename = 'buku_kas_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . $tahun . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * Download Excel Buku Kas per bulan
     */
    public function downloadExcel(int $bulan, int $tahun)
    {
        $filename = 'Buku_Kas_' . TransaksiKas::$namaBulan[$bulan] . '_' . $tahun . '.xlsx';
        
        return Excel::download(new TransaksiKasExport($bulan, $tahun), $filename);
    }
}
