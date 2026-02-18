<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi Hero Slide
 */
class HeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:1000',
            'tipe_media' => 'required|in:gambar,video',
            'url_tombol' => 'nullable|string|max:255',
            'teks_tombol' => 'nullable|string|max:200',
            'tampilkan_logo' => 'boolean',
            'urutan' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,tidak_aktif',
        ];

        // Media file: wajib saat create, optional saat update
        if ($isUpdate) {
            $rules['media_file'] = 'nullable|file';
        } else {
            $rules['media_file'] = 'required|file';
        }

        return $rules;
    }

    /**
     * Validasi tambahan setelah rules dasar
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('media_file')) {
                $file = $this->file('media_file');
                $tipeMedia = $this->input('tipe_media', 'gambar');

                if ($tipeMedia === 'gambar') {
                    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
                    $maxSize = 10 * 1024; // 10MB in KB

                    if (!in_array($file->getMimeType(), $allowedMimes)) {
                        $validator->errors()->add('media_file', 'File gambar harus berformat JPG, PNG, atau WebP.');
                    }

                    if ($file->getSize() > $maxSize * 1024) {
                        $validator->errors()->add('media_file', 'Ukuran gambar maksimal 10MB.');
                    }
                } elseif ($tipeMedia === 'video') {
                    $allowedMimes = ['video/mp4', 'video/webm'];
                    $maxSize = 100 * 1024; // 100MB in KB

                    if (!in_array($file->getMimeType(), $allowedMimes)) {
                        $validator->errors()->add('media_file', 'File video harus berformat MP4 atau WebM.');
                    }

                    if ($file->getSize() > $maxSize * 1024) {
                        $validator->errors()->add('media_file', 'Ukuran video maksimal 100MB.');
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul slide wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'subjudul.max' => 'Subjudul maksimal 500 karakter.',
            'tipe_media.required' => 'Tipe media wajib dipilih.',
            'tipe_media.in' => 'Tipe media harus gambar atau video.',
            'media_file.required' => 'File media wajib diunggah.',
            'media_file.file' => 'File media tidak valid.',
            'url_tombol.max' => 'URL tombol maksimal 255 karakter.',
            'teks_tombol.max' => 'Teks tombol maksimal 100 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus aktif atau tidak aktif.',
        ];
    }
}
