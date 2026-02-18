<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request untuk validasi Kategori Berita
 * Digunakan untuk store dan update kategori
 */
class KategoriBeritaRequest extends FormRequest
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
        $kategoriId = $this->route('kategori_berita')?->id ?? $this->route('kategori_beritum')?->id;

        return [
            'nama' => [
                'required',
                'string',
                'max:200',
                Rule::unique('kategori_berita', 'nama')->ignore($kategoriId),
            ],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'warna' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
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
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.max' => 'Nama kategori maksimal 200 karakter.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'warna.regex' => 'Format warna harus hexadecimal (contoh: #86ae5f).',
            'icon.max' => 'Nama icon maksimal 100 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal 0.',
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
            'nama' => 'nama kategori',
            'deskripsi' => 'deskripsi',
            'warna' => 'warna',
            'icon' => 'icon',
            'is_active' => 'status aktif',
            'urutan' => 'urutan',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') && $this->is_active,
        ]);
    }
}
