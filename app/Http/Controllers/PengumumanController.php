<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman pengumuman publik
 */
class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar pengumuman dengan pagination
     */
    public function index(Request $request)
    {
        $query = Pengumuman::aktif()->byPrioritas();
        
        // Filter berdasarkan prioritas
        if ($request->has('prioritas') && $request->prioritas) {
            $query->prioritas($request->prioritas);
        }
        
        // Search functionality
        if ($request->has('cari') && $request->cari) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('konten', 'like', "%{$cari}%");
            });
        }
        
        $pengumuman = $query->paginate(9)->withQueryString();
        
        return view('public.pengumuman.index', compact('pengumuman'));
    }
    
    /**
     * Menampilkan detail pengumuman berdasarkan slug
     */
    public function show($slug)
    {
        $pengumuman = Pengumuman::aktif()
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Pengumuman lainnya
        $pengumumanLain = Pengumuman::aktif()
            ->where('id', '!=', $pengumuman->id)
            ->byPrioritas()
            ->take(3)
            ->get();
        
        return view('public.pengumuman.show', compact('pengumuman', 'pengumumanLain'));
    }
}
