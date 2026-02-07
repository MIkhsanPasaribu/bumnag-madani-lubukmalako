@extends('layouts.public')

@section('title', 'Hubungi Kami')

@section('meta_description', 'Hubungi BUMNag Madani Lubuk Malako - Kirim pesan, pertanyaan, atau saran kepada kami')

@section('content')
{{-- Hero Banner --}}
<section class="relative bg-gradient-to-r from-gray-900 to-gray-800 py-12 md:py-16 overflow-hidden">
    <div class="absolute inset-0 bg-[url('/uploads/{{ $profil->logo ?? '' }}')] bg-center bg-no-repeat bg-contain opacity-5"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Hubungi Kami</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">
            Kami siap membantu Anda. Kirimkan pertanyaan, saran, atau masukan Anda kepada BUMNag Madani Lubuk Malako.
        </p>
    </div>
</section>

{{-- Main Content --}}
<section class="py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">
            
            {{-- Left: Info Kontak --}}
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Hubungi Kami</h2>

                <div class="space-y-6">
                    {{-- Telepon --}}
                    @if($kontak->telepon)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Nomor Telepon</h3>
                            <p class="text-gray-600">{{ $kontak->telepon }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- WhatsApp --}}
                    @if($kontak->whatsapp)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">WhatsApp</h3>
                            <p class="text-gray-600">{{ $kontak->whatsapp }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Email --}}
                    @if($kontak->email)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Email</h3>
                            <p class="text-gray-600">{{ $kontak->email }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Alamat --}}
                    @if($kontak->alamat)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Alamat</h3>
                            <p class="text-gray-600">{{ $kontak->alamat }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Media Sosial --}}
                @if($kontak->facebook || $kontak->instagram || $kontak->youtube || $kontak->tiktok || $kontak->twitter)
                <div class="mt-8">
                    <h3 class="font-semibold text-gray-900 text-lg mb-4">Media Sosial</h3>
                    <div class="space-y-3">
                        @if($kontak->youtube)
                        <a href="{{ $kontak->youtube }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-red-600 transition-colors group">
                            <div class="w-8 h-8 bg-gray-100 group-hover:bg-red-100 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <span class="text-sm">{{ $kontak->youtube }}</span>
                        </a>
                        @endif

                        @if($kontak->facebook)
                        <a href="{{ $kontak->facebook }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-blue-600 transition-colors group">
                            <div class="w-8 h-8 bg-gray-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <span class="text-sm">{{ $kontak->facebook }}</span>
                        </a>
                        @endif

                        @if($kontak->instagram)
                        <a href="https://instagram.com/{{ ltrim($kontak->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-pink-600 transition-colors group">
                            <div class="w-8 h-8 bg-gray-100 group-hover:bg-pink-100 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <span class="text-sm">{{ $kontak->instagram }}</span>
                        </a>
                        @endif

                        @if($kontak->tiktok)
                        <a href="https://tiktok.com/{{ ltrim($kontak->tiktok, '@') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-gray-900 transition-colors group">
                            <div class="w-8 h-8 bg-gray-100 group-hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </div>
                            <span class="text-sm">{{ $kontak->tiktok }}</span>
                        </a>
                        @endif

                        @if($kontak->twitter)
                        <a href="https://x.com/{{ ltrim($kontak->twitter, '@') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-gray-900 transition-colors group">
                            <div class="w-8 h-8 bg-gray-100 group-hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </div>
                            <span class="text-sm">{{ $kontak->twitter }}</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Google Maps --}}
                @if($kontak->google_maps_embed)
                <div class="mt-8">
                    <h3 class="font-semibold text-gray-900 text-lg mb-4">Lokasi Kami</h3>
                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-200">
                        <iframe src="{{ $kontak->google_maps_embed }}" 
                                width="100%" height="250" style="border:0;" 
                                allowfullscreen="" loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full"></iframe>
                    </div>
                </div>
                @endif
            </div>

            {{-- Right: Form Kontak --}}
            <div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-500 text-sm mb-6">Isi formulir di bawah ini untuk mengirim pesan kepada kami.</p>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('hubungi-kami.store') }}" method="POST" x-data="{ charCount: 0 }">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="mb-5">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                   class="form-input @error('nama') border-red-500 @enderror"
                                   placeholder="Masukkan Nama Lengkap Anda" required>
                            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Organisasi --}}
                        <div class="mb-5">
                            <label for="organisasi" class="block text-sm font-medium text-gray-700 mb-1">
                                Organisasi / Instansi
                            </label>
                            <input type="text" id="organisasi" name="organisasi" value="{{ old('organisasi') }}"
                                   class="form-input"
                                   placeholder="Masukkan Nama Organisasi Anda">
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email_form" class="block text-sm font-medium text-gray-700 mb-1">
                                E-mail <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email_form" name="email" value="{{ old('email') }}"
                                   class="form-input @error('email') border-red-500 @enderror"
                                   placeholder="Masukkan Alamat E-mail Anda" required>
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Subjek --}}
                        <div class="mb-5">
                            <label for="subjek" class="block text-sm font-medium text-gray-700 mb-1">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}"
                                   class="form-input @error('subjek') border-red-500 @enderror"
                                   placeholder="Masukkan Subjek" required>
                            @error('subjek')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Pesan --}}
                        <div class="mb-5">
                            <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="pesan" name="pesan" rows="5" maxlength="600"
                                      x-on:input="charCount = $el.value.length"
                                      class="form-input @error('pesan') border-red-500 @enderror"
                                      placeholder="Masukkan Pesan Anda (Maksimal 600 Karakter)" required>{{ old('pesan') }}</textarea>
                            <div class="flex justify-between items-center mt-1">
                                @error('pesan')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
                                <p class="text-xs text-gray-400 ml-auto" x-text="charCount + '/600'">0/600</p>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-primary w-full justify-center text-base py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
