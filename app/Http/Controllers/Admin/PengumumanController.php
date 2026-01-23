<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->lampiran) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }
        
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
