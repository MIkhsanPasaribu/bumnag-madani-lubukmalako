@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('admin.berita.index') }}">Berita</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Edit</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-bumnag-gray">Edit Berita</h1>
        <p class="text-gray-500">Perbarui informasi berita</p>
    </div>
    
    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="card-admin space-y-5">
            <div>
                <label for="judul" class="form-label">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" class="form-input" required>
                @error('judul')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="kategori" class="form-label">Kategori</label>
                    <select id="kategori" name="kategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <option value="Kegiatan" {{ old('kategori', $berita->kategori) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Prestasi" {{ old('kategori', $berita->kategori) == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="Usaha" {{ old('kategori', $berita->kategori) == 'Usaha' ? 'selected' : '' }}>Usaha</option>
                        <option value="Pengumuman" {{ old('kategori', $berita->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="Lainnya" {{ old('kategori', $berita->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                
                <div>
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}" class="form-input">
                </div>
            </div>
            
            <div>
                <label for="ringkasan" class="form-label">Ringkasan</label>
                <textarea id="ringkasan" name="ringkasan" rows="2" class="form-textarea">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
            </div>
            
            <div>
                <label for="konten" class="form-label">Konten <span class="text-red-500">*</span></label>
                <textarea id="konten" name="konten" rows="10" class="form-textarea" required>{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="gambar" class="form-label">Gambar</label>
                @if($berita->gambar)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="" class="w-32 h-32 object-cover rounded-lg">
                    <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                </div>
                @endif
                <input type="file" id="gambar" name="gambar" accept="image/*" class="form-input">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('gambar')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                    <input type="date" id="published_at" name="published_at" value="{{ old('published_at', $berita->published_at?->format('Y-m-d')) }}" class="form-input">
                </div>
                
                <div class="flex items-center pt-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }} class="w-5 h-5 text-bumnag-olive border-gray-300 rounded focus:ring-bumnag-olive">
                        <span class="text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
