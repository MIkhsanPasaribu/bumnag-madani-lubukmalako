@extends('layouts.app')

@section('title', 'Beranda - BUMNag Madani Lubuk Malako')
@section('page-title', 'Beranda')

@section('content')
<div class="space-y-8">
    <div class="bento-card-accent">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-24 w-auto bg-white rounded-xl p-2">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang di BUMNag Madani</h1>
                <p class="text-white/90">Badan Usaha Milik Nagari Lubuk Malako - Membangun Nagari, Mensejahterakan Masyarakat</p>
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('profil') }}" class="inline-flex items-center gap-2 bg-white text-bumnag-olive px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                        <span>Lihat Profil</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-bumnag-olive/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-bumnag-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-xl font-bold text-bumnag-gray">Rp {{ number_format($laporanTerbaru?->pendapatan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-bumnag-red/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-bumnag-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pengeluaran</p>
                    <p class="text-xl font-bold text-bumnag-gray">Rp {{ number_format($laporanTerbaru?->pengeluaran ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Laba/Rugi</p>
                    <p class="text-xl font-bold {{ ($laporanTerbaru?->laba_rugi ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($laporanTerbaru?->laba_rugi ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Aset</p>
                    <p class="text-xl font-bold text-bumnag-gray">Rp {{ number_format($laporanTerbaru?->aset ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bento-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-bumnag-gray">Statistik Keuangan Tahunan</h3>
                <a href="{{ route('keuangan.statistik') }}" class="text-sm text-bumnag-olive hover:underline">Lihat Detail</a>
            </div>
            <div class="h-64">
                <canvas id="chartKeuangan"></canvas>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-bumnag-gray">Pengumuman</h3>
                <a href="{{ route('pengumuman') }}" class="text-sm text-bumnag-olive hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($pengumumanAktif as $item)
                <div class="p-3 bg-gray-50 rounded-xl">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-2 rounded-full {{ $item->prioritas === 'tinggi' ? 'bg-red-500' : ($item->prioritas === 'sedang' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                        <div>
                            <p class="font-medium text-sm text-bumnag-gray">{{ $item->judul }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada pengumuman</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="section-title">Berita Terbaru</h3>
            <a href="{{ route('berita.index') }}" class="btn-outline text-sm py-2">Lihat Semua</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($beritaTerbaru as $berita)
            <a href="{{ route('berita.show', $berita) }}" class="bento-card group">
                @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-40 object-cover rounded-xl mb-4">
                @else
                <div class="w-full h-40 bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 rounded-xl mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-bumnag-olive/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                @endif
                <p class="text-xs text-bumnag-olive font-medium mb-2">{{ $berita->kategori ?? 'Berita' }}</p>
                <h4 class="font-semibold text-bumnag-gray group-hover:text-bumnag-olive transition mb-2">{{ $berita->judul }}</h4>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $berita->ringkasan }}</p>
                <p class="text-xs text-gray-400 mt-3">{{ $berita->published_at?->format('d M Y') }}</p>
            </a>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Belum ada berita</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartKeuangan');
    if (ctx) {
        const data = @json($statistikKeuangan);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(d => d.tahun),
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: data.map(d => d.total_pendapatan),
                        backgroundColor: '#A5A71C',
                        borderRadius: 8,
                    },
                    {
                        label: 'Pengeluaran',
                        data: data.map(d => d.total_pengeluaran),
                        backgroundColor: '#8B1A1A',
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
