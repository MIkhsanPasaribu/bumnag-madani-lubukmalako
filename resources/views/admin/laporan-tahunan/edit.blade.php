@extends('layouts.admin')

@section('title', 'Edit Laporan Tahunan')
@section('page_title', 'Edit Laporan Tahunan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.laporan-tahunan.index') }}" class="hover:text-primary transition-colors">Laporan Tahunan</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">Edit</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Edit Laporan Tahun {{ $laporanTahunan->tahun }}</h1>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            @if($laporanTahunan->status === 'published' && $laporanTahunan->file_url)
                <a href="{{ route('laporan-tahunan.show', $laporanTahunan->slug) }}" target="_blank" class="btn-ghost w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Publik
                </a>
            @endif
            <a href="{{ route('admin.laporan-tahunan.index') }}" class="btn-ghost w-full sm:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.laporan-tahunan.update', $laporanTahunan) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Informasi Laporan --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Informasi Laporan
                </h2>
                
                <div class="space-y-5">
                    {{-- Tahun --}}
                    <div x-data="{ tahun: {{ old('tahun', $laporanTahunan->tahun) }} }">
                        <label for="tahun" class="form-label">
                            Tahun Laporan <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <button type="button" 
                                    @click="tahun--" 
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <input type="number" 
                                   id="tahun" 
                                   name="tahun" 
                                   x-model="tahun"
                                   class="form-input text-center text-lg font-semibold @error('tahun') border-red-500 ring-red-500 @enderror" 
                                   placeholder="YYYY"
                                   required>
                            <button type="button" 
                                    @click="tahun++" 
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        @error('tahun')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Masukkan tahun 4 digit (contoh: 2025). Tahun harus unik, tidak boleh duplikat.</p>
                    </div>
                    
                    {{-- Judul --}}
                    <div x-data="{ count: {{ mb_strlen(old('judul', $laporanTahunan->judul ?? '')) }} }">
                        <label for="judul" class="form-label">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $laporanTahunan->judul) }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Contoh: Laporan Tahunan BUMNag Madani 2025"
                               maxlength="255"
                               x-on:input="count = $el.value.length"
                               required>
                        <div class="flex justify-between items-center mt-1">
                            @error('judul')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 230 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/255'">0/255</p>
                        </div>
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div x-data="{ count: {{ mb_strlen(old('deskripsi', $laporanTahunan->deskripsi ?? '')) }} }">
                        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" 
                                  name="deskripsi" 
                                  rows="3" 
                                  class="form-input @error('deskripsi') border-red-500 ring-red-500 @enderror"
                                  placeholder="Deskripsi singkat tentang laporan ini"
                                  maxlength="2000"
                                  x-on:input="count = $el.value.length">{{ old('deskripsi', $laporanTahunan->deskripsi) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('deskripsi')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 1800 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/2000'">0/2000</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Cover Image --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Cover Laporan
                </h2>
                
                {{-- Current Cover --}}
                <div x-data="{ previewUrl: null, fileName: null }">
                    <div class="flex flex-col sm:flex-row gap-6">
                        {{-- Cover Preview (2:3 portrait ratio) --}}
                        <div class="flex-shrink-0">
                            {{-- Current cover or empty placeholder --}}
                            <div x-show="!previewUrl">
                                @if($laporanTahunan->cover_image)
                                    <div class="relative group cursor-pointer" @click="document.getElementById('cover_image').click()">
                                        <img src="{{ $laporanTahunan->cover_image_url }}" 
                                             alt="Cover {{ $laporanTahunan->judul }}" 
                                             class="w-40 aspect-[2/3] object-cover rounded-xl shadow-md">
                                        <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">Ganti Cover</span>
                                        </div>
                                    </div>
                                @else
                                    <div @click="document.getElementById('cover_image').click()"
                                         class="w-40 aspect-[2/3] rounded-xl border-2 border-dashed border-gray-300 hover:border-primary transition-colors cursor-pointer flex flex-col items-center justify-center bg-gray-50 @error('cover_image') border-red-500 @enderror">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 text-center px-2">Klik untuk upload</p>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- New cover preview --}}
                            <div x-show="previewUrl" x-cloak class="relative group">
                                <img :src="previewUrl" class="w-40 aspect-[2/3] object-cover rounded-xl shadow-md">
                                <button type="button" 
                                        @click="previewUrl = null; fileName = null; document.getElementById('cover_image').value = ''"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        {{-- Info & Upload Button --}}
                        <div class="flex-1 flex flex-col justify-center">
                            <input type="file" 
                                   id="cover_image" 
                                   name="cover_image" 
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   class="hidden"
                                   @change="
                                       const file = $event.target.files[0];
                                       if (file) {
                                           fileName = file.name;
                                           const reader = new FileReader();
                                           reader.onload = (e) => previewUrl = e.target.result;
                                           reader.readAsDataURL(file);
                                       }
                                   ">
                            
                            @if($laporanTahunan->cover_image)
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Cover Saat Ini</p>
                                <p class="text-sm text-gray-600 mb-3">Upload cover baru untuk mengganti</p>
                            @endif
                            
                            <p class="text-sm text-gray-600 mb-1" x-show="fileName" x-text="fileName" x-cloak></p>
                            <p class="text-xs text-gray-500 mb-3">Format: JPEG, JPG, PNG, WEBP (Maks. 5MB)</p>
                            <p class="text-xs text-gray-400 mb-3">Rekomendasi ukuran: <strong>800 x 1200 px</strong> (rasio 2:3 portrait)</p>
                            
                            <button type="button" 
                                    @click="document.getElementById('cover_image').click()"
                                    class="inline-flex items-center gap-2 text-sm text-primary hover:text-primary-dark font-medium transition-colors w-fit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $laporanTahunan->cover_image ? 'Ganti Cover' : 'Pilih Gambar Cover' }}
                            </button>
                            
                            @error('cover_image')
                                <p class="form-error mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- File Laporan --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    File Laporan
                </h2>
                
                {{-- Current File --}}
                @if($laporanTahunan->file_laporan)
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">File Saat Ini</p>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $laporanTahunan->file_original_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $laporanTahunan->file_size_formatted }}</p>
                                </div>
                            </div>
                            <a href="{{ $laporanTahunan->file_url }}" 
                               target="_blank" 
                               class="btn-ghost text-sm flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                @endif
                
                {{-- Upload New File --}}
                <div x-data="{ fileName: null, fileSize: null }">
                    <p class="text-sm text-gray-600 mb-2">
                        {{ $laporanTahunan->file_laporan ? 'Upload file baru untuk mengganti file yang ada:' : 'Upload file laporan:' }}
                    </p>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors @error('file_laporan') border-red-500 @enderror">
                        <input type="file" 
                               id="file_laporan" 
                               name="file_laporan" 
                               accept=".pdf"
                               class="hidden"
                               @change="fileName = $event.target.files[0]?.name; fileSize = ($event.target.files[0]?.size / 1024 / 1024).toFixed(2)">
                        
                        <label for="file_laporan" class="cursor-pointer">
                            <div x-show="!fileName">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-gray-600 font-medium">Klik untuk upload file PDF baru</p>
                                <p class="text-sm text-gray-400 mt-1">atau drag & drop file di sini</p>
                            </div>
                            
                            <div x-show="fileName" x-cloak class="text-left">
                                <div class="flex items-center gap-3 p-3 bg-primary/10 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-900 truncate" x-text="fileName"></p>
                                        <p class="text-sm text-gray-500"><span x-text="fileSize"></span> MB</p>
                                    </div>
                                </div>
                                <p class="text-xs text-primary mt-2 text-center">Klik untuk mengganti file</p>
                            </div>
                        </label>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">Format: PDF. Maksimal ukuran: 20MB</p>
                    @error('file_laporan')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            {{-- SEO Meta Tags --}}
            <div class="bento-card-flat" x-data="{ open: {{ old('meta_title', $laporanTahunan->meta_title) || old('meta_description', $laporanTahunan->meta_description) ? 'true' : 'false' }} }">
                <button type="button" @click="open = !open" class="w-full flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        SEO & Meta Tags
                    </h2>
                    <svg :class="{'rotate-180': open}" class="h-5 w-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="mt-4 space-y-4">
                    <div x-data="{ count: {{ mb_strlen(old('meta_title', $laporanTahunan->meta_title ?? '')) }} }">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title', $laporanTahunan->meta_title) }}" 
                               class="form-input" 
                               placeholder="Judul untuk mesin pencari"
                               maxlength="70"
                               x-on:input="count = $el.value.length">
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Kosongkan untuk menggunakan judul laporan</p>
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 60 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/70'">0/70</p>
                        </div>
                    </div>
                    
                    <div x-data="{ count: {{ mb_strlen(old('meta_description', $laporanTahunan->meta_description ?? '')) }} }">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="2" 
                                  class="form-input"
                                  placeholder="Deskripsi untuk mesin pencari"
                                  maxlength="160"
                                  x-on:input="count = $el.value.length">{{ old('meta_description', $laporanTahunan->meta_description) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Kosongkan untuk menggunakan deskripsi</p>
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 145 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/160'">0/160</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Sidebar Settings --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Publikasi --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Publikasi
                </h2>
                
                <div class="space-y-4">
                    {{-- Status --}}
                    <div>
                        <label for="status" class="form-label">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="draft" {{ old('status', $laporanTahunan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $laporanTahunan->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    
                    {{-- Tombol Simpan --}}
                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Statistik --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistik
                </h2>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Download</span>
                        <span class="font-semibold text-gray-900">{{ number_format($laporanTahunan->download_count) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $laporanTahunan->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $laporanTahunan->status === 'published' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    @if($laporanTahunan->tanggal_publikasi)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dipublikasi</span>
                            <span class="font-medium text-gray-900">{{ $laporanTahunan->tanggal_publikasi->format('d M Y') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="font-medium text-gray-900">{{ $laporanTahunan->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diperbarui</span>
                        <span class="font-medium text-gray-900">{{ $laporanTahunan->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            {{-- Danger Zone --}}
            <div class="bento-card-flat border border-red-200 bg-red-50">
                <h2 class="text-lg font-semibold text-red-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Zona Bahaya
                </h2>
                
                <p class="text-sm text-red-600 mb-4">Hapus laporan ini. Tindakan ini dapat dibatalkan dari arsip.</p>
                
                <button type="button" 
                        onclick="if(confirm('Yakin ingin menghapus laporan ini?')) { document.getElementById('delete-form').submit(); }"
                        class="btn-secondary w-full justify-center text-red-600 border-red-300 hover:bg-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Laporan
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Delete Form --}}
<form id="delete-form" action="{{ route('admin.laporan-tahunan.destroy', $laporanTahunan) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
