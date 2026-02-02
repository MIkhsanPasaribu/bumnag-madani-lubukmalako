<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi Berita
 * Digunakan untuk store dan update berita
 */
class BeritaRequest extends FormRequest
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
        return [
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
            // Fitur baru
            'kategori_id' => ['nullable', 'exists:kategori_berita,id'],
            'is_featured' => ['nullable', 'boolean'],
            'is_pinned' => ['nullable', 'boolean'],
            'is_scheduled' => ['nullable', 'boolean'],
            'tanggal_publikasi' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            // Gallery images
            'gallery.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi.',
            'judul.max' => 'Judul berita maksimal 255 karakter.',
            'konten.required' => 'Konten berita wajib diisi.',
            'ringkasan.max' => 'Ringkasan maksimal 500 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus: JPEG, PNG, JPG, atau WebP.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            // Fitur baru
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tanggal_publikasi.date' => 'Format tanggal publikasi tidak valid.',
            'meta_title.max' => 'Meta title maksimal 70 karakter untuk SEO optimal.',
            'meta_description.max' => 'Meta description maksimal 160 karakter untuk SEO optimal.',
            'meta_keywords.max' => 'Meta keywords maksimal 255 karakter.',
            'gallery.*.image' => 'File gallery harus berupa gambar.',
            'gallery.*.mimes' => 'Format gambar gallery harus: JPEG, PNG, JPG, atau WebP.',
            'gallery.*.max' => 'Ukuran gambar gallery maksimal 2MB per file.',
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
            'judul' => 'judul berita',
            'konten' => 'konten berita',
            'ringkasan' => 'ringkasan',
            'gambar' => 'gambar featured',
            'status' => 'status publikasi',
            'kategori_id' => 'kategori',
            'is_featured' => 'featured',
            'is_pinned' => 'pinned',
            'is_scheduled' => 'terjadwal',
            'tanggal_publikasi' => 'tanggal publikasi',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'gallery.*' => 'gambar gallery',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            'is_featured' => $this->has('is_featured') && $this->is_featured,
            'is_pinned' => $this->has('is_pinned') && $this->is_pinned,
            'is_scheduled' => $this->has('is_scheduled') && $this->is_scheduled,
        ]);
    }
}
