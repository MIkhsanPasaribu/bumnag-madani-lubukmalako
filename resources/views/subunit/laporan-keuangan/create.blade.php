@extends('layouts.subunit')

@section('title', 'Input Laporan Keuangan')
@section('page_title', 'Input Laporan Keuangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Tambah Laporan — {{ $subUnit->nama }}</h3>
            <p class="text-sm text-gray-500">{{ $unit->nama }}</p>
        </div>

        @if($adminInputInfo)
            <div class="mx-6 mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-blue-800">{{ $adminInputInfo }}</p>
            </div>
        @endif

        <form action="{{ route('subunit.laporan-keuangan.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan <span class="text-red-500">*</span></label>
                    <select name="bulan" class="form-input w-full rounded-lg border-gray-300 @error('bulan') border-red-500 @enderror" required>
                        <option value="">Pilih Bulan</option>
                        @foreach(\App\Models\LaporanKeuangan::$namaBulan as $num => $nama)
                            <option value="{{ $num }}" {{ old('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    @error('bulan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                    <select name="tahun" class="form-input w-full rounded-lg border-gray-300 @error('tahun') border-red-500 @enderror" required>
                        @for($y = date('Y') + 1; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ old('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    @error('tahun') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pendapatan (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="pendapatan" value="{{ old('pendapatan', 0) }}" min="0" step="1"
                       class="form-input w-full rounded-lg border-gray-300 @error('pendapatan') border-red-500 @enderror" required>
                @error('pendapatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengeluaran (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="pengeluaran" value="{{ old('pengeluaran', 0) }}" min="0" step="1"
                       class="form-input w-full rounded-lg border-gray-300 @error('pengeluaran') border-red-500 @enderror" required>
                @error('pengeluaran') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="form-input w-full rounded-lg border-gray-300 @error('keterangan') border-red-500 @enderror" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg text-sm font-medium transition">Simpan</button>
                <a href="{{ route('subunit.laporan-keuangan.index') }}" class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-2 rounded-lg text-sm transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
