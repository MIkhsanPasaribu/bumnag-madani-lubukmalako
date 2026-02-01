<?php

namespace App\Http\Controllers;

use App\Models\ProfilBumnag;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman profil publik BUMNag
 */
class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil BUMNag
     */
    public function index()
    {
        $profil = ProfilBumnag::getProfil();
        
        if (!$profil) {
            abort(404, 'Profil BUMNag belum tersedia');
        }
        
        return view('public.profil', compact('profil'));
    }
}
