<?php

namespace App\Http\Controllers;

use App\Models\GaleriBumnag;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman public galeri BUMNag
 */
class GaleriBumnagController extends Controller
{
    /**
     * Tampilkan halaman galeri public
     */
    public function index(Request $request)
    {
        $query = GaleriBumnag::aktif();
        
        // Search
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        $galeri = $query->ordered()->paginate(20)->withQueryString();
        
        // Get available years for filter
        $tahunList = GaleriBumnag::aktif()
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('public.galeri-bumnag.index', compact('galeri', 'tahunList'));
    }
}
