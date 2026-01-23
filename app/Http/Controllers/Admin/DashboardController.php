<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\LaporanKeuangan;
use App\Models\ProfilBumnag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => Berita::count(),
            'pengumuman' => Pengumuman::count(),
            'laporan' => LaporanKeuangan::count(),
            'total_pendapatan' => LaporanKeuangan::sum('pendapatan'),
            'total_pengeluaran' => LaporanKeuangan::sum('pengeluaran'),
        ];
        
        $beritaTerbaru = Berita::latest('published_at')->take(5)->get();
        $pengumumanTerbaru = Pengumuman::where('is_active', true)->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'beritaTerbaru', 'pengumumanTerbaru'));
    }
}
