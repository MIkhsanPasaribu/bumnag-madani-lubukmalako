@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.berita.index') }}" class="hover:text-primary transition-colors">Berita</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">Edit</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Edit Berita</h1>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="btn-ghost w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            {{-- Informasi Dasar --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Informasi Berita
                </h2>
                
                <div class="space-y-5">
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="form-label">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $berita->judul) }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Masukkan judul berita yang menarik"
                               required>
                        @error('judul')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Ringkasan --}}
                    <div>
                        <label for="ringkasan" class="form-label">Ringkasan</label>
                        <textarea id="ringkasan" 
                                  name="ringkasan" 
                                  rows="2" 
                                  class="form-input @error('ringkasan') border-red-500 ring-red-500 @enderror"
                                  placeholder="Ringkasan singkat berita (opsional, maks 500 karakter)">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di daftar berita dan preview</p>
                        @error('ringkasan')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Konten --}}
                    <div>
                        <label for="konten" class="form-label">
                            Konten Berita <span class="text-red-500">*</span>
                        </label>
                        <textarea id="konten" 
                                  name="konten" 
                                  rows="12" 
                                  class="form-input @error('konten') border-red-500 ring-red-500 @enderror"
                                  placeholder="Tulis isi berita lengkap di sini..."
                                  required>{{ old('konten', $berita->konten) }}</textarea>
                        @error('konten')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Sidebar Settings --}}
        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            {{-- Gambar Featured --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Gambar Featured
                </h2>
                
                <div x-data="{ imagePreview: '{{ $berita->gambar ? $berita->gambar_url : '' }}' }">
                    {{-- Preview Area --}}
                    <div class="mb-3">
                        <div x-show="imagePreview" 
                             class="relative w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                            <img :src="imagePreview" 
                                 class="w-full h-full object-cover" 
                                 alt="Preview">
                            <button type="button" 
                                    @click="imagePreview = null; $refs.gambarInput.value = ''"
                                    class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="!imagePreview" 
                             class="w-full aspect-video rounded-lg bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm">Belum ada gambar</p>
                        </div>
                    </div>
                    
                    {{-- File Input --}}
                    <input type="file" 
                           id="gambar" 
                           name="gambar" 
                           accept="image/*" 
                           x-ref="gambarInput"
                           @change="if ($event.target.files[0]) {
                               const reader = new FileReader();
                               reader.onload = (e) => imagePreview = e.target.result;
                               reader.readAsDataURL($event.target.files[0]);
                           }"
                           class="block w-full text-sm text-gray-500 
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-primary/10 file:text-primary
                                  hover:file:bg-primary/20 
                                  file:transition-colors file:cursor-pointer
                                  @error('gambar') file:bg-red-100 file:text-red-600 @enderror">
                    <p class="text-xs text-gray-500 mt-2">
                        Format: JPG, PNG, WebP. Maks 2MB. Kosongkan jika tidak ingin mengubah.
                    </p>
                    @error('gambar')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            {{-- Pengaturan Publikasi --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan Publikasi
                </h2>
                
                <div class="space-y-4">
                    {{-- Status --}}
                    <div>
                        <label for="status" class="form-label">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" class="form-input @error('status') border-red-500 @enderror" required>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>🌐 Published</option>
                        </select>
                        @error('status')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- Info Berita --}}
            <div class="bento-card-flat bg-gray-50">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Berita</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Penulis</dt>
                        <dd class="font-medium text-gray-900">{{ $berita->penulis?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Dibuat</dt>
                        <dd class="font-medium text-gray-900">{{ $berita->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    @if($berita->tanggal_publikasi)
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Dipublish</dt>
                        <dd class="font-medium text-gray-900">{{ $berita->tanggal_publikasi->format('d M Y, H:i') }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Total Views</dt>
                        <dd class="font-medium text-gray-900">{{ number_format($berita->views) }}</dd>
                    </div>
                </dl>
            </div>
            
            {{-- Actions --}}
            <div class="bento-card-flat bg-gray-50">
                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn-ghost w-full justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
