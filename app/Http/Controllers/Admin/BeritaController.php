<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\Berita;
use App\Models\GambarBerita;
use App\Models\KategoriBerita;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola berita di admin
 * Termasuk fitur: Kategori, Gallery, Featured/Pinned, SEO, Scheduling, Archive
 */
class BeritaController extends Controller
{
    use HasFileUpload;

    /**
     * Folder untuk menyimpan gambar berita
     */
    private const UPLOAD_FOLDER = 'berita';
    private const GALLERY_FOLDER = 'berita/gallery';
    private const LAMPIRAN_FOLDER = 'berita/lampiran';

    /**
     * Menampilkan daftar berita
     */
    public function index(Request $request)
    {
        $query = Berita::with(['penulis', 'kategori']);
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'scheduled') {
                $query->scheduled();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
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
        
        $berita = $query->latest()->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalPublished = Berita::published()->count();
        $totalDraft = Berita::draft()->count();
        $totalScheduled = Berita::scheduled()->count();
        $totalViews = Berita::sum('views');
        $totalArchived = Berita::onlyTrashed()->count();
        
        // Data untuk filter
        $kategoris = KategoriBerita::active()->ordered()->get();
        
        return view('admin.berita.index', compact(
            'berita',
            'totalPublished',
            'totalDraft',
            'totalScheduled',
            'totalViews',
            'totalArchived',
            'kategoris'
        ));
    }
    
    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        $kategoris = KategoriBerita::active()->ordered()->get();
        
        return view('admin.berita.create', compact('kategoris'));
    }
    
    /**
     * Menyimpan berita baru
     */
    public function store(BeritaRequest $request)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();
        
        try {
            // Handle upload gambar utama
            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $this->uploadFile(
                    $request->file('gambar'),
                    self::UPLOAD_FOLDER,
                    $validated['judul']
                );
            }
            
            // Handle upload lampiran
            if ($request->hasFile('lampiran')) {
                $lampiranFile = $request->file('lampiran');
                $validated['lampiran'] = $this->uploadFile(
                    $lampiranFile,
                    self::LAMPIRAN_FOLDER,
                    $validated['judul'] . '-lampiran'
                );
                $validated['lampiran_original_name'] = $lampiranFile->getClientOriginalName();
                $validated['lampiran_size'] = $lampiranFile->getSize();
            }
            
            // Set penulis
            $validated['penulis_id'] = Auth::id();
            
            // Handle tanggal publikasi dan scheduling
            if ($validated['status'] === 'published') {
                if ($request->filled('tanggal_publikasi') && $request->is_scheduled) {
                    // Scheduled publishing
                    $validated['is_scheduled'] = true;
                } else {
                    // Immediate publish
                    $validated['tanggal_publikasi'] = now();
                    $validated['is_scheduled'] = false;
                }
            }
            
            $berita = Berita::create($validated);
            
            // Handle gallery images
            if ($request->hasFile('gallery')) {
                $this->storeGalleryImages($berita, $request->file('gallery'));
            }
            
            DB::commit();
            
            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan berita: ' . $e->getMessage());
        }
    }
    
    /**
     * Menampilkan form edit berita
     */
    public function edit(Berita $berita)
    {
        $kategoris = KategoriBerita::active()->ordered()->get();
        $berita->load('gambarGallery');
        
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }
    
    /**
     * Menyimpan perubahan berita
     */
    public function update(BeritaRequest $request, Berita $berita)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();
        
        try {
            // Handle upload gambar baru dengan auto-delete gambar lama
            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $this->handleFileUpload(
                    $request->file('gambar'),
                    $berita->gambar,
                    self::UPLOAD_FOLDER,
                    $validated['judul']
                );
            }
            
            // Handle upload lampiran baru dengan auto-delete lampiran lama
            if ($request->hasFile('lampiran')) {
                $lampiranFile = $request->file('lampiran');
                $validated['lampiran'] = $this->handleFileUpload(
                    $lampiranFile,
                    $berita->lampiran,
                    self::LAMPIRAN_FOLDER,
                    $validated['judul'] . '-lampiran'
                );
                $validated['lampiran_original_name'] = $lampiranFile->getClientOriginalName();
                $validated['lampiran_size'] = $lampiranFile->getSize();
            }
            
            // Handle hapus lampiran (jika checkbox hapus dicentang)
            if ($request->boolean('hapus_lampiran') && $berita->lampiran) {
                $this->deleteFile($berita->lampiran, self::LAMPIRAN_FOLDER);
                $validated['lampiran'] = null;
                $validated['lampiran_original_name'] = null;
                $validated['lampiran_size'] = 0;
            }
            
            // Handle tanggal publikasi
            if ($validated['status'] === 'published') {
                if ($request->filled('tanggal_publikasi') && $request->is_scheduled) {
                    $validated['is_scheduled'] = true;
                } elseif ($berita->status !== 'published') {
                    // Baru dipublish
                    $validated['tanggal_publikasi'] = now();
                    $validated['is_scheduled'] = false;
                }
            }
            
            $berita->update($validated);
            
            // Handle gallery images
            if ($request->hasFile('gallery')) {
                $this->storeGalleryImages($berita, $request->file('gallery'));
            }
            
            // Handle deleted gallery images (dari form edit)
            if ($request->filled('deleted_gallery_ids')) {
                $this->deleteGalleryImages($request->deleted_gallery_ids);
            }
            
            // Handle deleted gallery images (format alternatif)
            if ($request->filled('delete_gallery')) {
                $this->deleteGalleryImages($request->delete_gallery);
            }
            
            DB::commit();
            
            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }
    
    /**
     * Menghapus berita (soft delete / archive)
     */
    public function destroy(Berita $berita)
    {
        $berita->delete(); // Soft delete
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diarsipkan.');
    }

    /**
     * Menghapus berita secara permanen
     */
    public function forceDestroy($id)
    {
        $berita = Berita::onlyTrashed()->findOrFail($id);
        
        // Hapus gambar utama
        $this->deleteFile($berita->gambar, self::UPLOAD_FOLDER);
        
        // Hapus lampiran
        if ($berita->lampiran) {
            $this->deleteFile($berita->lampiran, self::LAMPIRAN_FOLDER);
        }
        
        // Hapus gallery images
        foreach ($berita->gambarGallery as $gambar) {
            $this->deleteFile($gambar->file_name, self::GALLERY_FOLDER);
        }
        
        $berita->forceDelete();
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus permanen.');
    }

    /**
     * Restore berita yang diarsipkan
     */
    public function restore($id)
    {
        $berita = Berita::onlyTrashed()->findOrFail($id);
        $berita->restore();
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dipulihkan dari arsip.');
    }

    /**
     * Toggle status featured
     */
    public function toggleFeatured(Berita $berita)
    {
        $berita->toggleFeatured();
        
        $status = $berita->is_featured ? 'ditambahkan ke' : 'dihapus dari';
        
        return redirect()->back()
            ->with('success', "Berita berhasil {$status} featured.");
    }

    /**
     * Toggle status pinned
     */
    public function togglePinned(Berita $berita)
    {
        $berita->togglePinned();
        
        $status = $berita->is_pinned ? 'di-pin' : 'di-unpin';
        
        return redirect()->back()
            ->with('success', "Berita berhasil {$status}.");
    }

    /**
     * Menyimpan gambar gallery
     */
    private function storeGalleryImages(Berita $berita, array $files): void
    {
        $urutan = $berita->gambarGallery()->max('urutan') ?? 0;
        
        foreach ($files as $file) {
            $urutan++;
            
            // Ambil info file SEBELUM move (karena move() menghapus file temp)
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            
            $fileName = $this->uploadFile(
                $file,
                self::GALLERY_FOLDER,
                $berita->judul . '-gallery-' . $urutan
            );
            
            $berita->gambarGallery()->create([
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
                'urutan' => $urutan,
            ]);
        }
    }

    /**
     * Menghapus gambar gallery berdasarkan ID
     */
    private function deleteGalleryImages(array $ids): void
    {
        $gambars = GambarBerita::whereIn('id', $ids)->get();
        
        foreach ($gambars as $gambar) {
            $this->deleteFile($gambar->file_name, self::GALLERY_FOLDER);
            $gambar->delete();
        }
    }
}
