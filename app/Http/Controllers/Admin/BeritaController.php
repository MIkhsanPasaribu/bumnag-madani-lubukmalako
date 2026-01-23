<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest('published_at')->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'penulis' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']) . '-' . time();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['published_at'] ?? now();

        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'penulis' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $berita->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
