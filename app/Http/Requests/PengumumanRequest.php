<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi Pengumuman
 * Digunakan untuk store dan update pengumuman
 */
class PengumumanRequest extends FormRequest
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
            'prioritas' => ['required', 'in:rendah,sedang,tinggi'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_berakhir' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
            // Fitur baru
            'is_featured' => ['nullable', 'boolean'],
            'is_pinned' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
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
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul pengumuman maksimal 255 karakter.',
            'konten.required' => 'Konten pengumuman wajib diisi.',
            'prioritas.required' => 'Prioritas wajib dipilih.',
            'prioritas.in' => 'Prioritas tidak valid.',
            'lampiran.file' => 'Lampiran harus berupa file.',
            'lampiran.mimes' => 'Format lampiran harus: PDF, DOC, atau DOCX.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5MB.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_berakhir.date' => 'Format tanggal berakhir tidak valid.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            // Fitur baru
            'meta_title.max' => 'Meta title maksimal 70 karakter untuk SEO optimal.',
            'meta_description.max' => 'Meta description maksimal 160 karakter untuk SEO optimal.',
            'meta_keywords.max' => 'Meta keywords maksimal 255 karakter.',
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
            'judul' => 'judul pengumuman',
            'konten' => 'isi pengumuman',
            'prioritas' => 'prioritas',
            'lampiran' => 'lampiran',
            'tanggal_mulai' => 'tanggal mulai',
            'tanggal_berakhir' => 'tanggal berakhir',
            'status' => 'status',
            'is_featured' => 'featured',
            'is_pinned' => 'pinned',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
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
        ]);
    }
}
