<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilBumnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola profil BUMNag di admin
 */
class ProfilController extends Controller
{
    /**
     * Menampilkan form edit profil
     */
    public function edit()
    {
        $profil = ProfilBumnag::getProfil();
        
        // Jika belum ada profil, buat baru
        if (!$profil) {
            $profil = new ProfilBumnag();
        }
        
        return view('admin.profil.edit', compact('profil'));
    }
    
    /**
     * Menyimpan perubahan profil
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_bumnag' => 'required|string|max:255',
            'nama_nagari' => 'required|string|max:255',
            'alamat' => 'required|string|max:1000',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'sejarah' => 'nullable|string|max:10000',
            'visi' => 'nullable|string|max:5000',
            'misi' => 'nullable|string|max:5000',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'struktur_organisasi' => 'nullable|array',
            'struktur_organisasi.*.jabatan' => 'required_with:struktur_organisasi|string',
            'struktur_organisasi.*.nama' => 'required_with:struktur_organisasi|string|max:255',
            'struktur_organisasi.*.foto' => 'nullable|string',
            'foto_files.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_bumnag.required' => 'Nama BUMNag wajib diisi.',
            'nama_nagari.required' => 'Nama Nagari wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format URL tidak valid.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.max' => 'Ukuran logo maksimal 5MB.',
        ]);
        
        $profil = ProfilBumnag::first();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($profil && $profil->logo && file_exists(public_path('uploads/' . $profil->logo))) {
                unlink(public_path('uploads/' . $profil->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads'), $logoName);
            $validated['logo'] = $logoName;
        }
        
        // Handle struktur organisasi photos
        if ($request->has('struktur_organisasi')) {
            $struktur = $validated['struktur_organisasi'];
            
            // Ensure uploads/struktur directory exists
            $strukturDir = public_path('uploads/struktur');
            if (!is_dir($strukturDir)) {
                mkdir($strukturDir, 0755, true);
            }
            
            // Process photo uploads
            if ($request->hasFile('foto_files')) {
                foreach ($request->file('foto_files') as $index => $file) {
                    if ($file && isset($struktur[$index])) {
                        // Delete old photo if exists
                        if (!empty($struktur[$index]['foto']) && file_exists(public_path('uploads/struktur/' . $struktur[$index]['foto']))) {
                            unlink(public_path('uploads/struktur/' . $struktur[$index]['foto']));
                        }
                        
                        $photoName = 'struktur_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $file->move($strukturDir, $photoName);
                        $struktur[$index]['foto'] = $photoName;
                    }
                }
            }
            
            $validated['struktur_organisasi'] = $struktur;
        }
        
        if ($profil) {
            $profil->update($validated);
        } else {
            ProfilBumnag::create($validated);
        }
        
        return redirect()->route('admin.profil.edit')
            ->with('success', 'Profil BUMNag berhasil diperbarui.');
    }
}
