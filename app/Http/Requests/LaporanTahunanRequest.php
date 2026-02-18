<?php

namespace App\Http\Requests;

use App\Models\LaporanTahunan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request untuk validasi Laporan Tahunan
 * Digunakan untuk store dan update laporan tahunan
 */
class LaporanTahunanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $laporanId = $this->route('laporan_tahunan')?->id;
        
        $rules = [
            'tahun' => [
                'required',
                'integer',
                'digits:4',
                'min:1900',
                Rule::unique('laporan_tahunan', 'tahun')->ignore($laporanId),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'], // Max 5MB
            'status' => ['required', 'in:draft,published'],
            'tanggal_publikasi' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ];
        
        // File laporan required pada create, optional pada update
        if ($this->isMethod('POST')) {
            $rules['file_laporan'] = ['required', 'file', 'mimes:pdf', 'max:20480']; // Max 20MB
        } else {
            $rules['file_laporan'] = ['nullable', 'file', 'mimes:pdf', 'max:20480'];
        }
        
        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tahun.required' => 'Tahun laporan wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.digits' => 'Tahun harus terdiri dari 4 digit.',
            'tahun.min' => 'Tahun minimal adalah 1900.',
            'tahun.unique' => 'Laporan untuk tahun ini sudah ada. Silakan pilih tahun lain atau edit laporan yang ada.',
            'judul.required' => 'Judul laporan wajib diisi.',
            'judul.max' => 'Judul laporan maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter.',
            'cover_image.image' => 'Cover harus berupa gambar.',
            'cover_image.mimes' => 'Format cover harus: JPEG, JPG, PNG, atau WEBP.',
            'cover_image.max' => 'Ukuran cover maksimal 5MB.',
            'file_laporan.required' => 'File laporan wajib diupload.',
            'file_laporan.file' => 'File laporan harus berupa file.',
            'file_laporan.mimes' => 'Format file laporan harus PDF.',
            'file_laporan.max' => 'Ukuran file laporan maksimal 20MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'tanggal_publikasi.date' => 'Format tanggal publikasi tidak valid.',
            'meta_title.max' => 'Meta title maksimal 70 karakter untuk SEO optimal.',
            'meta_description.max' => 'Meta description maksimal 160 karakter untuk SEO optimal.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tahun' => 'tahun laporan',
            'judul' => 'judul laporan',
            'deskripsi' => 'deskripsi',
            'cover_image' => 'cover laporan',
            'file_laporan' => 'file laporan',
            'status' => 'status',
            'tanggal_publikasi' => 'tanggal publikasi',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
        ];
    }
}
