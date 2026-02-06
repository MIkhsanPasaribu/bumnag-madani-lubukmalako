<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman berita publik
 * Mendukung fitur: Kategori, Featured, Pinned, Related News
 */
class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita dengan pagination
     */
    public function index(Request $request)
    {
        $query = Berita::with('kategori')->published();
        
        // Filter berdasarkan kategori (via query param)
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }
        
        // Search functionality
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        // Urutkan berdasarkan tanggal publikasi terbaru
        $berita = $query->orderBy('tanggal_publikasi', 'desc')->paginate(9)->withQueryString();
        
        // Ambil berita featured untuk highlight
        $beritaFeatured = Berita::with('kategori')
            ->published()
            ->featured()
            ->latest()
            ->limit(3)
            ->get();
        
        // Ambil semua kategori untuk filter
        $kategoris = KategoriBerita::active()->ordered()->withCount([
            'berita' => function ($q) {
                $q->published();
            }
        ])->get();
        
        // Kategori aktif (jika ada filter)
        $kategoriAktif = $request->filled('kategori') 
            ? $kategoris->firstWhere('slug', $request->kategori) 
            : null;
        
        return view('public.berita.index', compact(
            'berita',
            'beritaFeatured',
            'kategoris',
            'kategoriAktif'
        ));
    }
    
    /**
     * Menampilkan berita berdasarkan kategori
     */
    public function byKategori($slug)
    {
        $kategori = KategoriBerita::where('slug', $slug)->firstOrFail();
        
        $berita = Berita::with('kategori')
            ->published()
            ->byKategori($kategori->id)
            ->orderBy('tanggal_publikasi', 'desc')
            ->paginate(9);
        
        // Ambil semua kategori untuk sidebar
        $kategoris = KategoriBerita::active()->ordered()->withCount([
            'berita' => function ($q) {
                $q->published();
            }
        ])->get();
        
        return view('public.berita.kategori', compact('berita', 'kategori', 'kategoris'));
    }
    
    /**
     * Menampilkan detail berita berdasarkan slug
     */
    public function show($slug)
    {
        $berita = Berita::with(['kategori', 'gambarGallery', 'penulis'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Increment view count
        $berita->incrementViews();
        
        // Berita terkait berdasarkan kategori
        $beritaTerkait = $berita->getRelatedByKategori(4);
        
        // Jika berita terkait kurang dari 4, tambahkan berita random
        if ($beritaTerkait->count() < 4) {
            $excludeIds = $beritaTerkait->pluck('id')->push($berita->id)->toArray();
            $additionalBerita = Berita::published()
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit(4 - $beritaTerkait->count())
                ->get();
            $beritaTerkait = $beritaTerkait->concat($additionalBerita);
        }
        
        // Ambil kategori untuk sidebar
        $kategoris = KategoriBerita::active()->ordered()->withCount([
            'berita' => function ($q) {
                $q->published();
            }
        ])->get();
        
        return view('public.berita.show', compact('berita', 'beritaTerkait', 'kategoris'));
    }
}
