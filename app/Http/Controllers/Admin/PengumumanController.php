<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controller untuk mengelola pengumuman di admin
 */
class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar pengumuman
     */
    public function index(Request $request)
    {
        $query = Pengumuman::latest();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan prioritas
        if ($request->has('prioritas') && $request->prioritas) {
            $query->prioritas($request->prioritas);
        }
        
        // Search
        if ($request->has('cari') && $request->cari) {
            $query->where('judul', 'like', '%' . $request->cari . '%');
        }
        
        $pengumuman = $query->paginate(10)->withQueryString();
        
        // Statistik untuk cards
        $totalAktif = Pengumuman::where('status', 'aktif')->count();
        $totalPrioritasTinggi = Pengumuman::where('prioritas', 'tinggi')->count();
        $totalTidakAktif = Pengumuman::where('status', 'tidak_aktif')->count();
        
        return view('admin.pengumuman.index', compact(
            'pengumuman',
            'totalAktif',
            'totalPrioritasTinggi',
            'totalTidakAktif'
        ));
    }
    
    /**
     * Menampilkan form tambah pengumuman
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }
    
    /**
     * Menyimpan pengumuman baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'konten.required' => 'Konten pengumuman wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus setelah tanggal mulai.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5MB.',
        ]);
        
        // Handle upload lampiran
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pengumuman'), $filename);
            $validated['lampiran'] = $filename;
        }
        
        Pengumuman::create($validated);
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan form edit pengumuman
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }
    
    /**
     * Menyimpan perubahan pengumuman
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);
        
        // Handle upload lampiran baru
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama
            if ($pengumuman->lampiran && file_exists(public_path('uploads/pengumuman/' . $pengumuman->lampiran))) {
                unlink(public_path('uploads/pengumuman/' . $pengumuman->lampiran));
            }
            
            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pengumuman'), $filename);
            $validated['lampiran'] = $filename;
        }
        
        $pengumuman->update($validated);
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }
    
    /**
     * Menghapus pengumuman
     */
    public function destroy(Pengumuman $pengumuman)
    {
        // Hapus lampiran
        if ($pengumuman->lampiran && file_exists(public_path('uploads/pengumuman/' . $pengumuman->lampiran))) {
            unlink(public_path('uploads/pengumuman/' . $pengumuman->lampiran));
        }
        
        $pengumuman->delete();
        
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
