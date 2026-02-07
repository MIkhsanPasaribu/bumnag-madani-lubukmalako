@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Keuangan</h1>
            <p class="text-gray-600 mt-1">Rekap pendapatan & pengeluaran per unit usaha</p>
        </div>
        <div class="flex flex-wrap gap-2">
            {{-- Export Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.outside="open = false"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition 
                     class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    {{-- PDF Section --}}
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">PDF</p>
                    </div>
                    @if($bulanFilter)
                    <a href="{{ route('admin.laporan-keuangan.export-pdf', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Bulan Ini</p>
                            <p class="text-xs text-gray-500">{{ \App\Models\LaporanKeuangan::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}</p>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('admin.laporan-keuangan.export-pdf', ['tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Tahun {{ $tahunFilter }}</p>
                            <p class="text-xs text-gray-500">Semua bulan (gabungan)</p>
                        </div>
                    </a>
                    {{-- Per Unit PDF --}}
                    @foreach($unitList as $u)
                    <a href="{{ route('admin.laporan-keuangan.export-pdf', ['tahun' => $tahunFilter, 'bulan' => $bulanFilter, 'unit' => $u->id]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">{{ $u->nama }}</p>
                            <p class="text-xs text-gray-500">Laporan khusus {{ $u->nama }}</p>
                        </div>
                    </a>
                    @endforeach

                    {{-- Excel Section --}}
                    <div class="px-3 py-2 border-t border-b border-gray-100 mt-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Excel</p>
                    </div>
                    @if($bulanFilter)
                    <a href="{{ route('admin.laporan-keuangan.export-excel', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Bulan Ini</p>
                            <p class="text-xs text-gray-500">{{ \App\Models\LaporanKeuangan::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}</p>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('admin.laporan-keuangan.export-excel', ['tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Tahun {{ $tahunFilter }}</p>
                            <p class="text-xs text-gray-500">Semua bulan (gabungan)</p>
                        </div>
                    </a>
                    @foreach($unitList as $u)
                    <a href="{{ route('admin.laporan-keuangan.export-excel', ['tahun' => $tahunFilter, 'bulan' => $bulanFilter, 'unit' => $u->id]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <span class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">{{ $u->nama }} (Excel)</p>
                            <p class="text-xs text-gray-500">Laporan khusus {{ $u->nama }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Tambah Button --}}
            <a href="{{ route('admin.laporan-keuangan.create') }}" 
               class="btn-primary inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Laporan
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{-- Alert Success --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filter --}}
    <div class="bento-card mb-6">
        <form method="GET" action="{{ route('admin.laporan-keuangan.index') }}" class="flex flex-wrap gap-4 items-end">
            {{-- Filter Tahun --}}
            <div class="flex-1 min-w-[120px]">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-input w-full" onchange="this.form.submit()">
                    @foreach($tahunTersedia as $thn)
                        <option value="{{ $thn }}" {{ $tahunFilter == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Bulan --}}
            <div class="flex-1 min-w-[150px]">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-input w-full">
                    <option value="">Semua Bulan</option>
                    @foreach(\App\Models\LaporanKeuangan::$namaBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulanFilter == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Unit --}}
            <div class="flex-1 min-w-[150px]">
                <label class="form-label">Unit Usaha</label>
                <select name="unit" class="form-input w-full">
                    <option value="">Semua Unit</option>
                    @foreach($unitList as $u)
                        <option value="{{ $u->id }}" {{ $unitFilter == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Filter</button>
                <a href="{{ route('admin.laporan-keuangan.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg">Reset</a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total Pendapatan --}}
        <div class="bento-card bg-gradient-to-br from-green-50 to-green-100/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Pendapatan</p>
                    <p class="text-lg font-bold text-green-700">Rp {{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Total Pengeluaran --}}
        <div class="bento-card bg-gradient-to-br from-red-50 to-red-100/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Pengeluaran</p>
                    <p class="text-lg font-bold text-red-700">Rp {{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Laba/Rugi --}}
        <div class="bento-card bg-gradient-to-br {{ $rekap['total_laba_rugi'] >= 0 ? 'from-blue-50 to-blue-100/50' : 'from-orange-50 to-orange-100/50' }}">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $rekap['total_laba_rugi'] >= 0 ? 'bg-blue-500' : 'bg-orange-500' }} rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Laba / Rugi</p>
                    <p class="text-lg font-bold {{ $rekap['total_laba_rugi'] >= 0 ? 'text-blue-700' : 'text-orange-700' }}">
                        {{ $rekap['total_laba_rugi'] >= 0 ? '' : '-' }}Rp {{ number_format(abs($rekap['total_laba_rugi']), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Jumlah Laporan --}}
        <div class="bento-card bg-gradient-to-br from-purple-50 to-purple-100/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Jumlah Laporan</p>
                    <p class="text-lg font-bold text-purple-700">{{ $rekap['jumlah_laporan'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="bento-card overflow-hidden">
        @if($laporan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Periode</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Unit Usaha</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Sub Unit</th>
                            <th class="text-right px-4 py-3 font-semibold text-gray-600">Pendapatan</th>
                            <th class="text-right px-4 py-3 font-semibold text-gray-600">Pengeluaran</th>
                            <th class="text-right px-4 py-3 font-semibold text-gray-600">Laba/Rugi</th>
                            <th class="text-center px-4 py-3 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($laporan as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900">{{ $item->periode }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $item->unit?->kode === 'jasa' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $item->unit?->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->subUnit?->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-green-600">
                                    Rp {{ number_format($item->pendapatan, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-red-600">
                                    Rp {{ number_format($item->pengeluaran, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right font-bold {{ $item->laba_rugi >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                                    {{ $item->laba_rugi >= 0 ? '' : '-' }}Rp {{ number_format(abs($item->laba_rugi), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.laporan-keuangan.edit', $item) }}" 
                                           class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.laporan-keuangan.destroy', $item) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus laporan {{ $item->periode }} - {{ $item->nama_unit_lengkap }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- Footer Totals --}}
                    <tfoot>
                        <tr class="bg-gray-50 border-t-2 border-gray-300 font-bold">
                            <td colspan="3" class="px-4 py-3 text-gray-700">TOTAL</td>
                            <td class="px-4 py-3 text-right text-green-700">Rp {{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-red-700">Rp {{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right {{ $rekap['total_laba_rugi'] >= 0 ? 'text-blue-700' : 'text-orange-700' }}">
                                {{ $rekap['total_laba_rugi'] >= 0 ? '' : '-' }}Rp {{ number_format(abs($rekap['total_laba_rugi']), 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Pagination --}}
            @if($laporan->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $laporan->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Laporan</h3>
                <p class="text-gray-500 mb-4">Tambahkan laporan keuangan pertama untuk periode ini.</p>
                <a href="{{ route('admin.laporan-keuangan.create') }}" class="btn-primary inline-flex items-center px-4 py-2 text-sm rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Laporan
                </a>
            </div>
        @endif
    </div>
@endsection
