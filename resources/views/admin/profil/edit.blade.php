@extends('layouts.admin')

@section('title', 'Edit Profil BUMNag')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('admin.profil.index') }}">Profil BUMNag</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Edit</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-bumnag-gray">Edit Profil BUMNag</h1>
        <p class="text-gray-500">Perbarui informasi profil organisasi</p>
    </div>
    
    <form action="{{ route('admin.profil.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="card-admin space-y-5">
            <h3 class="font-semibold text-lg text-bumnag-gray border-b pb-3">Informasi Umum</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="nama" class="form-label">Nama Organisasi <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $profil->nama ?? '') }}" class="form-input" required>
                    @error('nama')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                    <input type="number" id="tahun_berdiri" name="tahun_berdiri" value="{{ old('tahun_berdiri', $profil->tahun_berdiri ?? '') }}" class="form-input" min="1900" max="{{ date('Y') }}">
                </div>
            </div>
            
            <div>
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="form-textarea">{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
            </div>
        </div>
        
        <div class="card-admin space-y-5">
            <h3 class="font-semibold text-lg text-bumnag-gray border-b pb-3">Kontak</h3>
            
            <div>
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" rows="2" class="form-textarea">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $profil->telepon ?? '') }}" class="form-input">
                </div>
                
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $profil->email ?? '') }}" class="form-input">
                    @error('email')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="website" class="form-label">Website</label>
                <input type="url" id="website" name="website" value="{{ old('website', $profil->website ?? '') }}" class="form-input" placeholder="https://...">
                @error('website')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="card-admin space-y-5">
            <h3 class="font-semibold text-lg text-bumnag-gray border-b pb-3">Visi & Misi</h3>
            
            <div>
                <label for="visi" class="form-label">Visi</label>
                <textarea id="visi" name="visi" rows="3" class="form-textarea">{{ old('visi', $profil->visi ?? '') }}</textarea>
            </div>
            
            <div>
                <label for="misi" class="form-label">Misi</label>
                <textarea id="misi" name="misi" rows="5" class="form-textarea" placeholder="1. Misi pertama&#10;2. Misi kedua&#10;3. Misi ketiga">{{ old('misi', $profil->misi ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Tulis setiap misi di baris baru</p>
            </div>
        </div>
        
        <div class="card-admin space-y-5">
            <h3 class="font-semibold text-lg text-bumnag-gray border-b pb-3">Sejarah</h3>
            
            <div>
                <label for="sejarah" class="form-label">Sejarah Organisasi</label>
                <textarea id="sejarah" name="sejarah" rows="8" class="form-textarea">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.profil.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
