<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanKeuanganRequest;
use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller untuk mengelola Laporan Keuangan (Admin)
 * 
 * Admin memiliki akses penuh untuk CRUD semua laporan keuangan.
 * Ketika admin menginput data untuk unit/sub-unit, akun unit/sub-unit
 * akan melihat info bahwa data sudah diinputkan oleh admin.
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Menampilkan daftar laporan keuangan dengan filter
     */
    public function index(Request $request): View
    {
        $tahunTersedia = LaporanKeuangan::getTahunTersedia();
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }

        $tahunFilter = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        $bulanFilter = $request->get('bulan');
        $unitFilter = $request->get('unit');

        $unitList = UnitUsaha::aktif()->ordered()->get();
        $bulanTersedia = LaporanKeuangan::getBulanTersedia($tahunFilter);

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
    public function create(): View
    {
        $units = UnitUsaha::getWithSubUnits();

        return view('admin.laporan-keuangan.create', compact('units'));
    }

    /**
     * Simpan laporan keuangan baru
     * Menggunakan LaporanKeuanganRequest untuk validasi
     */
    public function store(LaporanKeuanganRequest $request): RedirectResponse
    {
        $unitId = (int) $request->validated('unit_id');
        $subUnitId = $request->getEffectiveSubUnitId();
        $bulan = (int) $request->validated('bulan');
        $tahun = (int) $request->validated('tahun');

        // Cek duplikat dengan info creator
        $existing = LaporanKeuangan::findExistingReport($unitId, $subUnitId, $bulan, $tahun);

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            $creatorInfo = $existing->creator_info
                ? "Data sudah diinputkan oleh {$existing->creator_info}."
                : 'Silakan edit laporan yang ada.';

            return back()->withInput()->withErrors([
                'bulan' => "Laporan untuk periode {$periode} sudah ada. {$creatorInfo}"
            ]);
        }

        LaporanKeuangan::create([
            'unit_id' => $unitId,
            'sub_unit_id' => $subUnitId,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.laporan-keuangan.index', [
            'tahun' => $tahun,
            'bulan' => $bulan,
        ])->with('success', 'Laporan keuangan berhasil ditambahkan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporanKeuangan): View
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
    public function update(LaporanKeuanganRequest $request, LaporanKeuangan $laporanKeuangan): RedirectResponse
    {
        $unitId = (int) $request->validated('unit_id');
        $subUnitId = $request->getEffectiveSubUnitId();
        $bulan = (int) $request->validated('bulan');
        $tahun = (int) $request->validated('tahun');

        // Cek duplikat (kecuali record sendiri)
        $existing = LaporanKeuangan::findExistingReport(
            $unitId, $subUnitId, $bulan, $tahun, $laporanKeuangan->id
        );

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            return back()->withInput()->withErrors([
                'bulan' => "Laporan untuk periode {$periode} sudah ada."
            ]);
        }

        $laporanKeuangan->update([
            'unit_id' => $unitId,
            'sub_unit_id' => $subUnitId,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.laporan-keuangan.index', [
            'tahun' => $tahun,
            'bulan' => $bulan,
        ])->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus laporan keuangan
     */
    public function destroy(LaporanKeuangan $laporanKeuangan): RedirectResponse
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
     */
    public function exportPdf(Request $request): Response
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', date('Y'));
        $unitId = $request->get('unit');

        $unitNama = null;
        if ($unitId) {
            $unitObj = UnitUsaha::find($unitId);
            $unitNama = $unitObj?->nama;
        }

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

        $query = LaporanKeuangan::with(['unit', 'subUnit']);
        if ($tahun) $query->tahun($tahun);
        if ($bulan) $query->where('bulan', $bulan);
        if ($unitId) $query->unit($unitId);

        $laporan = $query->orderBy('bulan')->orderBy('unit_id')->orderBy('sub_unit_id')->get();

        $rekap = [
            'periode' => $periode,
            'unit_nama' => $unitNama,
            'total_pendapatan' => (float) $laporan->sum('pendapatan'),
            'total_pengeluaran' => (float) $laporan->sum('pengeluaran'),
            'total_laba_rugi' => (float) $laporan->sum('pendapatan') - (float) $laporan->sum('pengeluaran'),
            'jumlah_laporan' => $laporan->count(),
        ];

        $rekapPerUnit = [];
        foreach ($laporan->groupBy('unit_id') as $unitGroupId => $group) {
            $unit = $group->first()->unit;
            $rekapPerUnit[] = [
                'nama_unit' => $unit->nama ?? '-',
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
     * Log aktivitas laporan keuangan
     */
    public function activity(): View
    {
        $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', LaporanKeuangan::class)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.laporan-keuangan.activity', compact('activities'));
    }

    /**
     * API: Ambil sub unit berdasarkan unit_id (untuk form dinamis)
     */
    public function getSubUnits(int $unitId): JsonResponse
    {
        $subUnits = SubUnitUsaha::aktif()
            ->unit($unitId)
            ->ordered()
            ->get(['id', 'nama', 'kode']);

        return response()->json($subUnits);
    }
}
