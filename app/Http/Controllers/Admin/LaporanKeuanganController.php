<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use App\Exports\LaporanKeuanganExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller untuk mengelola Laporan Keuangan (Admin)
 * Menggantikan TransaksiKasController
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Menampilkan daftar laporan keuangan dengan filter
     */
    public function index(Request $request)
    {
        // Tahun tersedia
        $tahunTersedia = LaporanKeuangan::getTahunTersedia();
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }

        // Filter
        $tahunFilter = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        $bulanFilter = $request->get('bulan');
        $unitFilter = $request->get('unit');

        // Daftar unit untuk filter
        $unitList = UnitUsaha::aktif()->ordered()->get();

        // Bulan tersedia
        $bulanTersedia = LaporanKeuangan::getBulanTersedia($tahunFilter);

        // Query laporan
        $query = LaporanKeuangan::with(['unit', 'subUnit', 'createdBy'])
            ->tahun($tahunFilter);

        if ($bulanFilter) {
            $query->bulan($bulanFilter, $tahunFilter);
        }

        if ($unitFilter) {
            $query->unit($unitFilter);
        }

        $laporan = $query->urut()->paginate(50)->withQueryString();

        // Rekap statistik
        $queryRekap = LaporanKeuangan::tahun($tahunFilter);
        if ($bulanFilter) {
            $queryRekap->where('bulan', $bulanFilter);
        }
        if ($unitFilter) {
            $queryRekap->where('unit_id', $unitFilter);
        }
        $dataRekap = $queryRekap->get();

        $rekap = [
            'total_pendapatan' => (float) $dataRekap->sum('pendapatan'),
            'total_pengeluaran' => (float) $dataRekap->sum('pengeluaran'),
            'total_laba_rugi' => (float) $dataRekap->sum('pendapatan') - (float) $dataRekap->sum('pengeluaran'),
            'jumlah_laporan' => $dataRekap->count(),
        ];

        return view('admin.laporan-keuangan.index', compact(
            'laporan',
            'tahunTersedia',
            'tahunFilter',
            'bulanFilter',
            'bulanTersedia',
            'unitFilter',
            'unitList',
            'rekap'
        ));
    }

    /**
     * Form tambah laporan keuangan
     */
    public function create()
    {
        $units = UnitUsaha::getWithSubUnits();

        return view('admin.laporan-keuangan.create', compact('units'));
    }

    /**
     * Simpan laporan keuangan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_usaha,id',
            'sub_unit_id' => 'nullable|exists:sub_unit_usaha,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'unit_id.required' => 'Unit usaha wajib dipilih.',
            'bulan.required' => 'Bulan wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'pendapatan.required' => 'Nominal pendapatan wajib diisi.',
            'pengeluaran.required' => 'Nominal pengeluaran wajib diisi.',
            'pendapatan.min' => 'Pendapatan tidak boleh negatif.',
            'pengeluaran.min' => 'Pengeluaran tidak boleh negatif.',
        ]);

        // Validasi: unit dengan sub unit harus isi sub_unit_id
        $unit = UnitUsaha::findOrFail($validated['unit_id']);
        if ($unit->hasSubUnits() && empty($validated['sub_unit_id'])) {
            return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit wajib dipilih untuk ' . $unit->nama . '.']);
        }

        // Validasi: sub unit harus milik unit yang dipilih
        if (!empty($validated['sub_unit_id'])) {
            $subUnit = SubUnitUsaha::findOrFail($validated['sub_unit_id']);
            if ($subUnit->unit_id != $validated['unit_id']) {
                return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit tidak sesuai dengan unit yang dipilih.']);
            }
        }

        // Cek duplikat: sudah ada laporan untuk kombinasi ini?
        $exists = LaporanKeuangan::where('unit_id', $validated['unit_id'])
            ->where('sub_unit_id', $validated['sub_unit_id'] ?? null)
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            $periode = LaporanKeuangan::$namaBulan[$validated['bulan']] . ' ' . $validated['tahun'];
            return back()->withInput()->withErrors(['bulan' => "Laporan untuk periode {$periode} sudah ada. Silakan edit laporan yang ada."]);
        }

        // Unit tanpa sub unit: pastikan sub_unit_id null
        if (!$unit->hasSubUnits()) {
            $validated['sub_unit_id'] = null;
        }

        LaporanKeuangan::create([
            'unit_id' => $validated['unit_id'],
            'sub_unit_id' => $validated['sub_unit_id'] ?? null,
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'pendapatan' => $validated['pendapatan'],
            'pengeluaran' => $validated['pengeluaran'],
            'keterangan' => $validated['keterangan'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.laporan-keuangan.index', [
            'tahun' => $validated['tahun'],
            'bulan' => $validated['bulan'],
        ])->with('success', 'Laporan keuangan berhasil ditambahkan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporanKeuangan)
    {
        $units = UnitUsaha::getWithSubUnits();

        return view('admin.laporan-keuangan.edit', [
            'laporan' => $laporanKeuangan,
            'units' => $units,
        ]);
    }

    /**
     * Update laporan keuangan
     */
    public function update(Request $request, LaporanKeuangan $laporanKeuangan)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_usaha,id',
            'sub_unit_id' => 'nullable|exists:sub_unit_usaha,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
            'pendapatan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // Validasi unit + sub unit
        $unit = UnitUsaha::findOrFail($validated['unit_id']);
        if ($unit->hasSubUnits() && empty($validated['sub_unit_id'])) {
            return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit wajib dipilih untuk ' . $unit->nama . '.']);
        }

        if (!empty($validated['sub_unit_id'])) {
            $subUnit = SubUnitUsaha::findOrFail($validated['sub_unit_id']);
            if ($subUnit->unit_id != $validated['unit_id']) {
                return back()->withInput()->withErrors(['sub_unit_id' => 'Sub unit tidak sesuai dengan unit yang dipilih.']);
            }
        }

        // Cek duplikat (kecuali record sendiri)
        $exists = LaporanKeuangan::where('unit_id', $validated['unit_id'])
            ->where('sub_unit_id', $validated['sub_unit_id'] ?? null)
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->where('id', '!=', $laporanKeuangan->id)
            ->exists();

        if ($exists) {
            $periode = LaporanKeuangan::$namaBulan[$validated['bulan']] . ' ' . $validated['tahun'];
            return back()->withInput()->withErrors(['bulan' => "Laporan untuk periode {$periode} sudah ada."]);
        }

        if (!$unit->hasSubUnits()) {
            $validated['sub_unit_id'] = null;
        }

        $laporanKeuangan->update([
            'unit_id' => $validated['unit_id'],
            'sub_unit_id' => $validated['sub_unit_id'] ?? null,
            'bulan' => $validated['bulan'],
            'tahun' => $validated['tahun'],
            'pendapatan' => $validated['pendapatan'],
            'pengeluaran' => $validated['pengeluaran'],
            'keterangan' => $validated['keterangan'],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.laporan-keuangan.index', [
            'tahun' => $validated['tahun'],
            'bulan' => $validated['bulan'],
        ])->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus laporan keuangan
     */
    public function destroy(LaporanKeuangan $laporanKeuangan)
    {
        $tahun = $laporanKeuangan->tahun;
        $bulan = $laporanKeuangan->bulan;

        $laporanKeuangan->delete();

        return redirect()->route('admin.laporan-keuangan.index', [
            'tahun' => $tahun,
            'bulan' => $bulan,
        ])->with('success', 'Laporan keuangan berhasil dihapus.');
    }

    /**
     * Export PDF laporan keuangan
     * Mode: bulanan, tahunan, per-unit, gabungan
     */
    public function exportPdf(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', date('Y'));
        $unitId = $request->get('unit');

        // Ambil data unit jika filter per unit
        $unitNama = null;
        if ($unitId) {
            $unitObj = UnitUsaha::find($unitId);
            $unitNama = $unitObj?->nama;
        }

        // Tentukan periode
        if ($bulan && $tahun) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            $filename = 'laporan_keuangan_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . $tahun;
        } elseif ($tahun) {
            $periode = 'Tahun ' . $tahun;
            $filename = 'laporan_keuangan_tahun_' . $tahun;
        } else {
            $periode = 'Semua Data';
            $filename = 'laporan_keuangan_lengkap';
        }

        if ($unitNama) {
            $filename .= '_' . strtolower(str_replace(' ', '_', $unitNama));
        }

        // Query data
        $query = LaporanKeuangan::with(['unit', 'subUnit']);
        if ($tahun) $query->tahun($tahun);
        if ($bulan) $query->where('bulan', $bulan);
        if ($unitId) $query->unit($unitId);

        $laporan = $query->orderBy('bulan')->orderBy('unit_id')->orderBy('sub_unit_id')->get();

        // Rekap
        $rekap = [
            'periode' => $periode,
            'unit_nama' => $unitNama,
            'total_pendapatan' => (float) $laporan->sum('pendapatan'),
            'total_pengeluaran' => (float) $laporan->sum('pengeluaran'),
            'total_laba_rugi' => (float) $laporan->sum('pendapatan') - (float) $laporan->sum('pengeluaran'),
            'jumlah_laporan' => $laporan->count(),
        ];

        // Rekap per unit
        $rekapPerUnit = [];
        foreach ($laporan->groupBy('unit_id') as $unitGroupId => $group) {
            $unit = $group->first()->unit;
            $rekapPerUnit[] = [
                'nama_unit' => $unit->nama,
                'total_pendapatan' => (float) $group->sum('pendapatan'),
                'total_pengeluaran' => (float) $group->sum('pengeluaran'),
                'total_laba_rugi' => (float) $group->sum('pendapatan') - (float) $group->sum('pengeluaran'),
            ];
        }

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact('laporan', 'rekap', 'rekapPerUnit', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename . '.pdf');
    }

    /**
     * Export Excel laporan keuangan
     */
    public function exportExcel(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', date('Y'));
        $unitId = $request->get('unit');

        // Tentukan nama file
        $unitNama = null;
        if ($unitId) {
            $unitNama = UnitUsaha::find($unitId)?->nama;
        }

        if ($bulan && $tahun) {
            $filename = 'Laporan_Keuangan_' . LaporanKeuangan::$namaBulan[$bulan] . '_' . $tahun;
        } elseif ($tahun) {
            $filename = 'Laporan_Keuangan_Tahun_' . $tahun;
        } else {
            $filename = 'Laporan_Keuangan_Lengkap';
        }

        if ($unitNama) {
            $filename .= '_' . str_replace(' ', '_', $unitNama);
        }

        return Excel::download(
            new LaporanKeuanganExport($bulan, $tahun ? (int) $tahun : null, $unitId ? (int) $unitId : null),
            $filename . '.xlsx'
        );
    }

    /**
     * Log aktivitas laporan keuangan
     */
    public function activity()
    {
        $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', LaporanKeuangan::class)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.laporan-keuangan.activity', compact('activities'));
    }

    /**
     * API: Ambil sub unit berdasarkan unit_id (untuk form dinamis)
     */
    public function getSubUnits(int $unitId)
    {
        $subUnits = SubUnitUsaha::aktif()
            ->unit($unitId)
            ->ordered()
            ->get(['id', 'nama', 'kode']);

        return response()->json($subUnits);
    }
}
