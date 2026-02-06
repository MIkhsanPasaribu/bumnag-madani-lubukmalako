@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesan Masuk</h1>
            <p class="text-gray-600 mt-1">Pesan dari pengunjung melalui form Hubungi Kami</p>
        </div>
        <div class="flex items-center gap-2">
            @if($totalBelumDibaca > 0)
            <form action="{{ route('admin.pesan-kontak.tandai-semua-dibaca') }}" method="POST">
                @csrf
                <button type="submit" class="btn-ghost text-sm" onclick="return confirm('Tandai semua pesan sebagai dibaca?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-600">{{ $totalPesan }}</p>
                <p class="text-xs text-gray-500 truncate">Total Pesan</p>
            </div>
        </div>

        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-red-600">{{ $totalBelumDibaca }}</p>
                <p class="text-xs text-gray-500 truncate">Belum Dibaca</p>
            </div>
        </div>

        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-blue-600">{{ $totalDibaca }}</p>
                <p class="text-xs text-gray-500 truncate">Dibaca</p>
            </div>
        </div>

        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-green-600">{{ $totalDibalas }}</p>
                <p class="text-xs text-gray-500 truncate">Dibalas</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat mb-6">
        <form action="{{ route('admin.pesan-kontak.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="cari" value="{{ request('cari') }}" 
                       placeholder="Cari nama, email, subjek..." 
                       class="form-input flex-1">
                
                <select name="status" class="form-input sm:w-48">
                    <option value="">Semua Status</option>
                    <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="dibaca" {{ request('status') == 'dibaca' ? 'selected' : '' }}>Dibaca</option>
                    <option value="dibalas" {{ request('status') == 'dibalas' ? 'selected' : '' }}>Dibalas</option>
                </select>
                
                <button type="submit" class="btn-primary flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
                
                @if(request()->hasAny(['cari', 'status']))
                <a href="{{ route('admin.pesan-kontak.index') }}" class="btn-ghost flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Daftar Pesan --}}
    @if($pesanList->count() > 0)
        <div class="space-y-3">
            @foreach($pesanList as $pesan)
                <div class="bg-white rounded-xl border {{ $pesan->isBelumDibaca() ? 'border-red-200 bg-red-50/30' : 'border-gray-200' }} shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="p-4 md:p-5">
                        <div class="flex flex-col md:flex-row md:items-start gap-4">
                            {{-- Avatar --}}
                            <div class="flex-shrink-0 hidden md:block">
                                <div class="w-12 h-12 rounded-full {{ $pesan->isBelumDibaca() ? 'bg-red-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <span class="font-semibold {{ $pesan->isBelumDibaca() ? 'text-red-600' : 'text-gray-500' }}">
                                        {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-gray-900 {{ $pesan->isBelumDibaca() ? 'font-bold' : '' }}">
                                        {{ $pesan->nama }}
                                    </h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pesan->status_badge }}">
                                        {{ $pesan->status_label }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-700 mb-1">{{ $pesan->subjek }}</p>
                                <p class="text-sm text-gray-500 line-clamp-2">{{ $pesan->pesan }}</p>
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-400">
                                    <span>{{ $pesan->email }}</span>
                                    @if($pesan->organisasi)
                                        <span>&bull; {{ $pesan->organisasi }}</span>
                                    @endif
                                    <span>&bull; {{ $pesan->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('admin.pesan-kontak.show', $pesan) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-sm text-primary hover:bg-primary/10 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>
                                <form action="{{ route('admin.pesan-kontak.destroy', $pesan) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pesanList->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bento-card-flat text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Pesan</h3>
            <p class="text-gray-500">
                @if(request()->hasAny(['cari', 'status']))
                    Tidak ditemukan pesan yang sesuai dengan filter.
                @else
                    Pesan dari pengunjung akan muncul di sini.
                @endif
            </p>
        </div>
    @endif
@endsection
