<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTransaksi;
use App\Models\TransaksiKas;
use App\Exports\TransaksiKasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

/**
 * Controller untuk mengelola Transaksi Kas Harian (Buku Kas)
 */
class TransaksiKasController extends Controller
{
    /**
     * Menampilkan daftar transaksi kas dengan filter bulan/tahun
     */
    public function index(Request $request)
    {
        // Tahun dan bulan tersedia
        $tahunTersedia = TransaksiKas::getTahunTersedia();
        if (empty($tahunTersedia)) {
            $tahunTersedia = [date('Y')];
        }
        
        // Filter
        $tahunFilter = $request->get('tahun', $tahunTersedia[0] ?? date('Y'));
        $bulanFilter = $request->get('bulan');
        $kategoriFilter = $request->get('kategori');
        
        // Bulan tersedia untuk tahun terpilih
        $bulanTersedia = TransaksiKas::getBulanTersedia($tahunFilter);
        
        // Kategori untuk filter dropdown
        $kategoriList = KategoriTransaksi::aktif()->orderBy('jenis')->orderBy('nama')->get();
        
        // Query transaksi
        $query = TransaksiKas::with(['createdBy', 'updatedBy', 'kategori'])
            ->tahun($tahunFilter);
        
        if ($bulanFilter) {
            $query->bulan($bulanFilter, $tahunFilter);
        }
        
        if ($kategoriFilter) {
            $query->where('kategori_id', $kategoriFilter);
        }
        
        $transaksi = $query->urut()->paginate(50)->withQueryString();
        
        // Rekap
        if ($bulanFilter) {
            $rekap = TransaksiKas::getRekapBulanan($bulanFilter, $tahunFilter);
        } else {
            // Rekap tahunan sederhana
            $dataTransaksi = TransaksiKas::tahun($tahunFilter)->get();
            $rekap = [
                'periode' => 'Tahun ' . $tahunFilter,
                'jumlah_transaksi' => $dataTransaksi->count(),
                'total_masuk' => $dataTransaksi->sum('uang_masuk'),
                'total_keluar' => $dataTransaksi->sum('uang_keluar'),
                'selisih' => $dataTransaksi->sum('uang_masuk') - $dataTransaksi->sum('uang_keluar'),
                'saldo_awal' => TransaksiKas::getSaldoAwalBulan(1, $tahunFilter),
                'saldo_akhir' => TransaksiKas::tahun($tahunFilter)->orderBy('tanggal', 'desc')->orderBy('no_urut', 'desc')->value('saldo') ?? 0,
            ];
        }
        
        return view('admin.transaksi-kas.index', compact(
            'transaksi',
            'tahunTersedia',
            'tahunFilter',
            'bulanFilter',
            'bulanTersedia',
            'kategoriFilter',
            'kategoriList',
            'rekap'
        ));
    }
    
    /**
     * Menampilkan form tambah transaksi
     */
    public function create(Request $request)
    {
        $tanggal = $request->get('tanggal', date('Y-m-d'));
        $noUrut = TransaksiKas::getNextNoUrut(new \DateTime($tanggal));
        $kategoriMasuk = KategoriTransaksi::masuk()->aktif()->orderBy('nama')->get();
        $kategoriKeluar = KategoriTransaksi::keluar()->aktif()->orderBy('nama')->get();
        
        return view('admin.transaksi-kas.create', compact('tanggal', 'noUrut', 'kategoriMasuk', 'kategoriKeluar'));
    }
    
    /**
     * Menyimpan transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'no_kwitansi' => 'nullable|string|max:50',
            'uraian' => 'required|string|min:3',
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
            'kategori_id' => 'nullable|exists:kategori_transaksi,id',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'uraian.required' => 'Uraian transaksi wajib diisi.',
            'jenis_transaksi.required' => 'Jenis transaksi wajib dipilih.',
            'jumlah.required' => 'Jumlah transaksi wajib diisi.',
            'jumlah.min' => 'Jumlah transaksi minimal Rp 1.',
        ]);
        
        DB::beginTransaction();
        try {
            $tanggal = new \DateTime($validated['tanggal']);
            
            // Hitung saldo
            $saldoSebelum = TransaksiKas::getSaldoSebelum($tanggal);
            $uangMasuk = $validated['jenis_transaksi'] === 'masuk' ? $validated['jumlah'] : 0;
            $uangKeluar = $validated['jenis_transaksi'] === 'keluar' ? $validated['jumlah'] : 0;
            $saldoBaru = $saldoSebelum + $uangMasuk - $uangKeluar;
            
            // Buat transaksi
            $transaksi = TransaksiKas::create([
                'no_urut' => TransaksiKas::getNextNoUrut($tanggal),
                'no_kwitansi' => $validated['no_kwitansi'],
                'tanggal' => $validated['tanggal'],
                'uraian' => $validated['uraian'],
                'uang_masuk' => $uangMasuk,
                'uang_keluar' => $uangKeluar,
                'saldo' => $saldoBaru,
                'keterangan' => $validated['keterangan'],
                'kategori_id' => $validated['kategori_id'] ?? null,
                'created_by' => Auth::id(),
            ]);
            
            // Recalculate saldo untuk transaksi setelahnya
            TransaksiKas::recalculateSaldoFromDate($tanggal);
            
            DB::commit();
            
            return redirect()->route('admin.transaksi-kas.index', [
                'tahun' => $tanggal->format('Y'),
                'bulan' => $tanggal->format('n'),
            ])->with('success', 'Transaksi berhasil ditambahkan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Menampilkan form edit transaksi
     */
    public function edit(TransaksiKas $transaksiKa)
    {
        $kategoriMasuk = KategoriTransaksi::masuk()->aktif()->orderBy('nama')->get();
        $kategoriKeluar = KategoriTransaksi::keluar()->aktif()->orderBy('nama')->get();
        
        return view('admin.transaksi-kas.edit', [
            'transaksi' => $transaksiKa,
            'kategoriMasuk' => $kategoriMasuk,
            'kategoriKeluar' => $kategoriKeluar,
        ]);
    }
    
    /**
     * Menyimpan perubahan transaksi
     */
    public function update(Request $request, TransaksiKas $transaksiKa)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'no_kwitansi' => 'nullable|string|max:50',
            'uraian' => 'required|string|min:3',
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
            'kategori_id' => 'nullable|exists:kategori_transaksi,id',
        ]);
        
        DB::beginTransaction();
        try {
            $tanggalLama = $transaksiKa->tanggal;
            $tanggalBaru = new \DateTime($validated['tanggal']);
            
            $uangMasuk = $validated['jenis_transaksi'] === 'masuk' ? $validated['jumlah'] : 0;
            $uangKeluar = $validated['jenis_transaksi'] === 'keluar' ? $validated['jumlah'] : 0;
            
            $transaksiKa->update([
                'tanggal' => $validated['tanggal'],
                'no_kwitansi' => $validated['no_kwitansi'],
                'uraian' => $validated['uraian'],
                'uang_masuk' => $uangMasuk,
                'uang_keluar' => $uangKeluar,
                'keterangan' => $validated['keterangan'],
                'kategori_id' => $validated['kategori_id'] ?? null,
                'updated_by' => Auth::id(),
            ]);
            
            // Recalculate dari tanggal terlama yang terpengaruh
            $tanggalRecalc = $tanggalLama < $tanggalBaru ? $tanggalLama : $tanggalBaru;
            TransaksiKas::recalculateSaldoFromDate($tanggalRecalc);
            
            DB::commit();
            
            return redirect()->route('admin.transaksi-kas.index', [
                'tahun' => $tanggalBaru->format('Y'),
                'bulan' => $tanggalBaru->format('n'),
            ])->with('success', 'Transaksi berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui transaksi: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Menghapus transaksi
     */
    public function destroy(TransaksiKas $transaksiKa)
    {
        DB::beginTransaction();
        try {
            $tanggal = $transaksiKa->tanggal;
            $bulan = $tanggal->format('n');
            $tahun = $tanggal->format('Y');
            
            $transaksiKa->delete();
            
            // Recalculate saldo
            TransaksiKas::recalculateSaldoFromDate($tanggal);
            
            DB::commit();
            
            return redirect()->route('admin.transaksi-kas.index', [
                'tahun' => $tahun,
                'bulan' => $bulan,
            ])->with('success', 'Transaksi berhasil dihapus.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus transaksi: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Export PDF Buku Kas Bulanan
     */
    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        
        $transaksi = TransaksiKas::bulan($bulan, $tahun)
            ->urut()
            ->get();
        
        $rekap = TransaksiKas::getRekapBulanan($bulan, $tahun);
        
        $pdf = Pdf::loadView('pdf.buku-kas', compact('transaksi', 'rekap', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');
        
        $filename = 'buku_kas_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . $tahun . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * Recalculate semua saldo
     */
    public function recalculateSaldo()
    {
        TransaksiKas::recalculateAllSaldo();
        
        return redirect()->route('admin.transaksi-kas.index')
            ->with('success', 'Semua saldo berhasil dihitung ulang.');
    }
    
    /**
     * Export Excel Buku Kas Bulanan
     */
    public function exportExcel(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        
        $filename = 'Buku_Kas_' . TransaksiKas::$namaBulan[$bulan] . '_' . $tahun . '.xlsx';
        
        return Excel::download(new TransaksiKasExport($bulan, $tahun), $filename);
    }
    
    /**
     * Menampilkan log aktivitas (audit trail) transaksi kas
     */
    public function activity(Request $request)
    {
        $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', TransaksiKas::class)
            ->with(['causer', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('admin.transaksi-kas.activity', compact('activities'));
    }
}
