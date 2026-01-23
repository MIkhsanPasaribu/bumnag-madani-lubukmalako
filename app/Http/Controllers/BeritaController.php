<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::published()
            ->latest('published_at')
            ->paginate(9);

        return view('berita.index', compact('berita'));
    }

    public function show(Berita $berita)
    {
        if (!$berita->is_published) {
            abort(404);
        }

        $berita->increment('views');

        $beritaLainnya = Berita::published()
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('berita.show', compact('berita', 'beritaLainnya'));
    }
}
