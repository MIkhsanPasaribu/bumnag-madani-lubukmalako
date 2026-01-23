<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilBumnag;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilBumnag::first();
        return view('admin.profil.index', compact('profil'));
    }

    public function edit()
    {
        $profil = ProfilBumnag::first();
        
        if (!$profil) {
            $profil = ProfilBumnag::create([
                'nama' => 'BUMNag Madani Lubuk Malako',
                'deskripsi' => '',
                'sejarah' => '',
                'visi' => '',
                'misi' => '',
            ]);
        }
        
        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $profil = ProfilBumnag::first();
        
        if ($profil) {
            $profil->update($validated);
        } else {
            ProfilBumnag::create($validated);
        }

        return redirect()->route('admin.profil.index')->with('success', 'Profil BUMNag berhasil diperbarui.');
    }
}
