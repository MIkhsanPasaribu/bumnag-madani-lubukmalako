<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Trait HasFileUpload
 * 
 * Menyediakan helper methods untuk file upload
 * Menghilangkan duplikasi kode upload antara controller
 */
trait HasFileUpload
{
    /**
     * Upload file ke folder yang ditentukan
     *
     * @param UploadedFile $file
     * @param string $folder Nama folder di public/uploads/
     * @param string|null $prefix Prefix untuk nama file
     * @return string Nama file yang tersimpan
     */
    protected function uploadFile(UploadedFile $file, string $folder, ?string $prefix = null): string
    {
        $filename = $this->generateFileName($file, $prefix);
        $file->move(public_path("uploads/{$folder}"), $filename);
        
        return $filename;
    }

    /**
     * Hapus file dari storage
     *
     * @param string|null $filename
     * @param string $folder
     * @return bool
     */
    protected function deleteFile(?string $filename, string $folder): bool
    {
        if (!$filename) {
            return false;
        }

        $path = public_path("uploads/{$folder}/{$filename}");
        
        if (file_exists($path)) {
            return unlink($path);
        }

        return false;
    }

    /**
     * Generate nama file yang unique
     *
     * @param UploadedFile $file
     * @param string|null $prefix
     * @return string
     */
    protected function generateFileName(UploadedFile $file, ?string $prefix = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $prefix = $prefix ? Str::slug($prefix) : 'file';
        
        return time() . '_' . $prefix . '.' . $extension;
    }

    /**
     * Handle upload dengan opsi replace file lama
     *
     * @param UploadedFile|null $newFile File baru yang diupload
     * @param string|null $oldFilename Nama file lama untuk dihapus
     * @param string $folder Folder tujuan
     * @param string|null $prefix Prefix nama file
     * @return string|null Nama file baru atau null jika tidak ada upload
     */
    protected function handleFileUpload(
        ?UploadedFile $newFile, 
        ?string $oldFilename, 
        string $folder, 
        ?string $prefix = null
    ): ?string {
        if (!$newFile) {
            return null;
        }

        // Hapus file lama jika ada
        if ($oldFilename) {
            $this->deleteFile($oldFilename, $folder);
        }

        // Upload file baru
        return $this->uploadFile($newFile, $folder, $prefix);
    }
}
