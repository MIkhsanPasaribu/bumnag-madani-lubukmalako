<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengumumanRequest;
use App\Models\Pengumuman;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola pengumuman di admin
 * Termasuk fitur: View tracking, Featured/Pinned, SEO, Archive
 */
class PengumumanController extends Controller
{
    use HasFileUpload;

    /**
     * Folder untuk menyimpan lampiran pengumuman
     */
    private const UPLOAD_FOLDER = 'pengumuman';

    /**
     * Menampilkan daftar pengumuman
     */
    public function index(Request $request)
    {
        $query = Pengumuman::query();
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->prioritas($request->prioritas);
        }

        // Filter featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Filter pinned
        if ($request->filled('pinned')) {
            $query->where('is_pinned', $request->pinned === '1');
        }

        // Filter archived (soft deleted)
        if ($request->filled('archived') && $request->archived === '1') {
            $query->onlyTrashed();
        }
        
        // Search
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        $pengumuman = $query->latest()->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalAktif = Pengumuman::aktif()->count();
        $totalPrioritasTinggi = Pengumuman::where('prioritas', 'tinggi')->count();
        $totalTidakAktif = Pengumuman::tidakAktif()->count();
        $totalViews = Pengumuman::sum('views');
        $totalArchived = Pengumuman::onlyTrashed()->count();
        
        return view('admin.pengumuman.index', compact(
            'pengumuman',
            'totalAktif',
            'totalPrioritasTinggi',
            'totalTidakAktif',
            'totalViews',
            'totalArchived'
        ));
    }
    
    /**
     * Menampilkan form tambah pengumuman
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }
    
    /**
     * Menyimpan pengumuman baru
     */
    public function store(PengumumanRequest $request)
    {
        $validated = $request->validated();
        
        // Handle upload lampiran
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $this->uploadFile(
                $request->file('lampiran'),
                self::UPLOAD_FOLDER,
                $validated['judul']
            );
        }
        
        Pengumuman::create($validated);
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan form edit pengumuman
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }
    
    /**
     * Menyimpan perubahan pengumuman
     */
    public function update(PengumumanRequest $request, Pengumuman $pengumuman)
    {
        $validated = $request->validated();
        
        // Handle upload lampiran baru dengan auto-delete lampiran lama
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $this->handleFileUpload(
                $request->file('lampiran'),
                $pengumuman->lampiran,
                self::UPLOAD_FOLDER,
                $validated['judul']
            );
        }
        
        $pengumuman->update($validated);
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }
    
    /**
     * Menghapus pengumuman (soft delete / archive)
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete(); // Soft delete
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diarsipkan.');
    }

    /**
     * Menghapus pengumuman secara permanen
     */
    public function forceDestroy($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->findOrFail($id);
        
        // Hapus lampiran
        $this->deleteFile($pengumuman->lampiran, self::UPLOAD_FOLDER);
        
        $pengumuman->forceDelete();
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus permanen.');
    }

    /**
     * Restore pengumuman yang diarsipkan
     */
    public function restore($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->findOrFail($id);
        $pengumuman->restore();
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dipulihkan dari arsip.');
    }

    /**
     * Toggle status featured
     */
    public function toggleFeatured(Pengumuman $pengumuman)
    {
        $pengumuman->toggleFeatured();
        
        $status = $pengumuman->is_featured ? 'ditambahkan ke' : 'dihapus dari';
        
        return redirect()->back()
            ->with('success', "Pengumuman berhasil {$status} featured.");
    }

    /**
     * Toggle status pinned
     */
    public function togglePinned(Pengumuman $pengumuman)
    {
        $pengumuman->togglePinned();
        
        $status = $pengumuman->is_pinned ? 'di-pin' : 'di-unpin';
        
        return redirect()->back()
            ->with('success', "Pengumuman berhasil {$status}.");
    }
}
