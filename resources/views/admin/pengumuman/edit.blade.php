@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Edit</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-bumnag-gray">Edit Pengumuman</h1>
        <p class="text-gray-500">Perbarui informasi pengumuman</p>
    </div>
    
    <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="card-admin space-y-5">
            <div>
                <label for="judul" class="form-label">Judul <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="form-input" required>
                @error('judul')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="isi" class="form-label">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea id="isi" name="isi" rows="6" class="form-textarea" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                @error('isi')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="prioritas" class="form-label">Prioritas <span class="text-red-500">*</span></label>
                    <select id="prioritas" name="prioritas" class="form-select" required>
                        <option value="rendah" {{ old('prioritas', $pengumuman->prioritas) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ old('prioritas', $pengumuman->prioritas) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ old('prioritas', $pengumuman->prioritas) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>
                
                <div>
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai->format('Y-m-d')) }}" class="form-input" required>
                </div>
                
                <div>
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai?->format('Y-m-d')) }}" class="form-input">
                </div>
            </div>
            
            <div>
                <label for="lampiran" class="form-label">Lampiran</label>
                @if($pengumuman->lampiran)
                <div class="mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                    <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="text-sm text-bumnag-olive hover:underline">Lihat lampiran saat ini</a>
                </div>
                @endif
                <input type="file" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx" class="form-input">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah lampiran.</p>
                @error('lampiran')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pengumuman->is_active) ? 'checked' : '' }} class="w-5 h-5 text-bumnag-olive border-gray-300 rounded focus:ring-bumnag-olive">
                    <span class="text-sm text-gray-700">Aktifkan pengumuman</span>
                </label>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
