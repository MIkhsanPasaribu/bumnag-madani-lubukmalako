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
        $periode = TransaksiKas::$namaBulan[$bulan] . ' ' . $tahun;
        
        $pdf = Pdf::loadView('pdf.buku-kas', compact('transaksi', 'rekap', 'bulan', 'tahun', 'periode'));
        $pdf->setPaper('a4', 'landscape');
        
        $filename = 'buku_kas_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . $tahun . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * Download PDF Buku Kas per tahun (12 bulan)
     */
    public function downloadPdfTahunan(int $tahun)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        
        $transaksi = TransaksiKas::tahun($tahun)->urut()->get();
        $rekap = [
            'periode' => 'Tahun ' . $tahun,
            'jumlah_transaksi' => $transaksi->count(),
            'saldo_awal' => TransaksiKas::getSaldoAwalBulan(1, $tahun),
            'total_masuk' => $transaksi->sum('uang_masuk'),
            'total_keluar' => $transaksi->sum('uang_keluar'),
            'saldo_akhir' => TransaksiKas::tahun($tahun)->orderBy('tanggal', 'desc')->orderBy('no_urut', 'desc')->value('saldo') ?? 0,
        ];
        $rekap['selisih'] = $rekap['total_masuk'] - $rekap['total_keluar'];
        $periode = 'Tahun ' . $tahun;
        $bulan = null;
        
        $pdf = Pdf::loadView('pdf.buku-kas', compact('transaksi', 'rekap', 'bulan', 'tahun', 'periode'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('buku_kas_tahun_' . $tahun . '.pdf');
    }
    
    /**
     * Download PDF Buku Kas semua data
     */
    public function downloadPdfSemua()
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        
        $transaksi = TransaksiKas::urut()->get();
        $lastTrx = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('no_urut', 'desc')->first();
        $rekap = [
            'periode' => 'Semua Data',
            'jumlah_transaksi' => $transaksi->count(),
            'saldo_awal' => 0,
            'total_masuk' => $transaksi->sum('uang_masuk'),
            'total_keluar' => $transaksi->sum('uang_keluar'),
            'saldo_akhir' => $lastTrx?->saldo ?? 0,
        ];
        $rekap['selisih'] = $rekap['total_masuk'] - $rekap['total_keluar'];
        $periode = 'Semua Data';
        $bulan = null;
        $tahun = null;
        
        $pdf = Pdf::loadView('pdf.buku-kas', compact('transaksi', 'rekap', 'bulan', 'tahun', 'periode'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('buku_kas_lengkap.pdf');
    }
    
    /**
     * Download Excel Buku Kas per bulan
     */
    public function downloadExcel(int $bulan, int $tahun)
    {
        $filename = 'Buku_Kas_' . TransaksiKas::$namaBulan[$bulan] . '_' . $tahun . '.xlsx';
        
        return Excel::download(new TransaksiKasExport($bulan, $tahun), $filename);
    }
    
    /**
     * Download Excel Buku Kas per tahun (12 bulan)
     */
    public function downloadExcelTahunan(int $tahun)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        
        return Excel::download(new TransaksiKasExport(null, $tahun), 'Buku_Kas_Tahun_' . $tahun . '.xlsx');
    }
    
    /**
     * Download Excel Buku Kas semua data
     */
    public function downloadExcelSemua()
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');
        
        return Excel::download(new TransaksiKasExport(null, null), 'Buku_Kas_Lengkap.xlsx');
    }
}
