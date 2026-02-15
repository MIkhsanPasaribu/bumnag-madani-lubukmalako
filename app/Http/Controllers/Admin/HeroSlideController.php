<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroSlideRequest;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola Hero Slides di admin
 */
class HeroSlideController extends Controller
{
    /**
     * Tampilkan daftar hero slides
     */
    public function index(Request $request)
    {
        $query = HeroSlide::with('creator');

        // Search
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // Filter status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $heroSlides = $query->ordered()->paginate(10)->withQueryString();

        // Stats
        $totalSlides = HeroSlide::count();
        $totalAktif = HeroSlide::where('status', 'aktif')->count();
        $totalTidakAktif = HeroSlide::where('status', 'tidak_aktif')->count();

        return view('admin.hero-slide.index', compact('heroSlides', 'totalSlides', 'totalAktif', 'totalTidakAktif'));
    }

    /**
     * Tampilkan form tambah hero slide
     */
    public function create()
    {
        return view('admin.hero-slide.create');
    }

    /**
     * Simpan hero slide baru
     */
    public function store(HeroSlideRequest $request)
    {
        $validated = $request->validated();

        // Handle file upload
        $validated['media_path'] = $this->uploadMedia($request->file('media_file'), $validated['tipe_media']);
        $validated['created_by'] = Auth::id();
        $validated['urutan'] = $validated['urutan'] ?? (HeroSlide::max('urutan') + 1);

        unset($validated['media_file']);

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slide.index')
            ->with('success', 'Hero slide berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit hero slide
     */
    public function edit(HeroSlide $hero_slide)
    {
        return view('admin.hero-slide.edit', compact('hero_slide'));
    }

    /**
     * Update hero slide
     */
    public function update(HeroSlideRequest $request, HeroSlide $hero_slide)
    {
        $validated = $request->validated();

        // Handle file upload (jika ada file baru)
        if ($request->hasFile('media_file')) {
            // Hapus media lama
            $this->deleteMedia($hero_slide->media_path);

            $validated['media_path'] = $this->uploadMedia($request->file('media_file'), $validated['tipe_media']);
        }

        unset($validated['media_file']);

        $hero_slide->update($validated);

        return redirect()->route('admin.hero-slide.index')
            ->with('success', 'Hero slide berhasil diperbarui.');
    }

    /**
     * Hapus hero slide
     */
    public function destroy(HeroSlide $hero_slide)
    {
        // Hapus file media
        $this->deleteMedia($hero_slide->media_path);

        $hero_slide->delete();

        return redirect()->route('admin.hero-slide.index')
            ->with('success', 'Hero slide berhasil dihapus.');
    }

    /**
     * Toggle status aktif/tidak aktif
     */
    public function toggleStatus(HeroSlide $hero_slide)
    {
        $hero_slide->update([
            'status' => $hero_slide->status === 'aktif' ? 'tidak_aktif' : 'aktif',
        ]);

        $statusLabel = $hero_slide->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Hero slide berhasil {$statusLabel}.");
    }

    /**
     * Update urutan hero slides
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:hero_slides,id',
            'items.*.urutan' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
                HeroSlide::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Upload media file (gambar atau video)
     */
    private function uploadMedia($file, string $tipeMedia): string
    {
        $uploadDir = public_path('uploads/hero');

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $prefix = $tipeMedia === 'video' ? 'video_' : 'img_';
        $filename = $prefix . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $file->move($uploadDir, $filename);

        return $filename;
    }

    /**
     * Hapus file media dari disk
     */
    private function deleteMedia(?string $mediaPath): void
    {
        if ($mediaPath) {
            $fullPath = public_path('uploads/hero/' . $mediaPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
