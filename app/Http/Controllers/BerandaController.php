<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\LaporanKeuangan;
use App\Models\Pengumuman;
use App\Models\ProfilBumnag;

class BerandaController extends Controller
{
    public function index()
    {
        $profil = ProfilBumnag::first();
        $beritaTerbaru = Berita::published()->latest('published_at')->take(3)->get();
        $pengumumanAktif = Pengumuman::active()->latest()->take(5)->get();
        $laporanTerbaru = LaporanKeuangan::published()->latest()->first();
        
        $statistikKeuangan = LaporanKeuangan::published()
            ->selectRaw('tahun, SUM(pendapatan) as total_pendapatan, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->take(5)
            ->get();

        return view('beranda', compact(
            'profil',
            'beritaTerbaru',
            'pengumumanAktif',
            'laporanTerbaru',
            'statistikKeuangan'
        ));
    }
}
