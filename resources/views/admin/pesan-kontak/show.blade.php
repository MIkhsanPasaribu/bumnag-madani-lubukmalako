@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesan</h1>
            <p class="text-gray-600 mt-1">Pesan dari {{ $pesan_kontak->nama }}</p>
        </div>
        <a href="{{ route('admin.pesan-kontak.index') }}" class="btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Pesan --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $pesan_kontak->subjek }}</h3>
                            <p class="text-xs text-gray-500">Dikirim {{ $pesan_kontak->created_at->format('d M Y, H:i') }} ({{ $pesan_kontak->created_at->diffForHumans() }})</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($pesan_kontak->pesan)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-6">
            {{-- Pengirim Info --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Info Pengirim</h3>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <span class="text-primary font-bold text-lg">{{ strtoupper(substr($pesan_kontak->nama, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $pesan_kontak->nama }}</p>
                            @if($pesan_kontak->organisasi)
                                <p class="text-sm text-gray-500">{{ $pesan_kontak->organisasi }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-3 space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <a href="mailto:{{ $pesan_kontak->email }}" class="text-primary hover:underline">{{ $pesan_kontak->email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Status</h3>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $pesan_kontak->status_badge }}">
                            {{ $pesan_kontak->status_label }}
                        </span>
                    </div>
                    
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Diterima: {{ $pesan_kontak->created_at->format('d M Y, H:i') }}</p>
                        @if($pesan_kontak->dibaca_at)
                            <p>Dibaca: {{ $pesan_kontak->dibaca_at->format('d M Y, H:i') }}</p>
                        @endif
                        @if($pesan_kontak->dibalas_at)
                            <p>Dibalas: {{ $pesan_kontak->dibalas_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Aksi</h3>
                </div>
                <div class="p-5 space-y-3">
                    <a href="mailto:{{ $pesan_kontak->email }}?subject=Re: {{ $pesan_kontak->subjek }}" 
                       class="btn-primary w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Balas via Email
                    </a>
                    
                    <form action="{{ route('admin.pesan-kontak.destroy', $pesan_kontak) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
