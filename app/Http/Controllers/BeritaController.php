<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman berita publik
 */
class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita dengan pagination
     */
    public function index(Request $request)
    {
        $query = Berita::published()->latest();
        
        // Search functionality
        if ($request->has('cari') && $request->cari) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('konten', 'like', "%{$cari}%");
            });
        }
        
        $berita = $query->paginate(9)->withQueryString();
        
        return view('public.berita.index', compact('berita'));
    }
    
    /**
     * Menampilkan detail berita berdasarkan slug
     */
    public function show($slug)
    {
        $berita = Berita::published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Increment view count
        $berita->incrementViews();
        
        // Berita terkait (random 3 berita lainnya)
        $beritaTerkait = Berita::published()
            ->where('id', '!=', $berita->id)
            ->inRandomOrder()
            ->take(3)
            ->get();
        
        return view('public.berita.show', compact('berita', 'beritaTerkait'));
    }
}
