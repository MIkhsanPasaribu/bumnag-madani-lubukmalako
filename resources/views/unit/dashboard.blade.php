@extends('layouts.unit')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard ' . $unit->nama)

@section('content')
<div class="space-y-6">
    {{-- Welcome --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 text-white">
        <h2 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-white/80 mt-1">Panel {{ $unit->nama }} — Tahun {{ $tahun }}</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Pendapatan</span>
            </div>
            <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Pengeluaran</span>
            </div>
            <p class="text-xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Laba/Rugi</span>
            </div>
            <p class="text-xl font-bold {{ $totalLabaRugi >= 0 ? 'text-primary' : 'text-red-600' }}">
                {{ $totalLabaRugi >= 0 ? '+' : '' }}Rp {{ number_format($totalLabaRugi, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Jumlah Laporan</span>
            </div>
            <p class="text-xl font-bold text-gray-900">{{ $jumlahLaporan }}</p>
        </div>
    </div>

    {{-- Rekap Sub Unit (jika ada) --}}
    @if(count($rekapSubUnit) > 0)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Rekap Per Sub Unit</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($rekapSubUnit as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">{{ $item['sub_unit']->nama }}</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pendapatan</span>
                                <span class="font-semibold text-green-600">{{ number_format($item['pendapatan'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pengeluaran</span>
                                <span class="font-semibold text-red-600">{{ number_format($item['pengeluaran'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="font-medium text-gray-700">Laba/Rugi</span>
                                <span class="font-bold {{ $item['laba_rugi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                    {{ $item['laba_rugi'] >= 0 ? '+' : '' }}{{ number_format($item['laba_rugi'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Chart --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Grafik Bulanan {{ $tahun }}</h3>
        <canvas id="chartBulanan" height="100"></canvas>
    </div>

    {{-- Laporan Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Laporan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Periode</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sub Unit</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Pendapatan</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Pengeluaran</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Laba/Rugi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporanTerbaru as $lap)
                        <tr>
                            <td class="px-4 py-3">{{ $lap->periode }}</td>
                            <td class="px-4 py-3">{{ $lap->subUnit?->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-right text-green-600">{{ number_format($lap->pendapatan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-red-600">{{ number_format($lap->pengeluaran, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-semibold {{ $lap->laba_rugi >= 0 ? 'text-primary' : 'text-red-600' }}">
                                {{ $lap->laba_rugi >= 0 ? '+' : '' }}{{ number_format($lap->laba_rugi, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const chartData = @json($chartData);
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: chartData.map(d => d.bulan),
            datasets: [
                { label: 'Pendapatan', data: chartData.map(d => d.pendapatan), backgroundColor: 'rgba(134,174,95,0.7)', borderColor: '#86ae5f', borderWidth: 1 },
                { label: 'Pengeluaran', data: chartData.map(d => d.pengeluaran), backgroundColor: 'rgba(183,30,66,0.7)', borderColor: '#b71e42', borderWidth: 1 },
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } },
            plugins: { tooltip: { callbacks: { label: ctx => ctx.dataset.label + ': Rp ' + ctx.raw.toLocaleString('id-ID') } } }
        }
    });
</script>
@endpush
