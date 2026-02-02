@extends('layouts.admin')

@section('title', 'Edit Kategori Berita')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <x-page-header 
        title="Edit Kategori Berita"
        subtitle="Ubah informasi kategori {{ $kategoriBerita->nama }}"
    >
        <a href="{{ route('admin.kategori-berita.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </x-page-header>

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.kategori-berita.update', $kategoriBerita) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Kategori --}}
                <div class="space-y-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700">
                        Nama Kategori <span class="text-secondary">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $kategoriBerita->nama) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: Ekonomi"
                           required>
                    @error('nama')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Warna --}}
                <div class="space-y-2">
                    <label for="warna" class="block text-sm font-medium text-gray-700">
                        Warna Badge
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               name="warna" 
                               id="warna" 
                               value="{{ old('warna', $kategoriBerita->warna ?? '#86ae5f') }}"
                               class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                        <input type="text" 
                               id="warna_text"
                               value="{{ old('warna', $kategoriBerita->warna ?? '#86ae5f') }}"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="#86ae5f"
                               pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                    @error('warna')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('deskripsi') border-red-500 @enderror"
                          placeholder="Deskripsi singkat tentang kategori ini...">{{ old('deskripsi', $kategoriBerita->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Icon --}}
                <div class="space-y-2">
                    <label for="icon" class="block text-sm font-medium text-gray-700">
                        Icon (opsional)
                    </label>
                    <input type="text" 
                           name="icon" 
                           id="icon" 
                           value="{{ old('icon', $kategoriBerita->icon) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                           placeholder="Contoh: newspaper, chart-bar">
                    <p class="text-xs text-gray-500">Nama icon Heroicons (tanpa prefix)</p>
                    @error('icon')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Urutan --}}
                <div class="space-y-2">
                    <label for="urutan" class="block text-sm font-medium text-gray-700">
                        Urutan
                    </label>
                    <input type="number" 
                           name="urutan" 
                           id="urutan" 
                           value="{{ old('urutan', $kategoriBerita->urutan) }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                           placeholder="0">
                    <p class="text-xs text-gray-500">Urutan tampil (angka kecil di depan)</p>
                    @error('urutan')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status Aktif --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1"
                       {{ old('is_active', $kategoriBerita->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                <label for="is_active" class="text-sm font-medium text-gray-700">
                    Aktif (dapat digunakan untuk berita)
                </label>
            </div>

            {{-- Preview Badge --}}
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-700 mb-3">Preview Badge:</p>
                <span id="badge_preview" 
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white"
                      style="background-color: {{ old('warna', $kategoriBerita->warna ?? '#86ae5f') }}">
                    {{ old('nama', $kategoriBerita->nama) }}
                </span>
            </div>

            {{-- Info --}}
            <div class="p-4 bg-blue-50 rounded-lg text-sm text-blue-800">
                <p><strong>Jumlah Berita:</strong> {{ $kategoriBerita->berita()->count() }} berita menggunakan kategori ini</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.kategori-berita.index') }}" 
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Sync color input with text input
    const warnaInput = document.getElementById('warna');
    const warnaText = document.getElementById('warna_text');
    const namaInput = document.getElementById('nama');
    const badgePreview = document.getElementById('badge_preview');

    warnaInput.addEventListener('input', function() {
        warnaText.value = this.value;
        badgePreview.style.backgroundColor = this.value;
    });

    warnaText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            warnaInput.value = this.value;
            badgePreview.style.backgroundColor = this.value;
        }
    });

    namaInput.addEventListener('input', function() {
        badgePreview.textContent = this.value || 'Nama Kategori';
    });
</script>
@endpush
@endsection
