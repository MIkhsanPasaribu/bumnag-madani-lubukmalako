@extends('layouts.admin')

@section('title', 'Informasi Kontak')
@section('page_title', 'Informasi Kontak')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Card --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-6 overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Informasi Kontak</h1>
                <p class="text-white/70 text-sm mt-1">Kelola informasi kontak yang ditampilkan di halaman Hubungi Kami</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.kontak-info.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Kontak Utama --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Kontak Utama</h3>
                            <p class="text-xs text-gray-500">Nomor telepon, email, dan alamat</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" id="telepon" name="telepon" 
                                   value="{{ old('telepon', $kontak->telepon) }}" 
                                   class="form-input @error('telepon') border-red-500 @enderror"
                                   placeholder="Contoh: 0800 1088888">
                            @error('telepon')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" id="whatsapp" name="whatsapp" 
                                   value="{{ old('whatsapp', $kontak->whatsapp) }}" 
                                   class="form-input @error('whatsapp') border-red-500 @enderror"
                                   placeholder="Contoh: 08123456789">
                            @error('whatsapp')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" 
                               value="{{ old('email', $kontak->email) }}" 
                               class="form-input @error('email') border-red-500 @enderror"
                               placeholder="Contoh: info@bumnagmadani.id">
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" 
                                  class="form-input @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $kontak->alamat) }}</textarea>
                        @error('alamat')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label for="google_maps_embed" class="form-label">Google Maps Embed URL</label>
                        <input type="text" id="google_maps_embed" name="google_maps_embed" 
                               value="{{ old('google_maps_embed', $kontak->google_maps_embed) }}" 
                               class="form-input @error('google_maps_embed') border-red-500 @enderror"
                               placeholder="Contoh: https://www.google.com/maps/embed?pb=...">
                        <p class="text-xs text-gray-400 mt-1">Ambil dari Google Maps > Share > Embed a map > Copy src URL</p>
                        @error('google_maps_embed')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Media Sosial --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Media Sosial</h3>
                            <p class="text-xs text-gray-500">Link media sosial BUMNag</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="facebook" class="form-label">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    Facebook
                                </span>
                            </label>
                            <input type="text" id="facebook" name="facebook" 
                                   value="{{ old('facebook', $kontak->facebook) }}" 
                                   class="form-input"
                                   placeholder="https://facebook.com/...">
                        </div>
                        <div>
                            <label for="instagram" class="form-label">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    Instagram
                                </span>
                            </label>
                            <input type="text" id="instagram" name="instagram" 
                                   value="{{ old('instagram', $kontak->instagram) }}" 
                                   class="form-input"
                                   placeholder="@username">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="youtube" class="form-label">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    YouTube
                                </span>
                            </label>
                            <input type="text" id="youtube" name="youtube" 
                                   value="{{ old('youtube', $kontak->youtube) }}" 
                                   class="form-input"
                                   placeholder="https://youtube.com/...">
                        </div>
                        <div>
                            <label for="tiktok" class="form-label">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                    TikTok
                                </span>
                            </label>
                            <input type="text" id="tiktok" name="tiktok" 
                                   value="{{ old('tiktok', $kontak->tiktok) }}" 
                                   class="form-input"
                                   placeholder="@username">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="twitter" class="form-label">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    X (Twitter)
                                </span>
                            </label>
                            <input type="text" id="twitter" name="twitter" 
                                   value="{{ old('twitter', $kontak->twitter) }}" 
                                   class="form-input"
                                   placeholder="@username">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
