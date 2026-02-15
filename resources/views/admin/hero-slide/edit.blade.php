@extends('layouts.admin')

@section('title', 'Edit Hero Slide')
@section('page_title', 'Edit Hero Slide')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.hero-slide.index') }}" class="hover:text-primary transition-colors">Hero Slide</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">Edit</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Edit Hero Slide</h1>
        </div>
        <a href="{{ route('admin.hero-slide.index') }}" class="btn-ghost w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.hero-slide.update', $hero_slide) }}" method="POST" enctype="multipart/form-data" 
      x-data="{ 
          tipeMedia: '{{ old('tipe_media', $hero_slide->tipe_media) }}',
          previewUrl: null,
          hasNewFile: false,
          handleFileChange(event) {
              const file = event.target.files[0];
              if (file) {
                  this.previewUrl = URL.createObjectURL(file);
                  this.hasNewFile = true;
              }
          }
      }">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            {{-- Konten Slide --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                    Konten Slide
                </h2>
                
                <div class="space-y-5">
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="form-label">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $hero_slide->judul) }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Contoh: Selamat Datang di BUMNag Madani"
                               required>
                        @error('judul')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subjudul --}}
                    <div>
                        <label for="subjudul" class="form-label">Subjudul</label>
                        <textarea id="subjudul" 
                                  name="subjudul" 
                                  rows="3" 
                                  class="form-input @error('subjudul') border-red-500 ring-red-500 @enderror"
                                  placeholder="Deskripsi singkat yang tampil di bawah judul">{{ old('subjudul', $hero_slide->subjudul) }}</textarea>
                        @error('subjudul')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Media Upload --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Media
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="tipe_media" class="form-label">Tipe Media <span class="text-red-500">*</span></label>
                        <select id="tipe_media" name="tipe_media" x-model="tipeMedia"
                                class="form-input @error('tipe_media') border-red-500 @enderror">
                            <option value="gambar">🖼️ Gambar</option>
                            <option value="video">🎥 Video</option>
                        </select>
                        @error('tipe_media')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Current Media Preview --}}
                    <div x-show="!hasNewFile">
                        <p class="text-xs text-gray-500 mb-2">Media saat ini:</p>
                        <div class="relative w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                            @if($hero_slide->is_video)
                                <video src="{{ $hero_slide->media_url }}" class="w-full h-full object-cover" controls muted></video>
                            @else
                                <img src="{{ $hero_slide->media_url }}" alt="{{ $hero_slide->judul }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="media_file" class="form-label">Ganti File Media</label>
                        <input type="file" id="media_file" name="media_file" 
                               @change="handleFileChange($event)"
                               :accept="tipeMedia === 'video' ? 'video/mp4,video/webm' : 'image/jpeg,image/png,image/webp'"
                               class="block w-full text-sm text-gray-500 
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-medium
                                      file:bg-primary/10 file:text-primary
                                      hover:file:bg-primary/20 
                                      file:transition-colors file:cursor-pointer
                                      @error('media_file') file:bg-red-100 file:text-red-600 @enderror">
                        <p class="text-xs text-gray-500 mt-2">
                            Kosongkan jika tidak ingin mengganti media.
                            <span x-show="tipeMedia === 'gambar'">Format: JPG, PNG, WebP. Maks: 10MB.</span>
                            <span x-show="tipeMedia === 'video'">Format: MP4, WebM. Maks: 100MB.</span>
                        </p>
                        @error('media_file')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New File Preview --}}
                    <div x-show="hasNewFile && previewUrl" x-cloak>
                        <p class="text-xs text-gray-500 mb-2">Preview media baru:</p>
                        <div class="relative w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                            <template x-if="tipeMedia === 'gambar'">
                                <img :src="previewUrl" alt="Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="tipeMedia === 'video'">
                                <video :src="previewUrl" class="w-full h-full object-cover" controls muted></video>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA Button --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Tombol CTA (Opsional)
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="teks_tombol" class="form-label">Teks Tombol</label>
                        <input type="text" id="teks_tombol" name="teks_tombol" value="{{ old('teks_tombol', $hero_slide->teks_tombol) }}"
                               class="form-input @error('teks_tombol') border-red-500 ring-red-500 @enderror"
                               placeholder="Contoh: Tentang Kami">
                        @error('teks_tombol')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="url_tombol" class="form-label">URL Tombol</label>
                        <input type="text" id="url_tombol" name="url_tombol" value="{{ old('url_tombol', $hero_slide->url_tombol) }}"
                               class="form-input @error('url_tombol') border-red-500 ring-red-500 @enderror"
                               placeholder="Contoh: /profil atau https://...">
                        @error('url_tombol')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Sidebar Settings --}}
        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            {{-- Pengaturan --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </h2>
                
                <div class="space-y-4">
                    {{-- Status --}}
                    <div>
                        <label for="status" class="form-label">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" class="form-input @error('status') border-red-500 @enderror" required>
                            <option value="aktif" {{ old('status', $hero_slide->status) === 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="tidak_aktif" {{ old('status', $hero_slide->status) === 'tidak_aktif' ? 'selected' : '' }}>⏸️ Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Urutan --}}
                    <div>
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $hero_slide->urutan) }}" min="0"
                               class="form-input @error('urutan') border-red-500 ring-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Angka kecil ditampilkan lebih dulu</p>
                        @error('urutan')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
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
                
                <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                    <input type="hidden" name="tampilkan_logo" value="0">
                    <input type="checkbox" id="tampilkan_logo" name="tampilkan_logo" value="1"
                           {{ old('tampilkan_logo', $hero_slide->tampilkan_logo) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <div>
                        <span class="text-sm font-medium text-gray-700">🏷️ Tampilkan Logo</span>
                        <p class="text-xs text-gray-500">Tampilkan logo BUMNag di slide ini</p>
                    </div>
                </label>
            </div>
            
            {{-- Actions --}}
            <div class="bento-card-flat bg-gray-50">
                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Slide
                    </button>
                    <a href="{{ route('admin.hero-slide.index') }}" class="btn-ghost w-full justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
