@extends('layouts.admin')

@section('title', 'Edit Transaksi Kas')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.transaksi-kas.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Transaksi Kas</h1>
            <p class="text-gray-600 mt-1">Perbarui data transaksi kas</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bento-card">
            <form action="{{ route('admin.transaksi-kas.update', $transaksi) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    {{-- Info --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">No. Urut:</span>
                                <span class="font-medium ml-1">{{ $transaksi->no_urut }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Dibuat oleh:</span>
                                <span class="font-medium ml-1">{{ $transaksi->createdBy->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Tanggal & No Kwitansi --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}"
                                   class="form-input w-full @error('tanggal') border-red-500 @enderror" required>
                            @error('tanggal')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="no_kwitansi" class="block text-sm font-medium text-gray-700 mb-1">
                                No. Kwitansi / Bukti (Opsional)
                            </label>
                            <input type="text" name="no_kwitansi" id="no_kwitansi" 
                                   value="{{ old('no_kwitansi', $transaksi->no_kwitansi) }}"
                                   placeholder="Contoh: KW-001"
                                   class="form-input w-full @error('no_kwitansi') border-red-500 @enderror">
                            @error('no_kwitansi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Jenis Transaksi --}}
                    @php
                        $jenisLama = $transaksi->uang_masuk > 0 ? 'masuk' : 'keluar';
                    @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Transaksi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('jenis_transaksi', $jenisLama) === 'masuk' ? 'border-green-500 bg-green-50' : '' }}">
                                <input type="radio" name="jenis_transaksi" value="masuk" 
                                       class="sr-only" {{ old('jenis_transaksi', $jenisLama) === 'masuk' ? 'checked' : '' }} required>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Uang Masuk</p>
                                        <p class="text-sm text-gray-500">Pemasukan</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('jenis_transaksi', $jenisLama) === 'keluar' ? 'border-red-500 bg-red-50' : '' }}">
                                <input type="radio" name="jenis_transaksi" value="keluar" 
                                       class="sr-only" {{ old('jenis_transaksi', $jenisLama) === 'keluar' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Uang Keluar</p>
                                        <p class="text-sm text-gray-500">Pengeluaran</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('jenis_transaksi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Jumlah --}}
                    @php
                        $jumlahLama = $transaksi->uang_masuk > 0 ? $transaksi->uang_masuk : $transaksi->uang_keluar;
                    @endphp
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" name="jumlah" id="jumlah" 
                                   value="{{ old('jumlah', $jumlahLama) }}"
                                   placeholder="0"
                                   min="1" step="1"
                                   class="form-input w-full pl-10 @error('jumlah') border-red-500 @enderror" required>
                        </div>
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Uraian --}}
                    <div>
                        <label for="uraian" class="block text-sm font-medium text-gray-700 mb-1">
                            Uraian <span class="text-red-500">*</span>
                        </label>
                        <textarea name="uraian" id="uraian" rows="3" 
                                  placeholder="Deskripsi transaksi..."
                                  class="form-input w-full @error('uraian') border-red-500 @enderror" required>{{ old('uraian', $transaksi->uraian) }}</textarea>
                        @error('uraian')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Keterangan --}}
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                            Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="2" 
                                  placeholder="Catatan tambahan..."
                                  class="form-input w-full @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3 mt-8 pt-6 border-t">
                    <form action="{{ route('admin.transaksi-kas.destroy', $transaksi) }}" method="POST" class="inline"
                          onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                            Hapus Transaksi
                        </button>
                    </form>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('admin.transaksi-kas.index') }}" class="btn-outline">Batal</a>
                        <button type="submit" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Radio button styling
    document.querySelectorAll('input[name="jenis_transaksi"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="jenis_transaksi"]').forEach(r => {
                r.closest('label').classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
            });
            if (this.value === 'masuk') {
                this.closest('label').classList.add('border-green-500', 'bg-green-50');
            } else {
                this.closest('label').classList.add('border-red-500', 'bg-red-50');
            }
        });
    });
</script>
@endpush
