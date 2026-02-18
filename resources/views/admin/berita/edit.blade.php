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
        <div class="flex items-center gap-2">
            <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Lihat
            </a>
            <a href="{{ route('admin.berita.index') }}" class="btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.berita.update', $berita) }}" 
      method="POST" 
      enctype="multipart/form-data"
      x-data="{
          status: '{{ old('status', $berita->status) }}',
          isScheduled: {{ old('is_scheduled', $berita->is_scheduled) ? 'true' : 'false' }},
          showSeoSection: false,
          showGallerySection: {{ $berita->gambarGallery && $berita->gambarGallery->count() > 0 ? 'true' : 'false' }},
          galleryImages: [],
          existingGallery: {{ $berita->gambarGallery ? json_encode($berita->gambarGallery->map(fn($g) => ['id' => $g->id, 'url' => $g->url, 'caption' => $g->caption])) : '[]' }},
          deletedGalleryIds: [],
          previewGalleryImages() {
              const files = this.$refs.galleryInput.files;
              for (let i = 0; i < files.length; i++) {
                  const reader = new FileReader();
                  reader.onload = (e) => {
                      this.galleryImages.push({ src: e.target.result, name: files[i].name });
                  };
                  reader.readAsDataURL(files[i]);
              }
          },
          removeGalleryImage(index) {
              this.galleryImages.splice(index, 1);
          },
          removeExistingGalleryImage(id, index) {
              this.deletedGalleryIds.push(id);
              this.existingGallery.splice(index, 1);
          }
      }">
    @csrf
    @method('PUT')
    
    {{-- Hidden field for deleted gallery images --}}
    <template x-for="id in deletedGalleryIds" :key="id">
        <input type="hidden" name="deleted_gallery_ids[]" :value="id">
    </template>
    
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
                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select id="kategori_id" name="kategori_id" class="form-input @error('kategori_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                        {{ old('kategori_id', $berita->kategori_id) == $kategori->id ? 'selected' : '' }}
                                        data-color="{{ $kategori->warna }}">
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Judul --}}
                    <div x-data="{ count: {{ mb_strlen(old('judul', $berita->judul ?? '')) }} }">
                        <label for="judul" class="form-label">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $berita->judul) }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Masukkan judul berita yang menarik"
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
                    
                    {{-- Tanggal Kegiatan --}}
                    <div>
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan/Peristiwa</label>
                        <input type="date" 
                               id="tanggal_kegiatan" 
                               name="tanggal_kegiatan" 
                               value="{{ old('tanggal_kegiatan', $berita->tanggal_kegiatan?->format('Y-m-d')) }}" 
                               class="form-input @error('tanggal_kegiatan') border-red-500 ring-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Tanggal saat kegiatan/peristiwa terjadi (bisa tanggal lampau)</p>
                        @error('tanggal_kegiatan')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Ringkasan --}}
                    <div x-data="{ count: {{ mb_strlen(old('ringkasan', $berita->ringkasan ?? '')) }} }">
                        <label for="ringkasan" class="form-label">Ringkasan</label>
                        <textarea id="ringkasan" 
                                  name="ringkasan" 
                                  rows="2" 
                                  maxlength="1000"
                                  x-on:input="count = $el.value.length"
                                  class="form-input @error('ringkasan') border-red-500 ring-red-500 @enderror"
                                  placeholder="Ringkasan singkat berita (opsional, maks 1000 karakter)">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Akan ditampilkan di daftar berita dan preview</p>
                            <p class="text-xs ml-2 flex-shrink-0 transition-colors" :class="count >= 900 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/1000'">0/1000</p>
                        </div>
                        @error('ringkasan')
                            <p class="form-error mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Konten dengan Rich Text Editor --}}
                    <div>
                        <label for="konten" class="form-label">
                            Konten Berita <span class="text-red-500">*</span>
                        </label>
                        <x-rich-editor 
                            name="konten" 
                            :value="old('konten', $berita->konten)" 
                            placeholder="Tulis isi berita lengkap di sini..."
                            :height="400"
                        />
                        @error('konten')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- Gallery Section --}}
            <div class="bento-card-flat">
                <button type="button" 
                        @click="showGallerySection = !showGallerySection"
                        class="w-full flex items-center justify-between text-lg font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Galeri Foto
                        <span class="text-xs font-normal text-gray-500" 
                              x-text="'(' + (existingGallery.length + galleryImages.length) + ' foto)'"></span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5 text-gray-400 transition-transform duration-200"
                         :class="{ 'rotate-180': showGallerySection }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div x-show="showGallerySection" x-collapse class="mt-4 space-y-4">
                    {{-- Existing Gallery --}}
                    <template x-if="existingGallery.length > 0">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Foto Tersimpan</p>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <template x-for="(img, index) in existingGallery" :key="img.id">
                                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100">
                                        <img :src="img.url" class="w-full h-full object-cover" alt="">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" 
                                                    @click="removeExistingGalleryImage(img.id, index)"
                                                    class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-1 truncate" x-text="img.caption || 'Foto ' + (index + 1)"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    
                    {{-- New Gallery Preview --}}
                    <template x-if="galleryImages.length > 0">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Foto Baru</p>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <template x-for="(img, index) in galleryImages" :key="index">
                                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100">
                                        <img :src="img.src" class="w-full h-full object-cover" alt="">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" 
                                                    @click="removeGalleryImage(index)"
                                                    class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-1 truncate" x-text="img.name"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    
                    {{-- Upload Button --}}
                    <div>
                        <input type="file" 
                               id="gallery" 
                               name="gallery[]" 
                               accept="image/*" 
                               multiple
                               x-ref="galleryInput"
                               @change="previewGalleryImages()"
                               class="hidden">
                        <label for="gallery" 
                               class="flex items-center justify-center gap-2 w-full py-4 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-primary hover:text-primary transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Foto ke Galeri
                        </label>
                        <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WebP. Maks 2MB per foto.</p>
                    </div>
                </div>
            </div>
            
            {{-- Lampiran Section --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Lampiran File
                    <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                </h2>
                
                {{-- Current Lampiran --}}
                @if($berita->lampiran)
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Lampiran Saat Ini</p>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $berita->lampiran_original_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $berita->lampiran_size_formatted }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ $berita->lampiran_url }}" 
                                   target="_blank" 
                                   class="btn-ghost text-sm flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                                <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="hapus_lampiran" value="1" class="rounded text-red-600">
                                    <span>Hapus</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Upload New Lampiran --}}
                <div x-data="{ lampiranName: null, lampiranSize: null }">
                    <p class="text-sm text-gray-600 mb-2">
                        {{ $berita->lampiran ? 'Upload file baru untuk mengganti lampiran:' : 'Tambahkan lampiran:' }}
                    </p>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-primary transition-colors @error('lampiran') border-red-500 @enderror">
                        <input type="file" 
                               id="lampiran" 
                               name="lampiran" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx"
                               class="hidden"
                               @change="lampiranName = $event.target.files[0]?.name; lampiranSize = ($event.target.files[0]?.size / 1024 / 1024).toFixed(2)">
                        
                        <label for="lampiran" class="cursor-pointer">
                            <div x-show="!lampiranName">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <p class="text-gray-600 font-medium">Klik untuk upload lampiran</p>
                                <p class="text-sm text-gray-400 mt-1">PDF, DOC, DOCX, XLS, XLSX (maks 10MB)</p>
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
                    <div x-data="{ count: {{ mb_strlen(old('link_url', $berita->link_url ?? '')) }} }">
                        <label for="link_url" class="form-label">URL Link</label>
                        <input type="url" 
                               id="link_url" 
                               name="link_url" 
                               value="{{ old('link_url', $berita->link_url) }}" 
                               class="form-input @error('link_url') border-red-500 ring-red-500 @enderror"
                               maxlength="500"
                               x-on:input="count = $el.value.length"
                               placeholder="https://contoh.com/sumber">
                        <div class="flex justify-between items-center mt-1">
                            @error('link_url')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 450 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/500'">0/500</p>
                        </div>
                    </div>
                    
                    <div x-data="{ count: {{ mb_strlen(old('link_text', $berita->link_text ?? '')) }} }">
                        <label for="link_text" class="form-label">Teks Link</label>
                        <input type="text" 
                               id="link_text" 
                               name="link_text" 
                               value="{{ old('link_text', $berita->link_text) }}" 
                               class="form-input @error('link_text') border-red-500 ring-red-500 @enderror"
                               maxlength="200"
                               x-on:input="count = $el.value.length"
                               placeholder="Kunjungi sumber berita">
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Teks yang ditampilkan sebagai link. Kosongkan untuk menggunakan URL.</p>
                            <p class="text-xs ml-2 flex-shrink-0 transition-colors" :class="count >= 180 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/200'">0/200</p>
                        </div>
                        @error('link_text')
                            <p class="form-error mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- SEO Section --}}
            <div class="bento-card-flat">
                <button type="button" 
                        @click="showSeoSection = !showSeoSection"
                        class="w-full flex items-center justify-between text-lg font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        SEO & Meta Tags
                        <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5 text-gray-400 transition-transform duration-200"
                         :class="{ 'rotate-180': showSeoSection }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div x-show="showSeoSection" x-collapse class="mt-4 space-y-4">
                    <div x-data="{ count: {{ mb_strlen(old('meta_title', $berita->meta_title ?? '')) }} }">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title', $berita->meta_title) }}" 
                               class="form-input"
                               placeholder="Judul untuk mesin pencari (maks 70 karakter)"
                               maxlength="70"
                               x-on:input="count = $el.value.length">
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Kosongkan untuk menggunakan judul berita</p>
                            <p class="text-xs ml-2 flex-shrink-0 transition-colors" :class="count >= 60 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/70'">0/70</p>
                        </div>
                    </div>
                    
                    <div x-data="{ count: {{ mb_strlen(old('meta_description', $berita->meta_description ?? '')) }} }">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="2" 
                                  class="form-input"
                                  placeholder="Deskripsi untuk mesin pencari (maks 160 karakter)"
                                  maxlength="160"
                                  x-on:input="count = $el.value.length">{{ old('meta_description', $berita->meta_description) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Kosongkan untuk menggunakan ringkasan</p>
                            <p class="text-xs ml-2 flex-shrink-0 transition-colors" :class="count >= 145 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/160'">0/160</p>
                        </div>
                    </div>
                    
                    <div x-data="{ count: {{ mb_strlen(old('meta_keywords', $berita->meta_keywords ?? '')) }} }">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" 
                               id="meta_keywords" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords', $berita->meta_keywords) }}" 
                               class="form-input"
                               maxlength="255"
                               x-on:input="count = $el.value.length"
                               placeholder="kata kunci, dipisah, dengan koma">
                        <div class="flex justify-end mt-1">
                            <p class="text-xs flex-shrink-0 transition-colors" :class="count >= 230 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/255'">0/255</p>
                        </div>
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
                    Gambar Utama
                </h2>
                
                <div x-data="{ imagePreview: '{{ $berita->gambar ? $berita->gambar_url : '' }}' }">
                    <div class="mb-3">
                        <div x-show="imagePreview" 
                             class="relative w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                            <img :src="imagePreview" class="w-full h-full object-cover" alt="Preview">
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
                                  file:transition-colors file:cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WebP. Maks 2MB.</p>
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
                        <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" x-model="status" class="form-input" required>
                            <option value="draft">📝 Draft</option>
                            <option value="published">🌐 Published</option>
                        </select>
                    </div>
                    
                    {{-- Scheduled Publishing --}}
                    <div x-show="status === 'published'" x-collapse>
                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                            <input type="checkbox" 
                                   name="is_scheduled" 
                                   value="1"
                                   x-model="isScheduled"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Jadwalkan Publikasi</span>
                                <p class="text-xs text-gray-500">Atur waktu kapan berita akan dipublish</p>
                            </div>
                        </label>
                        
                        <div x-show="isScheduled" x-collapse class="mt-3">
                            <label for="tanggal_publikasi" class="form-label">Tanggal & Waktu Publikasi</label>
                            <input type="datetime-local" 
                                   id="tanggal_publikasi" 
                                   name="tanggal_publikasi" 
                                   value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi?->format('Y-m-d\TH:i')) }}"
                                   class="form-input">
                        </div>
                    </div>
                    
                    {{-- Featured & Pinned --}}
                    <div class="space-y-3 pt-3 border-t border-gray-100">
                        <label class="flex items-center gap-3 p-3 bg-yellow-50 rounded-lg cursor-pointer hover:bg-yellow-100 transition">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $berita->is_featured) ? 'checked' : '' }}
                                   class="w-4 h-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                            <div>
                                <span class="text-sm font-medium text-gray-700 flex items-center gap-1">
                                    ⭐ Berita Utama
                                </span>
                                <p class="text-xs text-gray-500">Tampilkan di section highlight beranda</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-3 p-3 bg-primary/5 rounded-lg cursor-pointer hover:bg-primary/10 transition">
                            <input type="checkbox" 
                                   name="is_pinned" 
                                   value="1"
                                   {{ old('is_pinned', $berita->is_pinned) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <div>
                                <span class="text-sm font-medium text-gray-700 flex items-center gap-1">
                                    📌 Sematkan
                                </span>
                                <p class="text-xs text-gray-500">Tampilkan selalu di atas daftar</p>
                            </div>
                        </label>
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
                    @if($berita->kategori)
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Kategori</dt>
                        <dd class="inline-flex items-center gap-1.5 font-medium">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $berita->kategori->warna }};"></span>
                            <span style="color: {{ $berita->kategori->warna }}">{{ $berita->kategori->nama }}</span>
                        </dd>
                    </div>
                    @endif
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
