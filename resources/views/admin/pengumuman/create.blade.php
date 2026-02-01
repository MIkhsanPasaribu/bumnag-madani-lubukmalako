@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page_title', 'Tambah Pengumuman')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.pengumuman.index') }}" class="hover:text-primary transition-colors">Pengumuman</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900">Tambah</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pengumuman Baru</h1>
        </div>
        <a href="{{ route('admin.pengumuman.index') }}" class="btn-ghost w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            {{-- Informasi Dasar --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Informasi Pengumuman
                </h2>
                
                <div class="space-y-5">
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="form-label">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               class="form-input @error('judul') border-red-500 ring-red-500 @enderror" 
                               placeholder="Masukkan judul pengumuman"
                               required>
                        @error('judul')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Konten --}}
                    <div>
                        <label for="konten" class="form-label">
                            Isi Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea id="konten" 
                                  name="konten" 
                                  rows="8" 
                                  class="form-input @error('konten') border-red-500 ring-red-500 @enderror"
                                  placeholder="Tulis isi pengumuman di sini..."
                                  required>{{ old('konten') }}</textarea>
                        @error('konten')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- Lampiran --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Lampiran (Opsional)
                </h2>
                
                <div>
                    <label for="lampiran" class="form-label">Upload Dokumen</label>
                    <div class="mt-1">
                        <input type="file" 
                               id="lampiran" 
                               name="lampiran" 
                               accept=".pdf,.doc,.docx" 
                               class="block w-full text-sm text-gray-500 
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-medium
                                      file:bg-primary/10 file:text-primary
                                      hover:file:bg-primary/20 
                                      file:transition-colors file:cursor-pointer
                                      @error('lampiran') file:bg-red-100 file:text-red-600 @enderror">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Format: PDF, DOC, DOCX. Maksimal 5MB.
                    </p>
                    @error('lampiran')
                        <p class="form-error mt-1">{{ $message }}</p>
                    @enderror
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
                    {{-- Prioritas --}}
                    <div>
                        <label for="prioritas" class="form-label">
                            Prioritas <span class="text-red-500">*</span>
                        </label>
                        <select id="prioritas" name="prioritas" class="form-input @error('prioritas') border-red-500 @enderror" required>
                            <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>🟢 Rendah</option>
                            <option value="sedang" {{ old('prioritas', 'sedang') == 'sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                            <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>⚡ Tinggi</option>
                        </select>
                        @error('prioritas')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Status --}}
                    <div>
                        <label for="status" class="form-label">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" class="form-input @error('status') border-red-500 @enderror" required>
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>⏸️ Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- Periode --}}
            <div class="bento-card-flat">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Periode Tayang
                </h2>
                
                <div class="space-y-4">
                    {{-- Tanggal Mulai --}}
                    <div>
                        <label for="tanggal_mulai" class="form-label">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal_mulai" 
                               name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai', date('Y-m-d')) }}" 
                               class="form-input @error('tanggal_mulai') border-red-500 @enderror" 
                               required>
                        @error('tanggal_mulai')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Tanggal Berakhir --}}
                    <div>
                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                        <input type="date" 
                               id="tanggal_berakhir" 
                               name="tanggal_berakhir" 
                               value="{{ old('tanggal_berakhir') }}" 
                               class="form-input @error('tanggal_berakhir') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ada batas waktu
                        </p>
                        @error('tanggal_berakhir')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
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
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('admin.pengumuman.index') }}" class="btn-ghost w-full justify-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
