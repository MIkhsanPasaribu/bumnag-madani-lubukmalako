@extends('layouts.app')

@section('title', 'Beranda - BUMNag Madani Lubuk Malako')
@section('page-title', 'Beranda')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="bento-card-accent">
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl p-2 flex items-center justify-center shrink-0 shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-full w-auto object-contain">
            </div>
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Selamat Datang</h1>
                <p class="text-white/90 text-sm sm:text-base mb-4">Badan Usaha Milik Nagari Lubuk Malako - Membangun Nagari, Mensejahterakan Masyarakat</p>
                <a href="{{ route('profil') }}" class="btn-white">
                    <span>Lihat Profil</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-bumnag-olive/10">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-bumnag-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="stat-label">Pendapatan</p>
                    <p class="stat-value">Rp {{ number_format(($laporanTerbaru?->pendapatan ?? 0) / 1000000, 0, ',', '.') }}jt</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-bumnag-red/10">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-bumnag-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="stat-label">Pengeluaran</p>
                    <p class="stat-value">Rp {{ number_format(($laporanTerbaru?->pengeluaran ?? 0) / 1000000, 0, ',', '.') }}jt</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon {{ ($laporanTerbaru?->laba_rugi ?? 0) >= 0 ? 'bg-green-100' : 'bg-red-100' }}">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 {{ ($laporanTerbaru?->laba_rugi ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="stat-label">Laba/Rugi</p>
                    <p class="stat-value {{ ($laporanTerbaru?->laba_rugi ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format(($laporanTerbaru?->laba_rugi ?? 0) / 1000000, 0, ',', '.') }}jt
                    </p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-blue-100">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="stat-label">Total Aset</p>
                    <p class="stat-value">Rp {{ number_format(($laporanTerbaru?->aset ?? 0) / 1000000, 0, ',', '.') }}jt</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <div class="lg:col-span-2 bento-card">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 lg:mb-6">
                <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray">Statistik Keuangan Tahunan</h3>
                <a href="{{ route('keuangan.statistik') }}" class="text-xs lg:text-sm text-bumnag-olive hover:underline font-medium">Lihat Detail &rarr;</a>
            </div>
            <div class="h-48 sm:h-56 lg:h-64">
                <canvas id="chartKeuangan"></canvas>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray">Pengumuman</h3>
                <a href="{{ route('pengumuman') }}" class="text-xs lg:text-sm text-bumnag-olive hover:underline font-medium">Semua</a>
            </div>
            <div class="space-y-3 max-h-48 lg:max-h-56 overflow-y-auto scrollbar-thin">
                @forelse($pengumumanAktif as $item)
                <div class="p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-1.5 rounded-full shrink-0 {{ $item->prioritas === 'tinggi' ? 'bg-red-500' : ($item->prioritas === 'sedang' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-sm text-bumnag-gray line-clamp-2">{{ $item->judul }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Belum ada pengumuman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 lg:mb-6">
            <h3 class="section-title">Berita Terbaru</h3>
            <a href="{{ route('berita.index') }}" class="btn-outline text-sm py-2 self-start sm:self-auto">Lihat Semua</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @forelse($beritaTerbaru as $berita)
            <a href="{{ route('berita.show', $berita) }}" class="news-card">
                @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="news-card-image">
                @else
                <div class="news-card-image bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 flex items-center justify-center">
                    <svg class="w-10 h-10 text-bumnag-olive/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                @endif
                <div class="news-card-content">
                    <span class="inline-block text-xs text-bumnag-olive font-semibold bg-bumnag-olive/10 px-2 py-0.5 rounded mb-2">{{ $berita->kategori ?? 'Berita' }}</span>
                    <h4 class="font-semibold text-bumnag-gray group-hover:text-bumnag-olive transition text-sm lg:text-base mb-2 line-clamp-2">{{ $berita->judul }}</h4>
                    <p class="text-xs lg:text-sm text-gray-500 line-clamp-2 mb-3">{{ $berita->ringkasan }}</p>
                    <p class="text-xs text-gray-400">{{ $berita->published_at?->format('d M Y') }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 bento-card">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
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
                        borderRadius: 6,
                        barThickness: 'flex',
                        maxBarThickness: 40,
                    },
                    {
                        label: 'Pengeluaran',
                        data: data.map(d => d.total_pengeluaran),
                        backgroundColor: '#8B1A1A',
                        borderRadius: 6,
                        barThickness: 'flex',
                        maxBarThickness: 40,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 16,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            font: {
                                size: 10
                            },
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                                }
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
