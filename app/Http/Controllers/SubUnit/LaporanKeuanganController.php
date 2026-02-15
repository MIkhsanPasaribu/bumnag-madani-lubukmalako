<?php

namespace App\Http\Controllers\SubUnit;

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
 * Controller untuk Sub Unit Usaha mengelola laporan keuangan
 * 
 * Sub unit bisa:
 * - Melihat semua laporan milik sub unitnya
 * - Input laporan baru (jika belum diinput oleh admin atau unit)
 * - Edit/hapus laporan yang dibuat sendiri
 * - Melihat info jika data sudah diinput oleh admin atau akun unit
 */
class LaporanKeuanganController extends Controller
{
    /**
     * Daftar laporan keuangan milik sub unit ini
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();
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

        if (!$tahunList->contains(now()->year)) {
            $tahunList->prepend(now()->year);
        }

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
     * Cek apakah data sudah diinput oleh admin atau unit
     */
    public function create(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $subUnit = $user->subUnitUsaha;
        $unit = $user->unitUsaha;

        $adminInputInfo = null;

        return view('subunit.laporan-keuangan.create', compact('unit', 'subUnit', 'adminInputInfo'));
    }

    /**
     * Simpan laporan keuangan baru
     */
    public function store(LaporanKeuanganRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $subUnit = $user->subUnitUsaha;

        $bulan = (int) $request->validated('bulan');
        $tahun = (int) $request->validated('tahun');

        // Cek duplikat dengan info siapa yang sudah menginput
        $existing = LaporanKeuangan::findExistingReport(
            $user->unit_id,
            $subUnit->id,
            $bulan,
            $tahun
        );

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            $creatorInfo = $existing->creator_info
                ? "Data sudah diinputkan oleh {$existing->creator_info}."
                : 'Silakan edit laporan yang ada.';

            // Pesan khusus jika diinput oleh admin atau unit
            if ($existing->createdBy) {
                if ($existing->createdBy->isAdminLevel()) {
                    $creatorInfo = "Data sudah diinputkan oleh Admin ({$existing->createdBy->name}). Hubungi Admin jika perlu perubahan.";
                } elseif ($existing->createdBy->isUnit()) {
                    $creatorInfo = "Data sudah diinputkan oleh akun Unit ({$existing->createdBy->name}). Hubungi Unit untuk perubahan.";
                }
            }

            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$periode} sudah ada untuk {$subUnit->nama}. {$creatorInfo}"
            ]);
        }

        LaporanKeuangan::create([
            'unit_id' => $user->unit_id,
            'sub_unit_id' => $subUnit->id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return redirect()->route('subunit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil disimpan.');
    }

    /**
     * Form edit laporan keuangan
     */
    public function edit(LaporanKeuangan $laporan_keuangan): View
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->can('update', $laporan_keuangan)) {
            $message = 'Anda tidak memiliki akses untuk mengedit laporan ini.';

            if (LaporanKeuanganPolicy::isInputByHigherRole($user, $laporan_keuangan)) {
                $creatorInfo = LaporanKeuanganPolicy::getInputByMessage($laporan_keuangan);
                $message = "Laporan ini {$creatorInfo}. Hubungi pihak terkait untuk perubahan.";
            }

            abort(403, $message);
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
    public function update(LaporanKeuanganRequest $request, LaporanKeuangan $laporan_keuangan): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->can('update', $laporan_keuangan)) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit laporan ini.');
        }

        $bulan = (int) $request->validated('bulan');
        $tahun = (int) $request->validated('tahun');

        // Cek duplikat (kecuali diri sendiri) 
        $existing = LaporanKeuangan::findExistingReport(
            $user->unit_id,
            $user->sub_unit_id,
            $bulan,
            $tahun,
            $laporan_keuangan->id
        );

        if ($existing) {
            $periode = LaporanKeuangan::$namaBulan[$bulan] . ' ' . $tahun;
            return back()->withInput()->withErrors([
                'bulan' => "Laporan {$periode} sudah ada."
            ]);
        }

        $laporan_keuangan->update([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pendapatan' => $request->validated('pendapatan'),
            'pengeluaran' => $request->validated('pengeluaran'),
            'keterangan' => $request->validated('keterangan'),
            'updated_by' => $user->id,
        ]);

        return redirect()->route('subunit.laporan-keuangan.index')
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
                $message = "Laporan ini {$creatorInfo}. Hubungi pihak terkait untuk menghapus.";
            }

            abort(403, $message);
        }

        $laporan_keuangan->delete();

        return redirect()->route('subunit.laporan-keuangan.index')
            ->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
