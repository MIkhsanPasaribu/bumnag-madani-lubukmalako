@extends('layouts.admin')

@section('title', 'Tambah Laporan Keuangan')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('admin.keuangan.index') }}">Laporan Keuangan</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Tambah</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-bumnag-gray">Tambah Laporan Keuangan</h1>
        <p class="text-gray-500">Input data keuangan bulanan</p>
    </div>
    
    <form action="{{ route('admin.keuangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="card-admin space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="bulan" class="form-label">Bulan <span class="text-red-500">*</span></label>
                    <select id="bulan" name="bulan" class="form-select" required>
                        @php
                        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('bulan', date('n')) == $i ? 'selected' : '' }}>{{ $namaBulan[$i] }}</option>
                        @endfor
                    </select>
                    @error('bulan')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="tahun" class="form-label">Tahun <span class="text-red-500">*</span></label>
                    <select id="tahun" name="tahun" class="form-select" required>
                        @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ old('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="pendapatan" class="form-label">Pendapatan (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="pendapatan" name="pendapatan" value="{{ old('pendapatan', 0) }}" class="form-input" min="0" step="1" required>
                    @error('pendapatan')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="pengeluaran" class="form-label">Pengeluaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="pengeluaran" name="pengeluaran" value="{{ old('pengeluaran', 0) }}" class="form-input" min="0" step="1" required>
                    @error('pengeluaran')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" class="form-textarea">{{ old('keterangan') }}</textarea>
            </div>
            
            <div>
                <label for="dokumen" class="form-label">Dokumen Laporan (PDF)</label>
                <input type="file" id="dokumen" name="dokumen" accept=".pdf" class="form-input">
                <p class="text-xs text-gray-500 mt-1">Format: PDF. Maksimal 10MB.</p>
                @error('dokumen')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="w-5 h-5 text-bumnag-olive border-gray-300 rounded focus:ring-bumnag-olive">
                    <span class="text-sm text-gray-700">Publikasikan (tampilkan di halaman transparansi)</span>
                </label>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Laporan
            </button>
            <a href="{{ route('admin.keuangan.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
