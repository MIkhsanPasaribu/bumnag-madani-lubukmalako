@extends('layouts.admin')

@section('title', 'Edit Profil BUMNag')
@section('page_title', 'Edit Profil BUMNag')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header Card --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-6 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Profil Organisasi</h1>
                <p class="text-white/70 text-sm mt-1">Kelola informasi resmi BUMNag Madani Lubuk Malako</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" x-data="profilForm()">
        @csrf
        @method('PUT')
        
        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Left Column - Main Form --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Info Dasar --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Informasi Dasar</h3>
                                <p class="text-xs text-gray-500">Data identitas organisasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_bumnag" class="form-label">Nama BUMNag <span class="text-red-500">*</span></label>
                                <input type="text" id="nama_bumnag" name="nama_bumnag" 
                                       value="{{ old('nama_bumnag', $profil->nama_bumnag ?? '') }}" 
                                       class="form-input @error('nama_bumnag') border-red-500 @enderror" 
                                       placeholder="Masukkan nama BUMNag" required>
                                @error('nama_bumnag')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label for="nama_nagari" class="form-label">Nama Nagari <span class="text-red-500">*</span></label>
                                <input type="text" id="nama_nagari" name="nama_nagari" 
                                       value="{{ old('nama_nagari', $profil->nama_nagari ?? '') }}" 
                                       class="form-input @error('nama_nagari') border-red-500 @enderror" 
                                       placeholder="Masukkan nama nagari" required>
                                @error('nama_nagari')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Kontak --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Informasi Kontak</h3>
                                <p class="text-xs text-gray-500">Alamat dan kontak yang bisa dihubungi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="alamat" name="alamat" rows="2" 
                                      class="form-input @error('alamat') border-red-500 @enderror" 
                                      placeholder="Masukkan alamat lengkap organisasi" required>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                            @error('alamat')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        
                        <div class="grid sm:grid-cols-3 gap-4">
                            <div>
                                <label for="telepon" class="form-label">
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Telepon
                                    </span>
                                </label>
                                <input type="text" id="telepon" name="telepon" 
                                       value="{{ old('telepon', $profil->telepon ?? '') }}" 
                                       class="form-input" placeholder="08xxx">
                            </div>
                            
                            <div>
                                <label for="email" class="form-label">
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                        Email
                                    </span>
                                </label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', $profil->email ?? '') }}" 
                                       class="form-input @error('email') border-red-500 @enderror" 
                                       placeholder="email@domain.com">
                                @error('email')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label for="website" class="form-label">
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        Website
                                    </span>
                                </label>
                                <input type="url" id="website" name="website" 
                                       value="{{ old('website', $profil->website ?? '') }}" 
                                       class="form-input @error('website') border-red-500 @enderror" 
                                       placeholder="https://example.com">
                                @error('website')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Visi Misi --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Visi & Misi</h3>
                                <p class="text-xs text-gray-500">Tujuan dan sasaran organisasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label for="visi" class="form-label">Visi</label>
                            <textarea id="visi" name="visi" rows="3" class="form-input" 
                                      placeholder="Masukkan visi organisasi">{{ old('visi', $profil->visi ?? '') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Gambaran masa depan yang ingin dicapai</p>
                        </div>
                        
                        <div>
                            <label for="misi" class="form-label">Misi</label>
                            <textarea id="misi" name="misi" rows="5" class="form-input" 
                                      placeholder="Pisahkan setiap misi dengan baris baru">{{ old('misi', $profil->misi ?? '') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Tulis setiap poin misi di baris baru</p>
                        </div>
                    </div>
                </div>
                
                {{-- Sejarah --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Sejarah Organisasi</h3>
                                <p class="text-xs text-gray-500">Latar belakang dan perjalanan organisasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <textarea id="sejarah" name="sejarah" rows="6" class="form-input" 
                                  placeholder="Ceritakan sejarah dan perjalanan organisasi">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                    </div>
                </div>
                
                {{-- Struktur Organisasi --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Struktur Organisasi</h3>
                                    <p class="text-xs text-gray-500">Pengurus dan anggota organisasi</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 hidden sm:block">Jumlah: <span x-text="items.length" class="font-semibold text-gray-600"></span> orang</span>
                        </div>
                    </div>
                    
                    <div class="p-5 space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl p-4 border border-gray-200 hover:border-gray-300 transition-colors">
                                <div class="flex gap-4 items-start">
                                    {{-- Photo Preview/Upload --}}
                                    <div class="flex-shrink-0">
                                        <div class="w-20 h-20 bg-white rounded-xl overflow-hidden relative group border-2 border-dashed border-gray-300 hover:border-primary transition-colors">
                                            <template x-if="item.foto || item.foto_preview">
                                                <img :src="item.foto_preview || '/uploads/struktur/' + item.foto" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!item.foto && !item.foto_preview">
                                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center rounded-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <input type="file" class="hidden" accept="image/*" @change="handlePhotoChange($event, index)" :name="'foto_files['+index+']'">
                                            </label>
                                        </div>
                                        <input type="hidden" :name="'struktur_organisasi['+index+'][foto]'" :value="item.foto || ''">
                                    </div>
                                    
                                    {{-- Info Fields --}}
                                    <div class="flex-1 grid sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="form-label text-xs">Jabatan <span class="text-red-500">*</span></label>
                                            <select x-model="item.jabatan" :name="'struktur_organisasi['+index+'][jabatan]'" class="form-input text-sm">
                                                <option value="">-- Pilih Jabatan --</option>
                                                <optgroup label="Pimpinan Nagari">
                                                    <option value="Bamus">Bamus</option>
                                                    <option value="Penasehat">Penasehat</option>
                                                    <option value="Ketua KAN">Ketua KAN</option>
                                                </optgroup>
                                                <optgroup label="Pengawas">
                                                    <option value="Pengawas">Pengawas</option>
                                                </optgroup>
                                                <optgroup label="Pengurus Inti">
                                                    <option value="Direktur">Direktur</option>
                                                    <option value="Sekretaris">Sekretaris</option>
                                                    <option value="Bendahara">Bendahara</option>
                                                </optgroup>
                                                <optgroup label="Operasional">
                                                    <option value="Kepala Unit Kebun">Kepala Unit Kebun</option>
                                                    <option value="Kepala Unit Jasa">Kepala Unit Jasa</option>
                                                    <option value="Mandor Panen">Mandor Panen</option>
                                                    <option value="Mandor Rawat">Mandor Rawat</option>
                                                    <option value="Staf">Staf</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label text-xs">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="item.nama" :name="'struktur_organisasi['+index+'][nama]'" class="form-input text-sm" placeholder="Nama lengkap">
                                        </div>
                                    </div>
                                    
                                    {{-- Delete Button --}}
                                    <button type="button" @click="removeItem(index)" 
                                            class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg flex-shrink-0 transition-colors"
                                            :disabled="items.length <= 1"
                                            :class="items.length <= 1 ? 'opacity-30 cursor-not-allowed' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        
                        <button type="button" @click="addItem()" 
                                class="w-full py-3 border-2 border-dashed border-gray-300 hover:border-primary rounded-xl text-gray-500 hover:text-primary font-medium transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Anggota Struktur
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Right Column - Logo & Submit --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Logo Upload --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden sticky top-6">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Logo</h3>
                                <p class="text-xs text-gray-500">Logo resmi organisasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        {{-- Current Logo Preview --}}
                        <div class="mb-4">
                            <div class="w-full aspect-square bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden" x-data="{ previewUrl: '{{ $profil && $profil->logo ? $logoUrl : '' }}' }">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" alt="Logo" class="w-full h-full object-contain p-4">
                                </template>
                                <template x-if="!previewUrl">
                                    <div class="text-center p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-400">Belum ada logo</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                        
                        {{-- Upload Input --}}
                        <div x-data="logoUpload()">
                            <label class="block">
                                <span class="sr-only">Pilih logo</span>
                                <input type="file" id="logo" name="logo" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                                       @change="handleLogoChange($event)">
                            </label>
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maksimal 5MB.</p>
                        </div>
                    </div>
                    
                    {{-- Submit Button --}}
                    <div class="p-5 bg-gray-50 border-t border-gray-100">
                        <button type="submit" class="w-full btn-primary justify-center py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Profil
                        </button>
                    </div>
                </div>
                
                {{-- Help Card --}}
                <div class="bg-gradient-to-br from-cream to-primary/5 rounded-xl border border-primary/20 p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm mb-1">Tips</h4>
                            <ul class="text-xs text-gray-600 space-y-1">
                                <li>• Gunakan logo dengan resolusi tinggi</li>
                                <li>• Pastikan data kontak selalu update</li>
                                <li>• Tulis visi misi dengan jelas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function profilForm() {
    return {
        items: @json($profil->struktur_organisasi ?? [['jabatan' => '', 'nama' => '', 'foto' => '']]),
        addItem() {
            this.items.push({ jabatan: '', nama: '', foto: '', foto_preview: null });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        handlePhotoChange(event, index) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.items[index].foto_preview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
}

function logoUpload() {
    return {
        handleLogoChange(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.querySelector('[x-data] img[alt="Logo"]');
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Update the preview container
                        const container = event.target.closest('[x-data]').parentElement.querySelector('.aspect-square');
                        if (container) {
                            container.innerHTML = `<img src="${e.target.result}" alt="Logo" class="w-full h-full object-contain p-4">`;
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
@endpush
