<?php

namespace App\Http\Controllers\SubUnit;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

/**
 * Controller untuk Sub Unit Usaha mengelola laporan keuangan
 * Sub unit hanya bisa input/edit laporan milik sub unitnya sendiri
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Daftar laporan keuangan milik sub unit ini
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $subUnit = $user->subUnitUsaha;
        $unit = $user->unitUsaha;

        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan');

        $query = LaporanKeuangan::with('createdBy')
            ->where('sub_unit_id', $subUnit->id)
            ->tahun($tahun);

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        $laporan = $query->orderByDesc('tahun')
                         ->orderByDesc('bulan')
                         ->paginate(20)
                         ->withQueryString();

        $tahunList = LaporanKeuangan::where('sub_unit_id', $subUnit->id)
            ->distinct()->pluck('tahun')->sortDesc()->values();

        // Rekap
        $rekapQuery = LaporanKeuangan::where('sub_unit_id', $subUnit->id)->tahun($tahun);
        if ($bulan) $rekapQuery->where('bulan', $bulan);
        $rekapData = $rekapQuery->get();
        $rekap = [
            'pendapatan' => $rekapData->sum('pendapatan'),
            'pengeluaran' => $rekapData->sum('pengeluaran'),
            'laba_rugi' => $rekapData->sum('pendapatan') - $rekapData->sum('pengeluaran'),
        ];

        return view('subunit.laporan-keuangan.index', compact(
            'unit', 'subUnit', 'laporan', 'tahunList', 'tahun', 'bulan', 'rekap'
        ));
    }

    /**
     * Form input laporan keuangan
     */
    public function create()
    {
        $user = auth()->user();
        $subUnit = $user->subUnitUsaha;
        $unit = $user->unitUsaha;

        return view('subunit.laporan-keuangan.create', compact('unit', 'subUnit'));
    }

    /**
     * Simpan laporan keuangan baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $subUnit = $user->subUnitUsaha;

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

        // Cek duplikat
        $exists = LaporanKeuangan::where('sub_unit_id', $subUnit->id)
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            $namaBulan = LaporanKeuangan::$namaBulan[$validated['bulan']] ?? $validated['bulan'];
            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$namaBulan} {$validated['tahun']} sudah ada untuk {$subUnit->nama}."
            ]);
        }

        LaporanKeuangan::create([
            'unit_id' => $user->unit_id,
            'sub_unit_id' => $subUnit->id,
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'pendapatan' => $validated['pendapatan'],
            'pengeluaran' => $validated['pengeluaran'],
            'keterangan' => $validated['keterangan'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('subunit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil disimpan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        if ($laporan_keuangan->sub_unit_id !== $user->sub_unit_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $subUnit = $user->subUnitUsaha;
        $unit = $user->unitUsaha;

        return view('subunit.laporan-keuangan.edit', [
            'unit' => $unit,
            'subUnit' => $subUnit,
            'laporan' => $laporan_keuangan,
        ]);
    }

    /**
     * Update laporan keuangan
     */
    public function update(Request $request, LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        if ($laporan_keuangan->sub_unit_id !== $user->sub_unit_id) {
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
        $exists = LaporanKeuangan::where('sub_unit_id', $user->sub_unit_id)
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

        return redirect()->route('subunit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus laporan keuangan
     */
    public function destroy(LaporanKeuangan $laporan_keuangan)
    {
        $user = auth()->user();

        if ($laporan_keuangan->sub_unit_id !== $user->sub_unit_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $laporan_keuangan->delete();

        return redirect()->route('subunit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
