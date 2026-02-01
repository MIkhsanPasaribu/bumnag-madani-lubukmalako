<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controller untuk mengelola berita di admin
 */
class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita
     */
    public function index(Request $request)
    {
        $query = Berita::with('penulis')->latest();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Search
        if ($request->has('cari') && $request->cari) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }
        
        $berita = $query->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalPublished = Berita::where('status', 'published')->count();
        $totalDraft = Berita::where('status', 'draft')->count();
        $totalViews = Berita::sum('views');
        
        return view('admin.berita.index', compact(
            'berita',
            'totalPublished',
            'totalDraft',
            'totalViews'
        ));
    }
    
    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }
    
    /**
     * Menyimpan berita baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published',
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'konten.required' => 'Konten berita wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
        
        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/berita'), $filename);
            $validated['gambar'] = $filename;
        }
        
        // Set penulis dan tanggal publikasi
        $validated['penulis_id'] = Auth::id();
        if ($validated['status'] === 'published') {
            $validated['tanggal_publikasi'] = now();
        }
        
        Berita::create($validated);
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan form edit berita
     */
    public function edit(Berita $beritum)
    {
        return view('admin.berita.edit', ['berita' => $beritum]);
    }
    
    /**
     * Menyimpan perubahan berita
     */
    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);
        
        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($beritum->gambar && file_exists(public_path('uploads/berita/' . $beritum->gambar))) {
                unlink(public_path('uploads/berita/' . $beritum->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/berita'), $filename);
            $validated['gambar'] = $filename;
        }
        
        // Set tanggal publikasi jika baru dipublish
        if ($validated['status'] === 'published' && $beritum->status !== 'published') {
            $validated['tanggal_publikasi'] = now();
        }
        
        $beritum->update($validated);
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }
    
    /**
     * Menghapus berita
     */
    public function destroy(Berita $beritum)
    {
        // Hapus gambar
        if ($beritum->gambar && file_exists(public_path('uploads/berita/' . $beritum->gambar))) {
            unlink(public_path('uploads/berita/' . $beritum->gambar));
        }
        
        $beritum->delete();
        
        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
