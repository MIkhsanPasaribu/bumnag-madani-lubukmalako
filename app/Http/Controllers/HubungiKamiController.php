<?php

namespace App\Http\Controllers;

use App\Models\KontakInfo;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman Hubungi Kami (public)
 */
class HubungiKamiController extends Controller
{
    /**
     * Menampilkan halaman Hubungi Kami
     */
    public function index()
    {
        $kontak = KontakInfo::getInstance();

        return view('public.hubungi-kami', compact('kontak'));
    }

    /**
     * Menyimpan pesan dari form hubungi kami
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'organisasi' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:600',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subjek.required' => 'Subjek wajib diisi.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.max' => 'Pesan maksimal 600 karakter.',
        ]);

        PesanKontak::create($validated);

        return redirect()->route('hubungi-kami')
            ->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespons.');
    }
}
