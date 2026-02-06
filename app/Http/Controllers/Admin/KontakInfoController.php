<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakInfo;
use Illuminate\Http\Request;

/**
 * Controller admin untuk mengelola informasi kontak
 */
class KontakInfoController extends Controller
{
    /**
     * Menampilkan form edit informasi kontak
     */
    public function edit()
    {
        $kontak = KontakInfo::getInstance();

        return view('admin.kontak-info.edit', compact('kontak'));
    }

    /**
     * Menyimpan perubahan informasi kontak
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:500',
            'google_maps_embed' => 'nullable|string|max:1000',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:30',
        ]);

        $kontak = KontakInfo::getInstance();
        $kontak->update($validated);

        return redirect()->route('admin.kontak-info.edit')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}
