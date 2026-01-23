<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    public function index()
    {
        $laporan = LaporanKeuangan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->paginate(12);
        return view('admin.keuangan.index', compact('laporan'));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2099',
            'bulan' => 'required|integer|min:1|max:12',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf|max:10240',
            'is_published' => 'boolean',
        ]);

        $exists = LaporanKeuangan::where('tahun', $validated['tahun'])
            ->where('bulan', $validated['bulan'])
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['bulan' => 'Laporan untuk bulan dan tahun tersebut sudah ada.'])->withInput();
        }

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('laporan-keuangan', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        LaporanKeuangan::create($validated);

        return redirect()->route('admin.keuangan.index')->with('success', 'Laporan keuangan berhasil ditambahkan.');
    }

    public function edit(LaporanKeuangan $keuangan)
    {
        return view('admin.keuangan.edit', ['laporan' => $keuangan]);
    }

    public function update(Request $request, LaporanKeuangan $keuangan)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2099',
            'bulan' => 'required|integer|min:1|max:12',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf|max:10240',
            'is_published' => 'boolean',
        ]);

        $exists = LaporanKeuangan::where('tahun', $validated['tahun'])
            ->where('bulan', $validated['bulan'])
            ->where('id', '!=', $keuangan->id)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['bulan' => 'Laporan untuk bulan dan tahun tersebut sudah ada.'])->withInput();
        }

        if ($request->hasFile('dokumen')) {
            if ($keuangan->dokumen) {
                Storage::disk('public')->delete($keuangan->dokumen);
            }
            $validated['dokumen'] = $request->file('dokumen')->store('laporan-keuangan', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $keuangan->update($validated);

        return redirect()->route('admin.keuangan.index')->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    public function destroy(LaporanKeuangan $keuangan)
    {
        if ($keuangan->dokumen) {
            Storage::disk('public')->delete($keuangan->dokumen);
        }
        
        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
