<?php

namespace App\Http\Controllers;

use App\Models\LaporanTahunan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller untuk halaman laporan tahunan publik
 */
class LaporanTahunanController extends Controller
{
    /**
     * Menampilkan daftar laporan tahunan dengan pagination
     */
    public function index(Request $request)
    {
        $query = LaporanTahunan::published()->orderBy('tahun', 'desc');
        
        // Search functionality
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        $laporanTahunan = $query->paginate(12)->withQueryString();
        
        // Statistik
        $totalLaporan = LaporanTahunan::published()->count();
        $totalDownloads = LaporanTahunan::published()->sum('download_count');
        $yearsWithReports = LaporanTahunan::getYearsWithReports();
        
        return view('public.laporan-tahunan.index', compact(
            'laporanTahunan',
            'totalLaporan',
            'totalDownloads',
            'yearsWithReports'
        ));
    }
    
    /**
     * Menampilkan detail laporan tahunan berdasarkan slug
     */
    public function show($slug)
    {
        $laporan = LaporanTahunan::published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Laporan lainnya (tahun terdekat)
        $laporanLain = LaporanTahunan::published()
            ->where('id', '!=', $laporan->id)
            ->orderBy('tahun', 'desc')
            ->take(4)
            ->get();
        
        // Previous laporan (tahun sebelumnya)
        $prevLaporan = LaporanTahunan::published()
            ->where('tahun', '<', $laporan->tahun)
            ->orderBy('tahun', 'desc')
            ->first();
        
        // Next laporan (tahun berikutnya)
        $nextLaporan = LaporanTahunan::published()
            ->where('tahun', '>', $laporan->tahun)
            ->orderBy('tahun', 'asc')
            ->first();
        
        return view('public.laporan-tahunan.show', compact('laporan', 'laporanLain', 'prevLaporan', 'nextLaporan'));
    }
    
    /**
     * Download file laporan dan increment counter
     */
    public function download($slug)
    {
        $laporan = LaporanTahunan::published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        $filePath = public_path('uploads/laporan-tahunan/' . $laporan->file_laporan);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }
        
        // Increment download counter
        $laporan->incrementDownload();
        
        // Download file dengan nama asli
        $downloadName = $laporan->file_original_name ?? $laporan->file_laporan;
        
        return response()->download($filePath, $downloadName);
    }
}
