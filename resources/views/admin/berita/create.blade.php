@extends('layouts.admin')

@section('title', 'Tambah Berita')
@section('page_title', 'Tambah Berita')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.berita.index') }}" class="hover:text-primary transition-colors">Berita</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">Tambah</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Berita Baru</h1>
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
<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" x-data="beritaForm()">
    @csrf
    
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
                               value="{{ old('judul') }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Masukkan judul berita yang menarik"
                               required>
                        @error('judul')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select id="kategori_id" name="kategori_id" class="form-input @error('kategori_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Tanggal Kegiatan --}}
                    <div>
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan/Peristiwa</label>
                        <input type="date" 
                               id="tanggal_kegiatan" 
                               name="tanggal_kegiatan" 
                               value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}" 
                               class="form-input @error('tanggal_kegiatan') border-red-500 ring-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Tanggal saat kegiatan/peristiwa terjadi (bisa tanggal lampau)</p>
                        @error('tanggal_kegiatan')
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
                                  placeholder="Ringkasan singkat berita (opsional, maks 500 karakter)">{{ old('ringkasan') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di daftar berita dan preview</p>
                        @error('ringkasan')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Konten dengan Rich Text Editor --}}
                    <x-rich-editor 
                        name="konten" 
                        :value="old('konten', '')" 
                        label="Konten Berita"
                        :required="true"
                        placeholder="Tulis isi berita lengkap di sini..."
                    />
                </div>
            </div>

            {{-- Gallery Gambar --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Gallery Gambar (Opsional)
                </h2>
                
                <div>
                    <input type="file" 
                           name="gallery[]" 
                           multiple
                           accept="image/*" 
                           class="block w-full text-sm text-gray-500 
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-primary/10 file:text-primary
                                  hover:file:bg-primary/20 
                                  file:transition-colors file:cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">
                        Pilih beberapa gambar sekaligus. Format: JPG, PNG, WebP. Maks 2MB per file.
                    </p>
                    @error('gallery.*')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Lampiran File --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Lampiran File (Opsional)
                </h2>
                
                <div x-data="{ lampiranName: null, lampiranSize: null }">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-primary transition-colors @error('lampiran') border-red-500 @enderror">
                        <input type="file" 
                               id="lampiran" 
                               name="lampiran" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx"
                               class="hidden"
                               @change="lampiranName = $event.target.files[0]?.name; lampiranSize = ($event.target.files[0]?.size / 1024 / 1024).toFixed(2)">
                        
                        <label for="lampiran" class="cursor-pointer">
                            <div x-show="!lampiranName">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <p class="text-gray-600 font-medium">Klik untuk upload lampiran</p>
                                <p class="text-sm text-gray-400 mt-1">PDF, DOC, DOCX, XLS, XLSX</p>
                            </div>
                            
                            <div x-show="lampiranName" x-cloak class="text-left">
                                <div class="flex items-center gap-3 p-3 bg-primary/10 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-900 truncate" x-text="lampiranName"></p>
                                        <p class="text-sm text-gray-500"><span x-text="lampiranSize"></span> MB</p>
                                    </div>
                                </div>
                                <p class="text-xs text-primary mt-2 text-center">Klik untuk mengganti file</p>
                            </div>
                        </label>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">Maksimal ukuran: 10MB</p>
                    @error('lampiran')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Link Eksternal --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Link Eksternal (Opsional)
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="link_url" class="form-label">URL Link</label>
                        <input type="url" 
                               id="link_url" 
                               name="link_url" 
                               value="{{ old('link_url') }}" 
                               class="form-input @error('link_url') border-red-500 ring-red-500 @enderror"
                               placeholder="https://contoh.com/sumber">
                        @error('link_url')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="link_text" class="form-label">Teks Link</label>
                        <input type="text" 
                               id="link_text" 
                               name="link_text" 
                               value="{{ old('link_text') }}" 
                               class="form-input @error('link_text') border-red-500 ring-red-500 @enderror"
                               placeholder="Kunjungi sumber berita">
                        <p class="text-xs text-gray-500 mt-1">Teks yang ditampilkan sebagai link. Kosongkan untuk menggunakan URL.</p>
                        @error('link_text')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SEO Meta Tags --}}
            <div class="bento-card-flat" x-data="{ open: false }">
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
                    <div>
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title') }}" 
                               class="form-input" 
                               placeholder="Judul untuk mesin pencari (maks 70 karakter)"
                               maxlength="70">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk menggunakan judul berita</p>
                    </div>
                    
                    <div>
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="2" 
                                  class="form-input"
                                  placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)"
                                  maxlength="160">{{ old('meta_description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan untuk menggunakan ringkasan</p>
                    </div>
                    
                    <div>
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" 
                               id="meta_keywords" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords') }}" 
                               class="form-input" 
                               placeholder="kata kunci, dipisah, koma">
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
                
                <div x-data="{ imagePreview: null }">
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
                        Format: JPG, PNG, WebP. Maks 2MB.
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
                        <select id="status" name="status" class="form-input @error('status') border-red-500 @enderror" required x-model="status">
                            <option value="draft">📝 Draft</option>
                            <option value="published">🌐 Publish</option>
                        </select>
                        @error('status')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Scheduled Publishing --}}
                    <div x-show="status === 'published'" x-collapse>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_scheduled" 
                                   value="1"
                                   x-model="isScheduled"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm text-gray-700">Jadwalkan publikasi</span>
                        </label>
                    </div>

                    {{-- Tanggal Publikasi --}}
                    <div x-show="status === 'published' && isScheduled" x-collapse>
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="datetime-local" 
                               id="tanggal_publikasi" 
                               name="tanggal_publikasi" 
                               value="{{ old('tanggal_publikasi') }}" 
                               class="form-input">
                        <p class="text-xs text-gray-500 mt-1">Berita akan otomatis publish pada waktu yang ditentukan</p>
                    </div>
                </div>
            </div>

            {{-- Opsi Tambahan --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Opsi Tambahan
                </h2>
                
                <div class="space-y-3">
                    {{-- Featured --}}
                    <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1"
                               {{ old('is_featured') ? 'checked' : '' }}
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <div>
                            <span class="text-sm font-medium text-gray-700">⭐ Featured</span>
                            <p class="text-xs text-gray-500">Tampilkan di bagian utama/highlight</p>
                        </div>
                    </label>

                    {{-- Pinned --}}
                    <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="checkbox" 
                               name="is_pinned" 
                               value="1"
                               {{ old('is_pinned') ? 'checked' : '' }}
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <div>
                            <span class="text-sm font-medium text-gray-700">📌 Pinned</span>
                            <p class="text-xs text-gray-500">Sematkan di posisi teratas daftar</p>
                        </div>
                    </label>
                </div>
            </div>
            
            {{-- Info Tambahan --}}
            <div class="bento-card-flat bg-blue-50 border border-blue-100">
                <div class="flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Info:</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-700">
                            <li>Nama penulis otomatis tercatat</li>
                            <li>Slug URL dibuat otomatis dari judul</li>
                            <li>Gallery dapat ditambahkan setelah disimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            {{-- Actions --}}
            <div class="bento-card-flat bg-gray-50">
                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Berita
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn-ghost w-full justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function beritaForm() {
    return {
        status: '{{ old('status', 'draft') }}',
        isScheduled: {{ old('is_scheduled') ? 'true' : 'false' }}
    }
}
</script>
@endpush
@endsection
