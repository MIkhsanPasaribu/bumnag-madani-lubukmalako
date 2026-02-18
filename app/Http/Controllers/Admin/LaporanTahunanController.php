<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanTahunanRequest;
use App\Models\LaporanTahunan;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk mengelola laporan tahunan di admin
 * Termasuk fitur: Upload PDF, Download tracking, SEO, Archive
 */
class LaporanTahunanController extends Controller
{
    use HasFileUpload;

    /**
     * Folder untuk menyimpan file laporan
     */
    private const UPLOAD_FOLDER = 'laporan-tahunan';

    /**
     * Menampilkan daftar laporan tahunan
     */
    public function index(Request $request)
    {
        $query = LaporanTahunan::with('uploader');
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter archived (soft deleted)
        if ($request->filled('archived') && $request->archived === '1') {
            $query->onlyTrashed();
        }
        
        // Search
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        $laporanTahunan = $query->latest()->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalLaporan = LaporanTahunan::count();
        $totalPublished = LaporanTahunan::published()->count();
        $totalDraft = LaporanTahunan::draft()->count();
        $totalDownloads = LaporanTahunan::sum('download_count');
        $totalArchived = LaporanTahunan::onlyTrashed()->count();
        
        return view('admin.laporan-tahunan.index', compact(
            'laporanTahunan',
            'totalLaporan',
            'totalPublished',
            'totalDraft',
            'totalDownloads',
            'totalArchived'
        ));
    }
    
    /**
     * Menampilkan form tambah laporan tahunan
     */
    public function create()
    {
        return view('admin.laporan-tahunan.create');
    }
    
    /**
     * Menyimpan laporan tahunan baru
     */
    public function store(LaporanTahunanRequest $request)
    {
        $validated = $request->validated();
        
        // Handle upload cover image
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $validated['cover_image'] = $this->uploadFile(
                $cover,
                self::UPLOAD_FOLDER . '/covers',
                'cover-' . $validated['tahun']
            );
        }
        
        // Handle upload file laporan
        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            // Ambil info file SEBELUM move (karena move() menghapus file temp)
            $validated['file_original_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            
            $validated['file_laporan'] = $this->uploadFile(
                $file,
                self::UPLOAD_FOLDER,
                'laporan-' . $validated['tahun']
            );
        }
        
        // Set uploader
        $validated['uploaded_by'] = Auth::id();
        
        // Handle tanggal publikasi
        if ($validated['status'] === 'published' && !$request->filled('tanggal_publikasi')) {
            $validated['tanggal_publikasi'] = now();
        }
        
        LaporanTahunan::create($validated);
        
        return redirect()->route('admin.laporan-tahunan.index')
            ->with('success', 'Laporan tahunan berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan form edit laporan tahunan
     */
    public function edit(LaporanTahunan $laporanTahunan)
    {
        return view('admin.laporan-tahunan.edit', compact('laporanTahunan'));
    }
    
    /**
     * Menyimpan perubahan laporan tahunan
     */
    public function update(LaporanTahunanRequest $request, LaporanTahunan $laporanTahunan)
    {
        $validated = $request->validated();
        
        // Handle upload cover image baru
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $validated['cover_image'] = $this->handleFileUpload(
                $cover,
                $laporanTahunan->cover_image,
                self::UPLOAD_FOLDER . '/covers',
                'cover-' . $validated['tahun']
            );
        }
        
        // Handle upload file baru dengan auto-delete file lama
        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            
            // Ambil info file SEBELUM move (karena move() menghapus file temp)
            $validated['file_original_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            
            $validated['file_laporan'] = $this->handleFileUpload(
                $file,
                $laporanTahunan->file_laporan,
                self::UPLOAD_FOLDER,
                'laporan-' . $validated['tahun']
            );
        }
        
        // Handle tanggal publikasi
        if ($validated['status'] === 'published' && 
            $laporanTahunan->status !== 'published' && 
            !$request->filled('tanggal_publikasi')) {
            $validated['tanggal_publikasi'] = now();
        }
        
        $laporanTahunan->update($validated);
        
        return redirect()->route('admin.laporan-tahunan.index')
            ->with('success', 'Laporan tahunan berhasil diperbarui.');
    }
    
    /**
     * Menghapus laporan tahunan (soft delete / archive)
     */
    public function destroy(LaporanTahunan $laporanTahunan)
    {
        $laporanTahunan->delete(); // Soft delete
        
        return redirect()->route('admin.laporan-tahunan.index')
            ->with('success', 'Laporan tahunan berhasil diarsipkan.');
    }

    /**
     * Menghapus laporan tahunan secara permanen
     */
    public function forceDestroy($id)
    {
        $laporanTahunan = LaporanTahunan::withTrashed()->findOrFail($id);
        
        // Hapus cover image
        $this->deleteFile($laporanTahunan->cover_image, self::UPLOAD_FOLDER . '/covers');
        
        // Hapus file laporan
        $this->deleteFile($laporanTahunan->file_laporan, self::UPLOAD_FOLDER);
        
        $laporanTahunan->forceDelete();
        
        return redirect()->route('admin.laporan-tahunan.index')
            ->with('success', 'Laporan tahunan berhasil dihapus permanen.');
    }

    /**
     * Restore laporan tahunan yang diarsipkan
     */
    public function restore($id)
    {
        $laporanTahunan = LaporanTahunan::onlyTrashed()->findOrFail($id);
        $laporanTahunan->restore();
        
        return redirect()->route('admin.laporan-tahunan.index')
            ->with('success', 'Laporan tahunan berhasil dipulihkan dari arsip.');
    }
}
