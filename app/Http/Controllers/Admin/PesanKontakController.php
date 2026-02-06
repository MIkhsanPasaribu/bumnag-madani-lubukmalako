<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

/**
 * Controller admin untuk mengelola pesan kontak dari pengunjung
 */
class PesanKontakController extends Controller
{
    /**
     * Menampilkan daftar pesan kontak
     */
    public function index(Request $request)
    {
        $query = PesanKontak::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%")
                  ->orWhere('subjek', 'like', "%{$cari}%")
                  ->orWhere('pesan', 'like', "%{$cari}%");
            });
        }

        // Statistik
        $totalPesan = PesanKontak::count();
        $totalBelumDibaca = PesanKontak::belumDibaca()->count();
        $totalDibaca = PesanKontak::dibaca()->count();
        $totalDibalas = PesanKontak::dibalas()->count();

        $pesanList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.pesan-kontak.index', compact(
            'pesanList',
            'totalPesan',
            'totalBelumDibaca',
            'totalDibaca',
            'totalDibalas'
        ));
    }

    /**
     * Menampilkan detail pesan kontak
     */
    public function show(PesanKontak $pesan_kontak)
    {
        // Tandai sebagai dibaca saat dilihat
        $pesan_kontak->tandaiDibaca();

        return view('admin.pesan-kontak.show', compact('pesan_kontak'));
    }

    /**
     * Menghapus pesan kontak
     */
    public function destroy(PesanKontak $pesan_kontak)
    {
        $pesan_kontak->delete();

        return redirect()->route('admin.pesan-kontak.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * Tandai pesan sebagai dibaca
     */
    public function tandaiDibaca(PesanKontak $pesan_kontak)
    {
        $pesan_kontak->tandaiDibaca();

        return redirect()->back()
            ->with('success', 'Pesan ditandai sebagai dibaca.');
    }

    /**
     * Tandai semua pesan sebagai dibaca
     */
    public function tandaiSemuaDibaca()
    {
        PesanKontak::belumDibaca()->update([
            'status' => 'dibaca',
            'dibaca_at' => now(),
        ]);

        return redirect()->route('admin.pesan-kontak.index')
            ->with('success', 'Semua pesan ditandai sebagai dibaca.');
    }
}
