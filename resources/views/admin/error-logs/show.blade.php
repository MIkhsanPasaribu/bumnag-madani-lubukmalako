@extends('layouts.admin')

@section('title', 'Detail Error Log')
@section('page_title', 'Detail Error Log')

@section('header')
    @include('components.page-header', [
        'title' => 'Detail Error Log',
        'subtitle' => 'Informasi lengkap error #' . $errorLog->id,
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Error Logs', 'route' => 'admin.error-logs.index'],
            ['label' => 'Detail #' . $errorLog->id],
        ]
    ])
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Utama --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Error Message --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $errorLog->level_color }}">
                            {{ strtoupper($errorLog->level) }}
                        </span>
                        <h3 class="font-semibold text-gray-900">Error Message</h3>
                    </div>
                    <span class="text-xs text-gray-500">ID: #{{ $errorLog->id }}</span>
                </div>
                <div class="p-4">
                    <p class="text-gray-800 text-sm leading-relaxed break-words">{{ $errorLog->message }}</p>
                    
                    @if($errorLog->exception_class)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Exception Class:</p>
                            <code class="text-sm text-red-600 bg-red-50 px-2 py-1 rounded font-mono break-all">
                                {{ $errorLog->exception_class }}
                            </code>
                        </div>
                    @endif

                    @if($errorLog->file)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Lokasi Error:</p>
                            <code class="text-sm text-gray-700 bg-gray-50 px-2 py-1 rounded font-mono break-all">
                                {{ $errorLog->short_file }}@if($errorLog->line):{{ $errorLog->line }}@endif
                            </code>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Stack Trace --}}
            @if($errorLog->stack_trace)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Stack Trace</h3>
                        <button onclick="toggleStackTrace()" class="text-sm text-primary hover:text-primary-dark font-medium" id="toggle-btn">
                            Sembunyikan
                        </button>
                    </div>
                    <div id="stack-trace-content" class="p-4">
                        <pre class="text-xs text-gray-700 bg-gray-900 text-green-400 rounded-lg p-4 overflow-x-auto max-h-[500px] overflow-y-auto font-mono leading-relaxed whitespace-pre-wrap break-words">{{ $errorLog->stack_trace }}</pre>
                    </div>
                </div>
            @endif

            {{-- Request Data --}}
            @if($errorLog->request_data && count($errorLog->request_data) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Request Data (Disanitasi)</h3>
                    </div>
                    <div class="p-4">
                        <pre class="text-xs text-gray-700 bg-gray-50 rounded-lg p-4 overflow-x-auto font-mono">{{ json_encode($errorLog->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif

            {{-- Additional Context --}}
            @if($errorLog->additional_context && count($errorLog->additional_context) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Konteks Tambahan</h3>
                    </div>
                    <div class="p-4">
                        <pre class="text-xs text-gray-700 bg-gray-50 rounded-lg p-4 overflow-x-auto font-mono">{{ json_encode($errorLog->additional_context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-6">
            {{-- Request Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Informasi Request</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">URL</p>
                        <p class="text-sm text-gray-800 font-mono break-all">{{ $errorLog->url ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Method</p>
                        <p class="text-sm">
                            @if($errorLog->method)
                                <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold
                                    {{ $errorLog->method === 'GET' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $errorLog->method === 'POST' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $errorLog->method === 'PUT' || $errorLog->method === 'PATCH' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $errorLog->method === 'DELETE' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $errorLog->method }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">IP Address</p>
                        <p class="text-sm text-gray-800 font-mono">{{ $errorLog->ip_address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">User Agent</p>
                        <p class="text-xs text-gray-600 break-all">{{ $errorLog->user_agent ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- User Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">User Terkait</h3>
                </div>
                <div class="p-4">
                    @if($errorLog->user)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="text-primary font-semibold text-sm">{{ substr($errorLog->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $errorLog->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $errorLog->user->email }}</p>
                                <p class="text-xs text-gray-400">{{ $errorLog->user->getRoleLabel() }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-400">Pengunjung (tidak login)</p>
                    @endif
                </div>
            </div>

            {{-- Waktu & Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Waktu & Status</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Terjadi Pada</p>
                        <p class="text-sm text-gray-800">{{ $errorLog->created_at->format('d F Y, H:i:s') }}</p>
                        <p class="text-xs text-gray-500">{{ $errorLog->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Status</p>
                        @if($errorLog->is_read)
                            <span class="inline-flex items-center gap-1 text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded-full">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Sudah Dibaca
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs text-red-700 bg-red-100 px-2 py-0.5 rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                Belum Dibaca
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-2">
                <a href="{{ route('admin.error-logs.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <form action="{{ route('admin.error-logs.destroy', $errorLog) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2"
                        onclick="return confirm('Hapus error log ini secara permanen?')">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Error Log
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleStackTrace() {
        const content = document.getElementById('stack-trace-content');
        const btn = document.getElementById('toggle-btn');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            btn.textContent = 'Sembunyikan';
        } else {
            content.style.display = 'none';
            btn.textContent = 'Tampilkan';
        }
    }
</script>
@endpush
