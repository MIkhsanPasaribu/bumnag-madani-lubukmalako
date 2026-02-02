<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GaleriBumnagRequest;
use App\Models\GaleriBumnag;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola galeri BUMNag di admin
 */
class GaleriBumnagController extends Controller
{
    use HasFileUpload;

    /**
     * Folder untuk menyimpan foto galeri
     */
    private const UPLOAD_FOLDER = 'galeri-bumnag';

    /**
     * Tampilkan daftar galeri
     */
    public function index(Request $request)
    {
        $query = GaleriBumnag::with('uploader');
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        // Filter archived
        if ($request->filled('archived') && $request->archived === '1') {
            $query->onlyTrashed();
        }
        
        // Search
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }
        
        $galeri = $query->ordered()->paginate(20)->withQueryString();
        
        // Stats
        $totalAktif = GaleriBumnag::where('status', 'aktif')->count();
        $totalTidakAktif = GaleriBumnag::where('status', 'tidak_aktif')->count();
        $totalAll = GaleriBumnag::count();
        $totalArchived = GaleriBumnag::onlyTrashed()->count();
        
        // Get available years
        $tahunList = GaleriBumnag::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('admin.galeri-bumnag.index', compact(
            'galeri',
            'totalAktif',
            'totalTidakAktif',
            'totalAll',
            'totalArchived',
            'tahunList'
        ));
    }

    /**
     * Tampilkan form tambah galeri
     */
    public function create()
    {
        return view('admin.galeri-bumnag.create');
    }

    /**
     * Simpan galeri baru
     */
    public function store(GaleriBumnagRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            
            // Upload dan optimize foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = $this->uploadAndOptimizeImage($foto);
                $data['foto'] = $filename;
            }
            
            // Set uploaded_by
            $data['uploaded_by'] = Auth::id();
            
            // Set urutan otomatis (paling akhir)
            $maxUrutan = GaleriBumnag::max('urutan') ?? 0;
            $data['urutan'] = $maxUrutan + 1;
            
            GaleriBumnag::create($data);
            
            DB::commit();
            
            return redirect()
                ->route('admin.galeri-bumnag.index')
                ->with('success', 'Foto berhasil ditambahkan ke galeri.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan foto: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit galeri
     */
    public function edit(GaleriBumnag $galeri_bumnag)
    {
        return view('admin.galeri-bumnag.edit', ['galeri' => $galeri_bumnag]);
    }

    /**
     * Update galeri
     */
    public function update(GaleriBumnagRequest $request, GaleriBumnag $galeri_bumnag)
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            
            // Upload foto baru jika ada
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                $this->deleteFile($galeri_bumnag->foto, self::UPLOAD_FOLDER);
                
                // Upload foto baru
                $foto = $request->file('foto');
                $filename = $this->uploadAndOptimizeImage($foto);
                $data['foto'] = $filename;
            }
            
            $galeri_bumnag->update($data);
            
            DB::commit();
            
            return redirect()
                ->route('admin.galeri-bumnag.index')
                ->with('success', 'Foto berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui foto: ' . $e->getMessage());
        }
    }

    /**
     * Hapus galeri (soft delete)
     */
    public function destroy(GaleriBumnag $galeri_bumnag)
    {
        try {
            $galeri_bumnag->delete();
            
            return redirect()
                ->route('admin.galeri-bumnag.index')
                ->with('success', 'Foto berhasil diarsipkan.');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengarsipkan foto: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/tidak aktif
     */
    public function toggleStatus(GaleriBumnag $galeri_bumnag)
    {
        try {
            $newStatus = $galeri_bumnag->status === 'aktif' ? 'tidak_aktif' : 'aktif';
            $galeri_bumnag->update(['status' => $newStatus]);
            
            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => 'Status berhasil diubah.',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update urutan galeri (untuk drag & drop)
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*' => 'required|integer|exists:galeri_bumnag,id',
            ]);
            
            DB::beginTransaction();
            
            foreach ($request->order as $urutan => $id) {
                GaleriBumnag::where('id', $id)->update(['urutan' => $urutan + 1]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan galeri berhasil diperbarui.',
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload dan optimize image
     */
    private function uploadAndOptimizeImage($file): string
    {
        $filename = $this->generateFileName($file, 'galeri');
        $path = public_path('uploads/' . self::UPLOAD_FOLDER);
        
        // Buat folder jika belum ada
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        // Get image info
        $imagePath = $file->getRealPath();
        $imageInfo = getimagesize($imagePath);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Load image berdasarkan mime type
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($imagePath);
                break;
            default:
                $sourceImage = imagecreatefromjpeg($imagePath);
        }
        
        // Resize jika terlalu besar (max width: 1920px)
        if ($width > 1920) {
            $newWidth = 1920;
            $newHeight = intval(($height / $width) * $newWidth);
            
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency untuk PNG
            if ($mimeType === 'image/png') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
            }
            
            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($sourceImage);
            $sourceImage = $resizedImage;
        }
        
        // Save dengan quality 85%
        $fullPath = $path . '/' . $filename;
        if ($mimeType === 'image/png') {
            imagepng($sourceImage, $fullPath, 8); // PNG compression level 8
        } else {
            imagejpeg($sourceImage, $fullPath, 85); // JPEG quality 85%
        }
        
        imagedestroy($sourceImage);
        
        return $filename;
    }
}
