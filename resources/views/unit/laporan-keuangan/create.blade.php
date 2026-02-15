@extends('layouts.unit')

@section('title', 'Input Laporan Keuangan')
@section('page_title', 'Input Laporan Keuangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-900">Input Laporan Keuangan</h2>
            <p class="text-sm text-gray-500">{{ $unit->nama }} — Input langsung (tanpa sub unit)</p>
        </div>

        @if($adminInputInfo)
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-blue-800">{{ $adminInputInfo }}</p>
            </div>
        @endif

        <form action="{{ route('unit.laporan-keuangan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan <span class="text-red-500">*</span></label>
                    <select name="bulan" id="bulan" class="form-input w-full rounded-lg border-gray-300" required>
                        <option value="">Pilih Bulan</option>
                        @foreach(\App\Models\LaporanKeuangan::$namaBulan as $key => $nama)
                            <option value="{{ $key }}" {{ old('bulan') == $key ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    @error('bulan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun', now()->year) }}"
                           min="2020" max="2099" class="form-input w-full rounded-lg border-gray-300" required>
                    @error('tahun') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="pendapatan" class="block text-sm font-medium text-gray-700 mb-1">Pendapatan (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="pendapatan" id="pendapatan" value="{{ old('pendapatan', 0) }}"
                       min="0" step="1" class="form-input w-full rounded-lg border-gray-300" required>
                @error('pendapatan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="pengeluaran" class="block text-sm font-medium text-gray-700 mb-1">Pengeluaran (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="pengeluaran" id="pengeluaran" value="{{ old('pengeluaran', 0) }}"
                       min="0" step="1" class="form-input w-full rounded-lg border-gray-300" required>
                @error('pengeluaran') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="form-input w-full rounded-lg border-gray-300" placeholder="Catatan opsional...">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary px-6 py-2.5">Simpan</button>
                <a href="{{ route('unit.laporan-keuangan.index') }}" class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-800">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
