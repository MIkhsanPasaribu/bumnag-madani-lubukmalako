@extends('layouts.admin')

@section('title', 'Tambah Laporan Keuangan')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.laporan-keuangan.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Laporan Keuangan</h1>
            <p class="text-gray-600 mt-1">Catat pendapatan & pengeluaran unit usaha</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bento-card">
            <form action="{{ route('admin.laporan-keuangan.store') }}" method="POST" x-data="formLaporan()">
                @csrf

                <div class="space-y-6">
                    {{-- Periode: Bulan & Tahun --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bulan" class="form-label">
                                Bulan <span class="text-red-500">*</span>
                            </label>
                            <select name="bulan" id="bulan" class="form-input w-full @error('bulan') border-red-500 @enderror" required>
                                <option value="">Pilih Bulan</option>
                                @foreach(\App\Models\LaporanKeuangan::$namaBulan as $num => $nama)
                                    <option value="{{ $num }}" {{ old('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tahun" class="form-label">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun" id="tahun" 
                                   value="{{ old('tahun', date('Y')) }}"
                                   min="2020" max="2099"
                                   class="form-input w-full @error('tahun') border-red-500 @enderror" required>
                            @error('tahun')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">Bisa diisi tahun lampau untuk pencatatan mundur</p>
                        </div>
                    </div>

                    {{-- Unit Usaha --}}
                    <div>
                        <label for="unit_id" class="form-label">
                            Unit Usaha <span class="text-red-500">*</span>
                        </label>
                        <select name="unit_id" id="unit_id" 
                                x-model="unitId" @change="onUnitChange()"
                                class="form-input w-full @error('unit_id') border-red-500 @enderror" required>
                            <option value="">Pilih Unit Usaha</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" 
                                        data-has-sub="{{ $unit->subUnits->count() > 0 ? '1' : '0' }}"
                                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sub Unit (dynamic, shown only for Unit Jasa) --}}
                    <div x-show="showSubUnit" x-transition>
                        <label for="sub_unit_id" class="form-label">
                            Sub Unit <span class="text-red-500">*</span>
                        </label>
                        <select name="sub_unit_id" id="sub_unit_id" 
                                x-model="subUnitId"
                                class="form-input w-full @error('sub_unit_id') border-red-500 @enderror">
                            <option value="">Pilih Sub Unit</option>
                            @foreach($units as $unit)
                                @foreach($unit->subUnits as $subUnit)
                                    <option value="{{ $subUnit->id }}" 
                                            data-unit="{{ $unit->id }}"
                                            x-show="unitId == '{{ $unit->id }}'"
                                            {{ old('sub_unit_id') == $subUnit->id ? 'selected' : '' }}>
                                        {{ $subUnit->nama }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('sub_unit_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pendapatan --}}
                    <div>
                        <label for="pendapatan" class="form-label">
                            Pendapatan (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                            <input type="number" name="pendapatan" id="pendapatan" 
                                   value="{{ old('pendapatan', 0) }}"
                                   min="0" step="1"
                                   class="form-input w-full pl-10 @error('pendapatan') border-red-500 @enderror" required>
                        </div>
                        @error('pendapatan')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pengeluaran --}}
                    <div>
                        <label for="pengeluaran" class="form-label">
                            Pengeluaran (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                            <input type="number" name="pengeluaran" id="pengeluaran" 
                                   value="{{ old('pengeluaran', 0) }}"
                                   min="0" step="1"
                                   class="form-input w-full pl-10 @error('pengeluaran') border-red-500 @enderror" required>
                        </div>
                        @error('pengeluaran')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview Laba/Rugi --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200" x-data="{ get labaRugi() { return (parseFloat(document.getElementById('pendapatan')?.value || 0) - parseFloat(document.getElementById('pengeluaran')?.value || 0)); } }">
                        <p class="text-sm text-gray-500 mb-1">Estimasi Laba/Rugi:</p>
                        <p class="text-lg font-bold" 
                           :class="(parseFloat($refs.pendapatanInput?.value || 0) - parseFloat($refs.pengeluaranInput?.value || 0)) >= 0 ? 'text-green-600' : 'text-red-600'"
                           x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(parseFloat(document.getElementById('pendapatan')?.value || 0) - parseFloat(document.getElementById('pengeluaran')?.value || 0)))">
                        </p>
                    </div>

                    {{-- Keterangan --}}
                    <div x-data="{ count: {{ mb_strlen(old('keterangan', '')) }} }">
                        <label for="keterangan" class="form-label">
                            Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                                  class="form-input w-full @error('keterangan') border-red-500 @enderror"
                                  placeholder="Catatan tambahan untuk laporan ini..."
                                  maxlength="2000"
                                  x-on:input="count = $el.value.length">{{ old('keterangan') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('keterangan')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 1800 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/2000'">0/2000</p>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn-primary px-6 py-2.5 rounded-lg font-medium">
                            Simpan Laporan
                        </button>
                        <a href="{{ route('admin.laporan-keuangan.index') }}" 
                           class="px-6 py-2.5 text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function formLaporan() {
    return {
        unitId: '{{ old('unit_id', '') }}',
        subUnitId: '{{ old('sub_unit_id', '') }}',
        showSubUnit: false,

        init() {
            this.checkSubUnit();
        },

        onUnitChange() {
            this.subUnitId = '';
            this.checkSubUnit();
        },

        checkSubUnit() {
            if (!this.unitId) {
                this.showSubUnit = false;
                return;
            }
            const option = document.querySelector(`#unit_id option[value="${this.unitId}"]`);
            this.showSubUnit = option?.dataset.hasSub === '1';
        }
    }
}
</script>
@endpush
