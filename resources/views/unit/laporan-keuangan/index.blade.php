@extends('layouts.unit')

@section('title', 'Laporan Keuangan')
@section('page_title', 'Laporan Keuangan ' . $unit->nama)

@section('content')
<div class="space-y-6">
    {{-- Filter & Actions --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <form action="{{ route('unit.laporan-keuangan.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                <select name="tahun" class="form-input text-sm rounded-lg border-gray-300">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                    @if(!$tahunList->contains(now()->year))
                        <option value="{{ now()->year }}" {{ $tahun == now()->year ? 'selected' : '' }}>{{ now()->year }}</option>
                    @endif
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
                <select name="bulan" class="form-input text-sm rounded-lg border-gray-300">
                    <option value="">Semua</option>
                    @foreach(\App\Models\LaporanKeuangan::$namaBulan as $key => $nama)
                        <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            @if($subUnits->count() > 0)
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Sub Unit</label>
                    <select name="sub_unit_id" class="form-input text-sm rounded-lg border-gray-300">
                        <option value="">Semua</option>
                        @foreach($subUnits as $sub)
                            <option value="{{ $sub->id }}" {{ $subUnitId == $sub->id ? 'selected' : '' }}>{{ $sub->nama }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="btn-primary text-sm px-4 py-2">Filter</button>
            <a href="{{ route('unit.laporan-keuangan.create') }}" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Laporan
            </a>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
            <p class="text-lg font-bold text-green-600">Rp {{ number_format($rekap['pendapatan'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Total Pengeluaran</p>
            <p class="text-lg font-bold text-red-600">Rp {{ number_format($rekap['pengeluaran'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Laba/Rugi</p>
            <p class="text-lg font-bold {{ $rekap['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                {{ $rekap['laba_rugi'] >= 0 ? '+' : '' }}Rp {{ number_format($rekap['laba_rugi'], 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Periode</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sub Unit</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Pendapatan</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Pengeluaran</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Laba/Rugi</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Keterangan</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporan as $index => $lap)
                        @php
                            $isFromHigherRole = \App\Policies\LaporanKeuanganPolicy::isInputByHigherRole(auth()->user(), $lap);
                            $inputByMessage = $isFromHigherRole ? \App\Policies\LaporanKeuanganPolicy::getInputByMessage($lap) : null;
                        @endphp
                        <tr class="hover:bg-gray-50 {{ $isFromHigherRole ? 'bg-blue-50/40' : '' }}">
                            <td class="px-4 py-3 text-gray-500">{{ $laporan->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ $lap->periode }}
                                @if($isFromHigherRole)
                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700" title="{{ $inputByMessage }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Diinput Admin
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $lap->subUnit?->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-right text-green-600">{{ number_format($lap->pendapatan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-red-600">{{ number_format($lap->pengeluaran, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-semibold {{ $lap->laba_rugi >= 0 ? 'text-primary' : 'text-red-600' }}">
                                {{ $lap->laba_rugi >= 0 ? '+' : '' }}{{ number_format($lap->laba_rugi, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $lap->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($isFromHigherRole)
                                    <span class="text-xs text-blue-600" title="{{ $inputByMessage }}">Diinput oleh Admin</span>
                                @elseif($lap->sub_unit_id === null)
                                    {{-- Hanya laporan langsung unit yg bisa di-edit --}}
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('unit.laporan-keuangan.edit', $lap) }}" class="p-1.5 rounded-lg hover:bg-yellow-50 text-yellow-600" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('unit.laporan-keuangan.destroy', $lap) }}" method="POST"
                                              onsubmit="return confirm('Hapus laporan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-red-600" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Dari sub unit</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporan->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">{{ $laporan->links() }}</div>
        @endif
    </div>
</div>
@endsection
