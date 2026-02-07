@extends('layouts.public')

@section('title', 'Laporan Keuangan - ' . $rekap['periode'])

@section('meta_description', 'Detail laporan keuangan BUMNag Madani Lubuk Malako periode ' . $rekap['periode'] . ' — rincian pendapatan dan pengeluaran per unit usaha.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    {{-- Header with Gradient Background --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-8 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-start gap-4">
                    <a href="{{ route('statistik', ['tahun' => $tahun]) }}"
                       class="flex-shrink-0 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors"
                       title="Kembali ke Statistik">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <p class="text-white/80 text-sm mb-1">Laporan Keuangan</p>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $rekap['periode'] }}</h1>
                        <p class="text-white/70 text-sm mt-2">BUMNag Madani Lubuk Malako</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-2">
                    {{-- Print --}}
                    <button onclick="window.print()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm"
                            title="Cetak Halaman">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span class="hidden sm:inline">Print</span>
                    </button>

                    {{-- Share WhatsApp --}}
                    <a href="https://wa.me/?text=Lihat%20laporan%20keuangan%20BUMNag%20Madani%20Lubuk%20Malako%20periode%20{{ urlencode($rekap['periode']) }}%20%0A{{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm"
                       title="Share via WhatsApp">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.019-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="hidden sm:inline">Share</span>
                    </a>

                    {{-- Download PDF --}}
                    <a href="{{ route('transparansi.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm"
                       title="Download PDF">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">PDF</span>
                    </a>

                    {{-- Download Excel --}}
                    <a href="{{ route('transparansi.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-primary hover:bg-gray-100 rounded-lg text-sm font-semibold transition-colors shadow-lg"
                       title="Download Excel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Pendapatan --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <p class="text-sm text-green-700 font-medium">Total Pendapatan</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-green-600">{{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</p>
        </div>

        {{-- Total Pengeluaran --}}
        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <p class="text-sm text-red-700 font-medium">Total Pengeluaran</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-red-600">{{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</p>
        </div>

        {{-- Laba / Rugi --}}
        <div class="bg-gradient-to-br {{ $rekap['laba_rugi'] >= 0 ? 'from-primary/5 to-primary/10 border-primary/20' : 'from-red-50 to-rose-50 border-red-200' }} rounded-xl border p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 {{ $rekap['laba_rugi'] >= 0 ? 'bg-primary/15' : 'bg-red-100' }} rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $rekap['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-sm {{ $rekap['laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-700' }} font-medium">Laba / Rugi</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold {{ $rekap['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                {{ $rekap['laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($rekap['laba_rugi']), 0, ',', '.') }}
            </p>
        </div>

        {{-- Jumlah Laporan --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-sm text-blue-700 font-medium">Jumlah Laporan</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-blue-600">{{ $rekap['jumlah_laporan'] }}</p>
        </div>
    </div>

    {{-- Currency Note --}}
    <div class="flex justify-center mb-8">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 text-xs font-medium rounded-full border border-amber-200">
            <span class="font-bold">IDR</span>
            <span class="text-amber-400">|</span>
            <span>Semua nilai dalam Rupiah Indonesia</span>
        </span>
    </div>

    {{-- Rincian Per Unit --}}
    @if(count($rekapPerUnit) > 0)
        <div class="space-y-6 mb-8">
            @foreach($rekapPerUnit as $unitIndex => $unit)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    {{-- Unit Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $unit['nama_unit'] }}</h3>
                                @if($unit['kode_unit'])
                                    <p class="text-sm text-gray-500">Kode: {{ $unit['kode_unit'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Laba/Rugi</p>
                                <p class="text-lg font-bold {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                    {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if(count($unit['sub_units']) > 0)
                        {{-- === Unit DENGAN Sub-Unit: Tampilkan Tabel === --}}

                        {{-- Desktop Table --}}
                        <div class="hidden lg:block">
                            <div class="overflow-x-auto scrollbar-thin">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-50/80 border-b border-gray-100">
                                            <th class="px-5 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-14">No</th>
                                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Sub Unit</th>
                                            <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">
                                                <span class="inline-flex items-center gap-1">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                    Pendapatan
                                                </span>
                                            </th>
                                            <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">
                                                <span class="inline-flex items-center gap-1">
                                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                    Pengeluaran
                                                </span>
                                            </th>
                                            <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Laba/Rugi</th>
                                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($unit['sub_units'] as $subIndex => $sub)
                                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                                <td class="px-5 py-3.5 text-center">
                                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-100 group-hover:bg-primary/10 text-gray-600 group-hover:text-primary text-xs font-semibold rounded-lg transition-colors">
                                                        {{ $subIndex + 1 }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3.5">
                                                    <span class="text-sm font-medium text-gray-800">{{ $sub['nama_sub_unit'] }}</span>
                                                </td>
                                                <td class="px-5 py-3.5 text-right">
                                                    @if($sub['pendapatan'] > 0)
                                                        <span class="inline-flex items-center gap-1 text-green-600 font-semibold text-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                            </svg>
                                                            {{ number_format($sub['pendapatan'], 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3.5 text-right">
                                                    @if($sub['pengeluaran'] > 0)
                                                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                            </svg>
                                                            {{ number_format($sub['pengeluaran'], 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3.5 text-right">
                                                    <span class="font-bold text-sm {{ $sub['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                                        {{ $sub['laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($sub['laba_rugi']), 0, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3.5">
                                                    @if($sub['keterangan'])
                                                        <span class="text-sm text-gray-500">{{ Str::limit($sub['keterangan'], 60) }}</span>
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gradient-to-r from-primary/5 to-primary/10 border-t-2 border-primary/20">
                                            <td colspan="2" class="px-5 py-4">
                                                <span class="font-bold text-gray-900">Total {{ $unit['nama_unit'] }}</span>
                                            </td>
                                            <td class="px-5 py-4 text-right">
                                                <span class="font-bold text-green-600">{{ number_format($unit['total_pendapatan'], 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-5 py-4 text-right">
                                                <span class="font-bold text-red-600">{{ number_format($unit['total_pengeluaran'], 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-5 py-4 text-right">
                                                <span class="font-bold text-lg {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                                    {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Mobile Card View --}}
                        <div class="lg:hidden divide-y divide-gray-100">
                            @foreach($unit['sub_units'] as $subIndex => $sub)
                                <div class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 font-bold text-xs">
                                            {{ $subIndex + 1 }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 mb-2">{{ $sub['nama_sub_unit'] }}</p>
                                            <div class="grid grid-cols-3 gap-2 mb-2">
                                                <div class="bg-green-50 rounded-lg px-2.5 py-2 text-center">
                                                    <p class="text-[10px] text-green-600 uppercase font-medium mb-0.5">Pendapatan</p>
                                                    <p class="text-xs font-bold text-green-600">{{ number_format($sub['pendapatan'], 0, ',', '.') }}</p>
                                                </div>
                                                <div class="bg-red-50 rounded-lg px-2.5 py-2 text-center">
                                                    <p class="text-[10px] text-red-600 uppercase font-medium mb-0.5">Pengeluaran</p>
                                                    <p class="text-xs font-bold text-red-600">{{ number_format($sub['pengeluaran'], 0, ',', '.') }}</p>
                                                </div>
                                                <div class="{{ $sub['laba_rugi'] >= 0 ? 'bg-primary/10' : 'bg-red-50' }} rounded-lg px-2.5 py-2 text-center">
                                                    <p class="text-[10px] {{ $sub['laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-600' }} uppercase font-medium mb-0.5">Laba/Rugi</p>
                                                    <p class="text-xs font-bold {{ $sub['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                                        {{ $sub['laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($sub['laba_rugi']), 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if($sub['keterangan'])
                                                <p class="text-xs text-gray-500 italic">{{ Str::limit($sub['keterangan'], 80) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Mobile Unit Total --}}
                            <div class="p-4 bg-gradient-to-r from-primary/5 to-primary/10">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900 text-sm">Total {{ $unit['nama_unit'] }}</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-green-600 mb-0.5">Pendapatan</p>
                                        <p class="text-xs font-bold text-green-600">{{ number_format($unit['total_pendapatan'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] text-red-600 mb-0.5">Pengeluaran</p>
                                        <p class="text-xs font-bold text-red-600">{{ number_format($unit['total_pengeluaran'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                        <p class="text-[10px] {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-600' }} mb-0.5">Laba/Rugi</p>
                                        <p class="text-sm font-bold {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                            {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- === Unit TANPA Sub-Unit: Tampilkan Ringkasan Langsung === --}}
                        <div class="p-5">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="bg-green-50 rounded-xl p-4 text-center">
                                    <p class="text-xs text-green-600 uppercase font-medium tracking-wider mb-1">Pendapatan</p>
                                    <p class="text-xl font-bold text-green-600">{{ number_format($unit['total_pendapatan'], 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-red-50 rounded-xl p-4 text-center">
                                    <p class="text-xs text-red-600 uppercase font-medium tracking-wider mb-1">Pengeluaran</p>
                                    <p class="text-xl font-bold text-red-600">{{ number_format($unit['total_pengeluaran'], 0, ',', '.') }}</p>
                                </div>
                                <div class="{{ $unit['total_laba_rugi'] >= 0 ? 'bg-primary/10' : 'bg-red-50' }} rounded-xl p-4 text-center">
                                    <p class="text-xs {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-600' }} uppercase font-medium tracking-wider mb-1">Laba / Rugi</p>
                                    <p class="text-xl font-bold {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @if(!empty($unit['keterangan']))
                                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500 uppercase font-medium mb-1">Keterangan</p>
                                    <p class="text-sm text-gray-700">{{ $unit['keterangan'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Laporan</h3>
                <p class="text-sm text-gray-500">Belum ada data laporan keuangan untuk periode {{ $rekap['periode'] }}.</p>
            </div>
        </div>
    @endif

    {{-- Grand Total Section --}}
    @if(count($rekapPerUnit) > 0)
        <div class="bg-gradient-to-r from-primary/5 via-white to-primary/5 rounded-2xl border-2 border-primary/20 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Grand Total — {{ $rekap['periode'] }}</h3>
                        <p class="text-sm text-gray-500">Rekapitulasi seluruh unit usaha</p>
                    </div>
                </div>

                {{-- Desktop Grand Total --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-primary/20">
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit Usaha</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Pendapatan</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Pengeluaran</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Laba/Rugi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($rekapPerUnit as $unit)
                                    <tr class="hover:bg-primary/5 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <span class="text-sm font-medium text-gray-800">{{ $unit['nama_unit'] }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <span class="text-sm font-semibold text-green-600">{{ number_format($unit['total_pendapatan'], 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <span class="text-sm font-semibold text-red-600">{{ number_format($unit['total_pengeluaran'], 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <span class="text-sm font-bold {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                                {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary/10 border-t-2 border-primary/30">
                                    <td class="px-5 py-4">
                                        <span class="font-bold text-gray-900 text-base">GRAND TOTAL</span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="font-bold text-green-600 text-lg">{{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="font-bold text-red-600 text-lg">{{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex flex-col items-end">
                                            <span class="font-bold text-xl {{ $rekap['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                                {{ $rekap['laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($rekap['laba_rugi']), 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs {{ $rekap['laba_rugi'] >= 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                                                {{ $rekap['laba_rugi'] >= 0 ? '✓ Laba' : '✗ Rugi' }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Mobile Grand Total --}}
                <div class="sm:hidden space-y-3">
                    @foreach($rekapPerUnit as $unit)
                        <div class="bg-white rounded-xl border border-gray-100 p-3">
                            <p class="text-sm font-semibold text-gray-800 mb-2">{{ $unit['nama_unit'] }}</p>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="text-center">
                                    <p class="text-[10px] text-green-600 uppercase">Pendapatan</p>
                                    <p class="text-xs font-bold text-green-600">{{ number_format($unit['total_pendapatan'], 0, ',', '.') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-red-600 uppercase">Pengeluaran</p>
                                    <p class="text-xs font-bold text-red-600">{{ number_format($unit['total_pengeluaran'], 0, ',', '.') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-600' }} uppercase">Laba/Rugi</p>
                                    <p class="text-xs font-bold {{ $unit['total_laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ $unit['total_laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($unit['total_laba_rugi']), 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="bg-primary/10 rounded-xl p-4 border-2 border-primary/20">
                        <p class="font-bold text-gray-900 text-sm mb-3 text-center">GRAND TOTAL</p>
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                <p class="text-[10px] text-green-600 mb-0.5">Pendapatan</p>
                                <p class="text-xs font-bold text-green-600">{{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                <p class="text-[10px] text-red-600 mb-0.5">Pengeluaran</p>
                                <p class="text-xs font-bold text-red-600">{{ number_format($rekap['total_pengeluaran'], 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white/80 rounded-lg p-2.5 text-center">
                                <p class="text-[10px] {{ $rekap['laba_rugi'] >= 0 ? 'text-primary-dark' : 'text-red-600' }} mb-0.5">Laba/Rugi</p>
                                <p class="text-sm font-bold {{ $rekap['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                    {{ $rekap['laba_rugi'] < 0 ? '-' : '' }}{{ number_format(abs($rekap['laba_rugi']), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <p class="text-center text-xs {{ $rekap['laba_rugi'] >= 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                            {{ $rekap['laba_rugi'] >= 0 ? '✓ Laba Bersih' : '✗ Rugi Bersih' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    @media print {
        nav, footer, .scroll-indicator, button[onclick="window.print()"], a[title="Share via WhatsApp"], a[title="Download PDF"], a[title="Download Excel"] {
            display: none !important;
        }
        .bg-gradient-to-r {
            background: #86ae5f !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .rounded-2xl {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }
    }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endpush
