<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriBeritaRequest;
use App\Models\KategoriBerita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller untuk mengelola Kategori Berita di Admin Panel
 */
class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = KategoriBerita::withCount('berita');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $kategoris = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.kategori-berita.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $maxUrutan = KategoriBerita::max('urutan') ?? 0;
        
        return view('admin.kategori-berita.create', [
            'suggestedUrutan' => $maxUrutan + 1,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriBeritaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Set default values
        $data['is_active'] = $data['is_active'] ?? true;
        $data['urutan'] = $data['urutan'] ?? (KategoriBerita::max('urutan') ?? 0) + 1;

        KategoriBerita::create($data);

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriBerita $kategoriBerita): View
    {
        $kategoriBerita->loadCount('berita');
        
        // Load recent berita in this category
        $recentBerita = $kategoriBerita->berita()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.kategori-berita.show', compact('kategoriBerita', 'recentBerita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriBerita $kategoriBerita): View
    {
        return view('admin.kategori-berita.edit', compact('kategoriBerita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriBeritaRequest $request, KategoriBerita $kategoriBerita): RedirectResponse
    {
        $data = $request->validated();
        
        $kategoriBerita->update($data);

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriBerita $kategoriBerita): RedirectResponse
    {
        // Check if category has berita
        if ($kategoriBerita->berita()->exists()) {
            return redirect()
                ->route('admin.kategori-berita.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki berita terkait.');
        }

        $kategoriBerita->delete();

        return redirect()
            ->route('admin.kategori-berita.index')
            ->with('success', 'Kategori berita berhasil dihapus.');
    }

    /**
     * Toggle status aktif kategori
     */
    public function toggleStatus(KategoriBerita $kategoriBerita): RedirectResponse
    {
        $kategoriBerita->update([
            'is_active' => !$kategoriBerita->is_active,
        ]);

        $status = $kategoriBerita->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Kategori berhasil {$status}.");
    }

    /**
     * Update urutan kategori (untuk drag-drop reorder)
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'exists:kategori_berita,id'],
            'orders.*.urutan' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->orders as $order) {
            KategoriBerita::where('id', $order['id'])->update(['urutan' => $order['urutan']]);
        }

        return redirect()
            ->back()
            ->with('success', 'Urutan kategori berhasil diperbarui.');
    }
}
