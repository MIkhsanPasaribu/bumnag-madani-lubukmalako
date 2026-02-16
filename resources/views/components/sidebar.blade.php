{{-- Admin Sidebar Component --}}

{{-- Mobile Overlay --}}
<div x-show="sidebarOpen" 
     x-cloak
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-50 transition-transform duration-300 lg:translate-x-0">
    
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-800">
        <img src="{{ $logoUrl }}" alt="Logo" class="h-10 w-auto">
        <div>
            <h2 class="text-white font-bold text-sm">BUMNag Madani</h2>
            <p class="text-gray-400 text-xs">Admin Panel</p>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    {{-- Navigation --}}
    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>
        
        {{-- Section: Konten --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Konten</p>
            
            {{-- Berita --}}
            <a href="{{ route('admin.berita.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.berita.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Kelola Berita
            </a>
            
            {{-- Laporan Tahunan --}}
            <a href="{{ route('admin.laporan-tahunan.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.laporan-tahunan.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Tahunan
            </a>
        </div>
        
        {{-- Section: Keuangan --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keuangan</p>
            
            {{-- Laporan Keuangan --}}
            <a href="{{ route('admin.laporan-keuangan.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.laporan-keuangan.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Laporan Keuangan
            </a>
        </div>
        
        {{-- Section: Galeri --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Media</p>
            
            {{-- Hero Slide --}}
            <a href="{{ route('admin.hero-slide.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.hero-slide.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                </svg>
                Hero Slide
            </a>
            
            {{-- Galeri BUMNag --}}
            <a href="{{ route('admin.galeri-bumnag.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.galeri-bumnag.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Galeri BUMNag
            </a>
        </div>
        
        {{-- Section: Akun --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Akun</p>
            
            {{-- Kelola Akun Unit --}}
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Kelola Akun Unit
            </a>
        </div>
        
        {{-- Section: Pengaturan --}}
        <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengaturan</p>
            
            {{-- Error Logs (hanya super_admin) --}}
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.error-logs.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.error-logs.*') ? 'bg-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    Error Logs
                    @if(isset($unreadErrorCount) && $unreadErrorCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadErrorCount > 99 ? '99+' : $unreadErrorCount }}</span>
                    @endif
                </a>
            @endif
            
            {{-- Profil BUMNag --}}
            <a href="{{ route('admin.profil.edit') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.profil.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Profil BUMNag
            </a>
            
            {{-- Informasi Kontak --}}
            <a href="{{ route('admin.kontak-info.edit') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.kontak-info.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Info Kontak
            </a>
            
            {{-- Pesan Masuk --}}
            <a href="{{ route('admin.pesan-kontak.index') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors text-white hover:bg-gray-800 {{ request()->routeIs('admin.pesan-kontak.*') ? 'bg-primary' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Pesan Masuk
                @php $pesanBelumDibaca = \App\Models\PesanKontak::belumDibaca()->count(); @endphp
                @if($pesanBelumDibaca > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pesanBelumDibaca }}</span>
                @endif
            </a>
        </div>
    </nav>
</aside>
