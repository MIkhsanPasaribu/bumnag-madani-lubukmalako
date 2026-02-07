<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

/**
 * Controller untuk Unit Usaha mengelola laporan keuangan
 * Unit bisa input langsung (jika tanpa sub unit) atau melihat rekap sub unit
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Daftar laporan keuangan milik unit ini
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $unit = $user->unitUsaha;

        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan');
        $subUnitId = $request->input('sub_unit_id');

        $query = LaporanKeuangan::with(['subUnit', 'createdBy'])
            ->where('unit_id', $unit->id)
            ->tahun($tahun);

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($subUnitId) {
            $query->where('sub_unit_id', $subUnitId);
        }

        $laporan = $query->orderByDesc('tahun')
                         ->orderByDesc('bulan')
                         ->orderBy('sub_unit_id')
                         ->paginate(20)
                         ->withQueryString();

        $subUnits = $unit->getActiveSubUnits();
        $tahunList = LaporanKeuangan::where('unit_id', $unit->id)
            ->distinct()->pluck('tahun')->sortDesc()->values();

        // Rekap
        $rekapQuery = LaporanKeuangan::where('unit_id', $unit->id)->tahun($tahun);
        if ($bulan) $rekapQuery->where('bulan', $bulan);
        $rekapData = $rekapQuery->get();
        $rekap = [
            'pendapatan' => $rekapData->sum('pendapatan'),
            'pengeluaran' => $rekapData->sum('pengeluaran'),
            'laba_rugi' => $rekapData->sum('pendapatan') - $rekapData->sum('pengeluaran'),
        ];

        return view('unit.laporan-keuangan.index', compact(
            'unit', 'laporan', 'subUnits', 'tahunList', 'tahun', 'bulan', 'subUnitId', 'rekap'
        ));
    }

    /**
     * Form input laporan keuangan (untuk unit tanpa sub unit, atau input langsung unit)
     */
    public function create()
    {
        $user = auth()->user();
        $unit = $user->unitUsaha;

        return view('unit.laporan-keuangan.create', compact('unit'));
    }

    /**
     * Simpan laporan keuangan baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $unit = $user->unitUsaha;

        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'bulan.required' => 'Bulan wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'pendapatan.required' => 'Pendapatan wajib diisi.',
            'pengeluaran.required' => 'Pengeluaran wajib diisi.',
        ]);

        // Cek duplikat: unit tanpa sub unit, bulan+tahun sama
        $exists = LaporanKeuangan::where('unit_id', $unit->id)
            ->whereNull('sub_unit_id')
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            $namaBulan = LaporanKeuangan::$namaBulan[$validated['bulan']] ?? $validated['bulan'];
            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$namaBulan} {$validated['tahun']} sudah ada untuk {$unit->nama}."
            ]);
        }

        LaporanKeuangan::create([
            'unit_id' => $unit->id,
            'sub_unit_id' => null,
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'pendapatan' => $validated['pendapatan'],
            'pengeluaran' => $validated['pengeluaran'],
            'keterangan' => $validated['keterangan'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil disimpan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        // Pastikan laporan milik unit ini, dan bukan dari sub unit
        if ($laporan_keuangan->unit_id !== $user->unit_id || $laporan_keuangan->sub_unit_id !== null) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $unit = $user->unitUsaha;

        return view('unit.laporan-keuangan.edit', [
            'unit' => $unit,
            'laporan' => $laporan_keuangan,
        ]);
    }

    /**
     * Update laporan keuangan
     */
    public function update(Request $request, LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        if ($laporan_keuangan->unit_id !== $user->unit_id || $laporan_keuangan->sub_unit_id !== null) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Cek duplikat (kecuali diri sendiri)
        $exists = LaporanKeuangan::where('unit_id', $user->unit_id)
            ->whereNull('sub_unit_id')
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->where('id', '!=', $laporan_keuangan->id)
            ->exists();

        if ($exists) {
            $namaBulan = LaporanKeuangan::$namaBulan[$validated['bulan']] ?? $validated['bulan'];
            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$namaBulan} {$validated['tahun']} sudah ada."
            ]);
        }

        $laporan_keuangan->update([
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'pendapatan' => $validated['pendapatan'],
            'pengeluaran' => $validated['pengeluaran'],
            'keterangan' => $validated['keterangan'],
            'updated_by' => $user->id,
        ]);

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus laporan keuangan
     */
    public function destroy(LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        // Unit hanya bisa hapus laporan langsung (bukan dari sub unit)
        if ($laporan_keuangan->unit_id !== $user->unit_id || $laporan_keuangan->sub_unit_id !== null) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $laporan_keuangan->delete();

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
