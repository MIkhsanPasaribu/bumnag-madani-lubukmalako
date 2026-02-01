@extends('layouts.admin')

@section('title', 'Log Aktivitas Transaksi')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.transaksi-kas.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Aktivitas Transaksi</h1>
            <p class="text-gray-600 mt-1">Audit trail perubahan data transaksi kas</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="bento-card">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Perubahan</h3>
            <span class="text-sm text-gray-500">{{ $activities->total() }} aktivitas</span>
        </div>
        
        @if($activities->count() > 0)
            <div class="overflow-x-auto">
                <table class="data-table w-full">
                    <thead>
                        <tr>
                            <th class="text-left w-40">Waktu</th>
                            <th class="text-left w-28">Tindakan</th>
                            <th class="text-left">Deskripsi</th>
                            <th class="text-left w-36">Oleh</th>
                            <th class="text-left">Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="text-sm text-gray-600">
                                    <div>{{ $activity->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $activity->created_at->format('H:i:s') }}</div>
                                </td>
                                <td>
                                    @php
                                        $eventColors = [
                                            'created' => 'bg-green-100 text-green-700',
                                            'updated' => 'bg-blue-100 text-blue-700',
                                            'deleted' => 'bg-red-100 text-red-700',
                                        ];
                                        $eventLabels = [
                                            'created' => 'Dibuat',
                                            'updated' => 'Diubah',
                                            'deleted' => 'Dihapus',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $eventColors[$activity->event] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $eventLabels[$activity->event] ?? ucfirst($activity->event) }}
                                    </span>
                                </td>
                                <td class="text-sm">
                                    {{ $activity->description }}
                                    @if($activity->subject)
                                        <div class="text-xs text-gray-500 mt-1">
                                            ID: {{ $activity->subject_id }} | 
                                            @if($activity->subject->tanggal ?? null)
                                                Tanggal: {{ $activity->subject->tanggal->format('d/m/Y') }}
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="text-sm text-gray-600">
                                    @if($activity->causer)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-primary">
                                                    {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span>{{ $activity->causer->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Sistem</span>
                                    @endif
                                </td>
                                <td class="text-xs">
                                    @if($activity->properties && count($activity->properties) > 0)
                                        @if(isset($activity->properties['old']) && isset($activity->properties['attributes']))
                                            <div class="space-y-1 max-w-xs">
                                                @foreach($activity->properties['attributes'] as $key => $newValue)
                                                    @if(isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] !== $newValue)
                                                        <div class="flex flex-col">
                                                            <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                            <div class="flex items-center gap-1">
                                                                <span class="text-red-600 line-through">{{ is_array($activity->properties['old'][$key]) ? json_encode($activity->properties['old'][$key]) : Str::limit($activity->properties['old'][$key], 20) }}</span>
                                                                <span class="text-gray-400">→</span>
                                                                <span class="text-green-600">{{ is_array($newValue) ? json_encode($newValue) : Str::limit($newValue, 20) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @elseif(isset($activity->properties['attributes']))
                                            <div class="text-gray-500">{{ count($activity->properties['attributes']) }} fields</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-4">
                {{ $activities->links('components.pagination') }}
            </div>
        @else
            <x-empty-state 
                title="Belum ada aktivitas"
                description="Log aktivitas akan muncul setelah ada perubahan data transaksi."
                icon="document"
            />
        @endif
    </div>
    
    {{-- Legend --}}
    <div class="mt-6 bento-card">
        <h4 class="font-medium text-gray-900 mb-3">Keterangan</h4>
        <div class="flex flex-wrap gap-4 text-sm">
            <div class="flex items-center gap-2">
                <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">Dibuat</span>
                <span class="text-gray-600">Transaksi baru ditambahkan</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">Diubah</span>
                <span class="text-gray-600">Data transaksi diperbarui</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-700">Dihapus</span>
                <span class="text-gray-600">Transaksi dihapus</span>
            </div>
        </div>
    </div>
@endsection
