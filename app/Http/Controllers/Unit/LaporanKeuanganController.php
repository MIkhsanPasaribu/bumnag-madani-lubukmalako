<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanKeuanganRequest;
use App\Models\LaporanKeuangan;
use App\Models\User;
use App\Policies\LaporanKeuanganPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller untuk Unit Usaha mengelola laporan keuangan
 * 
 * Unit bisa:
 * - Melihat semua laporan unit (termasuk sub unit)
 * - Input langsung laporan unit (tanpa sub unit)
 * - Edit/hapus laporan yang dibuat sendiri (bukan yang dibuat admin)
 * - Melihat info jika data sudah diinput oleh admin
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Daftar laporan keuangan milik unit ini
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();
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

        if (!$tahunList->contains(now()->year)) {
            $tahunList->prepend(now()->year);
        }

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
     * Form input laporan keuangan
     * Cek terlebih dahulu apakah unit memiliki sub unit (non-direct input)
     */
    public function create(Request $request): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $unit = $user->unitUsaha;

        // Cek apakah ada data yang sudah diinput admin untuk periode yang akan diinput
        $adminInputInfo = null;
        $bulan = $request->old('bulan');
        $tahun = $request->old('tahun');

        if ($bulan && $tahun) {
            $existing = LaporanKeuangan::findExistingReport(
                $unit->id,
                null,
                (int) $bulan,
                (int) $tahun
            );

            if ($existing && $existing->createdBy && $existing->createdBy->isAdminLevel()) {
                $adminInputInfo = "Data periode ini sudah diinputkan oleh Admin ({$existing->createdBy->name}). Silakan hubungi Admin jika perlu perubahan.";
            }
        }

        return view('unit.laporan-keuangan.create', compact('unit', 'adminInputInfo'));
    }

    /**
     * Simpan laporan keuangan baru
     */
    public function store(LaporanKeuanganRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $unit = $user->unitUsaha;

        // Cek duplikat dengan info siapa yang sudah menginput
        $existing = LaporanKeuangan::findExistingReport(
            $unit->id,
            null,
            (int) $request->validated('bulan'),
            (int) $request->validated('tahun')
        );

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$request->validated('bulan')] . ' ' . $request->validated('tahun');
            $creatorInfo = $existing->creator_info
                ? "Data sudah diinputkan oleh {$existing->creator_info}."
                : 'Silakan edit laporan yang ada.';

            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$periode} sudah ada untuk {$unit->nama}. {$creatorInfo}"
            ]);
        }

        LaporanKeuangan::create([
            'unit_id' => $unit->id,
            'sub_unit_id' => null,
            'bulan' => $request->validated('bulan'),
            'tahun' => $request->validated('tahun'),
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil disimpan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporan_keuangan): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Gunakan policy untuk cek akses
        if (!$user->can('update', $laporan_keuangan)) {
            $message = 'Anda tidak memiliki akses untuk mengedit laporan ini.';

            // Berikan pesan lebih spesifik jika diinput oleh admin
            if (LaporanKeuanganPolicy::isInputByHigherRole($user, $laporan_keuangan)) {
                $creatorInfo = LaporanKeuanganPolicy::getInputByMessage($laporan_keuangan);
                $message = "Laporan ini {$creatorInfo}. Hubungi Admin untuk perubahan.";
            }

            abort(403, $message);
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
    public function update(LaporanKeuanganRequest $request, LaporanKeuangan $laporan_keuangan): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->can('update', $laporan_keuangan)) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        // Cek duplikat (kecuali diri sendiri)
        $existing = LaporanKeuangan::findExistingReport(
            $user->unit_id,
            null,
            (int) $request->validated('bulan'),
            (int) $request->validated('tahun'),
            $laporan_keuangan->id
        );

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$request->validated('bulan')] . ' ' . $request->validated('tahun');
            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$periode} sudah ada."
            ]);
        }

        $laporan_keuangan->update([
            'bulan' => $request->validated('bulan'),
            'tahun' => $request->validated('tahun'),
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'updated_by' => $user->id,
        ]);

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus laporan keuangan
     */
    public function destroy(LaporanKeuangan $laporan_keuangan): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->can('delete', $laporan_keuangan)) {
            $message = 'Anda tidak memiliki akses untuk menghapus laporan ini.';

            if (LaporanKeuanganPolicy::isInputByHigherRole($user, $laporan_keuangan)) {
                $creatorInfo = LaporanKeuanganPolicy::getInputByMessage($laporan_keuangan);
                $message = "Laporan ini {$creatorInfo}. Hubungi Admin untuk menghapus.";
            }

            abort(403, $message);
        }

        $laporan_keuangan->delete();

        return redirect()->route('unit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
